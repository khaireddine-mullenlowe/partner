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
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Partner Api"
 *     ),
 *     @SWG\Tag(name="partner"),
 *     host="api5.audi.agence-one.net",
 *     basePath="/partner",
 *     schemes={"http", "https"},
 *     produces={"application/json"},
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"message"},
 *         @SWG\Property(
 *             property="message",
 *             type="string",
 *             default="Partner not found"
 *         )
 *     )
 * )
 *
 * @SWG\SecurityScheme(
 *   securityDefinition="bearer",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 *
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class PartnerController extends FOSRestController
{
    /**
     * @SWG\Get(
     *     path="/{id}",
     *     summary="get partner from id",
     *     operationId="getPartnerById",
     *     tags={"partner"},
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
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
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
     *
     * @SWG\Get(
     *     path="/",
     *     summary="get partners",
     *     operationId="getPartners",
     *     tags={"partner"},
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
     *         description="Partners",
     *         @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Partner"))
     *     ),
     * )
     * @Rest\View()
     *
     * @param Request $request
     * @return array
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

        return [
            'pagination' => [
                'total' => $pager->getTotalItemCount(),
                'count' => $pager->count(),
                'per_page' => $pager->getItemNumberPerPage(),
                'current_page' => $pager->getCurrentPageNumber(),
                'total_pages' => $pager->getPageCount(),
            ],
            'data' => $pager->getItems(),
        ];
    }

    /**
     * @SWG\Put(
     *     summary="update partner from userId",
     *     operationId="putPartnerById",
     *     security={{ "bearer":{} }},
     *     path="/{id}",
     *     tags={"partner"},
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
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
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
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $isPut = $request->getMethod() == "PUT";
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput, $isPut);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($partner);
    }

    /**
     * @SWG\Patch(
     *     path="/{id}",
     *     summary="patch partner from id",
     *     operationId="patchPartnerById",
     *     security={{ "bearer":{} }},
     *     tags={"partner"},
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
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
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
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $isPut = $request->getMethod() == "PUT";
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput, $isPut);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($partner);
    }

    /**
     * @SWG\Post(
     *     path="/",
     *     summary="create partner",
     *     operationId="createPartner",
     *     tags={"partner"},
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
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
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = new Partner();
        $em->persist($partner);
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
     * @SWG\Delete(
     *     path="/{id}",
     *     summary="remove partner from id",
     *     operationId="removePartnerById",
     *     tags={"partner"},
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
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *    ),
     *    security={{ "bearer":{} }}
     * )
     * @SWG\Definition(
     *     definition="Success",
     *     type="object",
     *     required={"success"},
     *     @SWG\Property(property="success", type="boolean")
     * )
     *
     * @Rest\View()
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
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $em->remove($partner);
        $em->flush();

        return $this->view(['context' => 'success', 'data' => ['success' => true]], Response::HTTP_OK);
    }

    protected function createView(Partner $partner, $statusCode = Response::HTTP_OK)
    {
        return $this->view(['context' => 'partner', 'data' => $partner], $statusCode);
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
}
