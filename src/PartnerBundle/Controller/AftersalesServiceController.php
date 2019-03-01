<?php

namespace PartnerBundle\Controller;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use PartnerBundle\Entity\AftersalesService;
use PartnerBundle\Form\AftersalesServiceType;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AftersalesServiceController
 * @package PartnerBundle\Controller
 */
class AftersalesServiceController extends MullenloweRestController
{
    const CONTEXT = 'AftersalesService';
    const LIMIT = 20;

    /**
     * @Rest\Get("/types", name="_service_types")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/service/types",
     *     summary="Get Aftersales Services types",
     *     tags={"AftersalesService"},
     *     @SWG\Response(
     *         response=200,
     *         description="Aftersales Services types",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(type="string")),
     *                 ),
     *             }
     *         )
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @return View
     */
    public function getTypesAction()
    {
        $types = $this->get('doctrine')
            ->getRepository('PartnerBundle:AftersalesService')
            ->getTypes();

        return $this->createView($types);
    }

    /**
     * @Rest\Get(
     *     "/{id}",
     *     name="_service",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/service/{id}",
     *     summary="Get an AftersalesService by id",
     *     operationId="getAftersalesServiceById",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="aftersalesServiceId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target AftersalesService",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/AftersalesServiceComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @param int $id
     * @return View
     */
    public function getAction($id)
    {
        $service = $this->getDoctrine()
            ->getRepository('PartnerBundle:AftersalesService')
            ->find($id);
        if (!$service) {
            throw $this->createNotFoundException(sprintf('%s not found', self::CONTEXT));
        }

        return $this->createView($service);
    }

    /**
     * @Rest\Get("/", name="_services")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/service/",
     *     summary="get AftersalesService collection",
     *     operationId="cgetAftersalesService",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="type of AftersalesServices"
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="page number"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="max items per page"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target AftersalesServices",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/AftersalesServiceComplete")
     *                     ),
     *                 ),
     *             }
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return View
     */
    public function cgetAction(Request $request)
    {
        $aftersaleServiceRepo = $this->getDoctrine()->getRepository('PartnerBundle:AftersalesService');
        $queryBuilder = $aftersaleServiceRepo->createQueryBuilder('aftersales_service');
        $paginator = $this->get('knp_paginator');

        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', self::LIMIT);
        $filters = $request->query->all();

        if (isset($filters['type'])) {
            $queryBuilder
                ->andWhere('aftersales_service.type = :type')
                ->setParameter('type', $filters['type']);
        }

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $limit)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_service")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/service/",
     *     summary="create AftersalesService",
     *     operationId="createAftersalesService",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="aftersales_service",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/AftersalesService")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created AftersalesService",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/AftersalesServiceComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $service = new AftersalesService();
        $form = $this->createForm(AftersalesServiceType::class, $service);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($service);
        $em->flush();

        return $this->createView($service, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     "/{id}",
     *     name="_service",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/service/{id}",
     *     summary="remove AftersalesService by id",
     *     operationId="removeAftersalesServiceById",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="aftersalesServiceId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Delete acknowledge",
     *         @SWG\Schema(ref="#/definitions/Success")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param integer $id
     * @return View
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var AftersalesService $service
         */
        $service = $em->getRepository('PartnerBundle:AftersalesService')->find($id);
        if (!$service) {
            throw $this->createNotFoundException(sprintf('%s not found', self::CONTEXT));
        }

        $em->remove($service);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * @Rest\Put(
     *     "/{id}",
     *     name="_service",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     path="/service/{id}",
     *     summary="update AftersalesService by id",
     *     operationId="putAftersalesServiceById",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="aftersalesServiceId"
     *     ),
     *     @SWG\Parameter(
     *         name="aftersalesService",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/AftersalesService")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated AftersalesService",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/AftersalesServiceComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id);
    }

    /**
     * @Rest\Patch(
     *     "/{id}",
     *     name="_service",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Patch(
     *     path="/service/{id}",
     *     summary="patch AftersalesService by id",
     *     operationId="patchAftersalesServiceById",
     *     tags={"AftersalesService"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="aftersalesServiceId"
     *     ),
     *     @SWG\Parameter(
     *         name="aftersalesService",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/AftersalesService")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated AftersalesService",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/AftersalesServiceComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id, false);
    }

    /**
     * Handles put or patch action
     *
     * @param Request $request
     * @param int     $id
     * @param bool    $clearMissing
     *
     * @return View
     */
    private function putOrPatch(Request $request, int $id, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $service = $em->getRepository('PartnerBundle:AftersalesService')->find($id);
        if (!$service) {
            throw $this->createNotFoundException(sprintf('%s not found', self::CONTEXT));
        }

        $form = $this->createForm(AftersalesServiceType::class, $service);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($service);
    }
}
