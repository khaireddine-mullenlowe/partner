<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Form\PartnerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class PartnerController extends MullenloweRestController
{
    const CONTEXT = 'Partner';

    /**
     * @Rest\Get(
     *     "/{id}",
     *     name="_partner",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/{id}",
     *     summary="Get a Partner from id",
     *     operationId="getPartnerById",
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/PartnerComplete"),
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
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        return $this->createView($partner);
    }

    /**
     * @Rest\Get("/", name="_partners")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/",
     *     summary="get partners",
     *     operationId="getPartners",
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="registryUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="registryUserId"
     *     ),
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="myaudiUserId"
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
     *         description="Target Partners",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/PartnerComplete")),
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
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:Partner');

        $paginator = $this->get('knp_paginator');

        $queryBuilder = $repository->createQueryBuilder('partner');

        $this->applyFilters($queryBuilder, $request);

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Put(
     *     "/{id}",
     *     name="_partner",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="update partner from userId",
     *     operationId="putPartnerById",
     *     security={{ "bearer":{} }},
     *     path="/{id}",
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/PartnerComplete"),
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
     *     name="_partner",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Patch(
     *     path="/{id}",
     *     summary="patch partner from id",
     *     operationId="patchPartnerById",
     *     security={{ "bearer":{} }},
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/PartnerComplete"),
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
     * @Rest\Post("/", name="_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/",
     *     summary="create partner",
     *     operationId="createPartner",
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/PartnerComplete"),
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

        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($partner);
        $em->flush();

        return $this->createView($partner, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     "/{id}",
     *     name="_partner",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/{id}",
     *     summary="remove partner from id",
     *     operationId="removePartnerById",
     *     tags={"Partner"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
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
         * @var Partner $partner
         */
        $partner = $em->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $em->remove($partner);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * Applies filters from request
     * todo: move this method in a service
     *
     * @param QueryBuilder $builder
     * @param Request $request
     */
    private function applyFilters(QueryBuilder $builder, Request $request)
    {
        $registryUserId = $request->query->get('registryUserId');
        $myaudiUserId = $request->query->get('myaudiUserId');

        if ($registryUserId) {
            $builder
                ->join('partner.registryUsers', 'registryUsers')
                ->andWhere('registryUsers.registryUserId = :registryUserId')
                ->setParameter('registryUserId', $registryUserId);
        }

        if ($myaudiUserId) {
            $builder
                ->join('partner.myaudiUsers', 'myaudiUsers')
                ->andWhere('myaudiUsers.myaudiUserId = :myaudiUserId')
                ->setParameter('myaudiUserId', $myaudiUserId);
        }
    }

    /**
     * Handles put or patch action
     *
     * @param Request $request
     * @param int $id lead id
     * @param bool $clearMissing
     *
     * @return View
     */
    private function putOrPatch(Request $request, int $id, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $lead = $em->getRepository('PartnerBundle:Partner')->find($id);
        if (!$lead) {
            throw $this->createNotFoundException('Partner not found');
        }

        $form = $this->createForm(PartnerType::class, $lead);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($lead);
    }
}
