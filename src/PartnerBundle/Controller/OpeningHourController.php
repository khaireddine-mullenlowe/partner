<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use PartnerBundle\Entity\OpeningHour;
use PartnerBundle\Form\OpeningHourType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OpeningHourController
 * @package PartnerBundle\Controller
 */
class OpeningHourController extends MullenloweRestController
{
    const CONTEXT = 'OpeningHour';
    const LIMIT = 20;

    /**
     * Finds and displays a OpeningHour entity collection.
     *
     * @Rest\Get("/", name="_opening_hour_collection")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/opening-hour/",
     *     summary="Finds and displays an OpeningHour entity collection",
     *     operationId="cgetOpeningHour",
     *     tags={"Opening Hour"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Filter collection by Partner Id"
     *     ),
     *     @SWG\Parameter(
     *         name="paginate",
     *         in="query",
     *         type="boolean",
     *         required=false,
     *         description="Whether to apply pagination to OpeningHours collection or not"
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
     *         description="PartnerMyaudiUser collection",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/OpeningHourComplete")),
     *                 ),
     *             }
     *         )
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @return View
     */
    public function cgetAction(Request $request)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getDoctrine()
            ->getRepository('PartnerBundle:OpeningHour')
            ->applyFilters($request->query->all());

        if ('0' === $request->query->get('paginate')) {
            $result = $queryBuilder
                ->orderBy('oh.id', 'ASC')
                ->getQuery()
                ->execute();

            return $this->createView($result);
        }

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_opening_hour")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/opening-hour/",
     *     summary="Link partner to created opening hour",
     *     operationId="postOpeningHour",
     *     tags={"opening Hour"},
     *     @SWG\Parameter(
     *         name="opening hour",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/OpeningHour")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created opening hour",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/OpeningHourComplete")
     *                     ),
     *                 ),
     *             }
     *         )
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

        $partner = $em->getRepository('PartnerBundle:Partner')->find($dataInput['partner']);
        if (!$partner) {
            throw new NotFoundHttpException(self::CONTEXT, 'Partner not found');
        }

        // here is the creation of a new Opening Hour
        $openingHour = new OpeningHour();
        $form = $this->createForm(OpeningHourType::class, $openingHour);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($openingHour);
        $em->flush();

        return $this->createView($openingHour, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     "/{id}",
     *     name="opening_hour",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/opening-hour/{id}",
     *     summary="delete openingHour by id",
     *     operationId="deleteOpeningHourById",
     *     tags={"Opening Hour"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="openingHourId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="delete status",
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
         * @var OpeningHour $openingHour
         */
        $openingHour = $em->getRepository('PartnerBundle:OpeningHour')->find($id);
        if (!$openingHour) {
            throw new NotFoundHttpException(self::CONTEXT, 'Opening Hour not found.');
        }

        $em->remove($openingHour);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * @Rest\Put(
     *     "/{id}",
     *     name="_opening_hour",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="update opening hour id",
     *     operationId="putOpeningHourId",
     *     security={{ "bearer":{} }},
     *     path="/opening-hour/{id}",
     *     tags={"Opening Hour"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="openingHourId"
     *     ),
     *     @SWG\Parameter(
     *         name="opening hour",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/OpeningHour")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated opening hour",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/OpeningHourComplete")
     *                     ),
     *                 ),
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
    public function putAction(Request $request, int $id)
    {
        return $this->putOrPatch($request, $id);
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

        $openingHour = $em->getRepository('PartnerBundle:OpeningHour')->find($id);
        if (!$openingHour) {
            throw new NotFoundHttpException(self::CONTEXT, 'Opening Hour not found');
        }

        $form = $this->createForm(OpeningHourType::class, $openingHour);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($openingHour);
    }
}
