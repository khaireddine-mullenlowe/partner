<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use PartnerBundle\Entity\PartnerMyaudiUser;
use PartnerBundle\Form\PartnerMyaudiUserType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PartnerMyaudiUserController
 * @package PartnerBundle\Controller
 */
class PartnerMyaudiUserController extends MullenloweRestController
{
    const CONTEXT = 'PartnerMyaudiUser';

    /**
     * Finds and displays a PartnerMyaudiUser entity collection.
     *
     * @Rest\Get("/", name="_partner_myaudi_user_collection")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/myaudi/",
     *     summary="Finds and displays a PartnerMyaudiUser entity collection",
     *     operationId="cgetPartnerMyaudiUser",
     *     tags={"Partner Myaudi User"},
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Filter collection by MyaudiUser Id"
     *     ),
     *     @SWG\Parameter(
     *         name="myaudiUserIds",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Filter collection by a string representation of an array of MyaudiUser Ids seperated by ','"
     *     ),
     *     @SWG\Parameter(
     *         name="partnerType",
     *         in="query",
     *         type="string",
     *         required=false,
     *         enum={
     *             PartnerBundle\Enum\PartnerTypeEnum::TYPE_SALES,
     *             PartnerBundle\Enum\PartnerTypeEnum::TYPE_AFTERSALES
     *         },
     *         description="Filter by partner type"
     *     ),
     *     @SWG\Parameter(
     *         name="paginate",
     *         in="query",
     *         type="boolean",
     *         required=false,
     *         description="Whether to apply pagination to MyaudiUser collection or not"
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
     *                         @SWG\Items(ref="#/definitions/PartnerMyaudiUserComplete")),
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
            ->getRepository('PartnerBundle:PartnerMyaudiUser')
            ->applyFilters($request->query->all());

        if ('0' === $request->query->get('paginate')) {
            $result = $queryBuilder
                ->orderBy('pmu.id', 'ASC')
                ->getQuery()
                ->execute();

            return $this->createView($result);
        }

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_partner_myaudi_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/myaudi/",
     *     summary="Link partner and myaudi user",
     *     operationId="postPartnerMyaudiUser",
     *     tags={"Partner Myaudi User"},
     *     @SWG\Parameter(
     *         name="partner myaudi user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PartnerMyaudiUser")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created link partner and myaudi user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/PartnerMyaudiUserComplete")
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

        // Check if already a MyaudiUser has a Partner of the same type
        /** @var PartnerMyaudiUser $partnerMyaudiUser */
        $partnerMyaudiUser = $em
            ->getRepository('PartnerBundle:PartnerMyaudiUser')
            ->getSingleResult($dataInput['myaudiUserId'], $partner->getType());

        if ($partnerMyaudiUser && $partnerMyaudiUser[0]) {
            $partnerMyaudiUser = $partnerMyaudiUser[0];

            // if it's the case and the incoming partner is different from the original one
            // then just replace the old partner by the new one
            // else do not update and just return the original PartnerMyaudiUser
            return $partnerMyaudiUser->getPartner()->getId() !== $partner->getId()
                ? $this->putOrPatch($request, $partnerMyaudiUser->getId())
                : $this->createView($partnerMyaudiUser);
        }

        // here is the creation of a new link between MyaudiUser and the Partner
        $partnerMyaudiUser = new PartnerMyaudiUser();
        $form = $this->createForm(PartnerMyaudiUserType::class, $partnerMyaudiUser);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($partnerMyaudiUser);
        $em->flush();

        return $this->createView($partnerMyaudiUser, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     "/{id}",
     *     name="partner_myaudi_user",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/myaudi/{id}",
     *     summary="delete partnerMyaudiUser by id",
     *     operationId="deletePartnerMyaudiUserById",
     *     tags={"Partner Myaudi User"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerMyaudiUserId"
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
         * @var PartnerMyaudiUser $partnerMyaudiUser
         */
        $partnerMyaudiUser = $em->getRepository('PartnerBundle:PartnerMyaudiUser')->find($id);
        if (!$partnerMyaudiUser) {
            throw new NotFoundHttpException(self::CONTEXT, 'PartnerMyaudiUser not found.');
        }

        $em->remove($partnerMyaudiUser);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * @Rest\Put(
     *     "/{id}",
     *     name="_partner_myaudi_user",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="update link partner myaudi user by id",
     *     operationId="putPartnerMyaudiUserById",
     *     security={{ "bearer":{} }},
     *     path="/myaudi/{id}",
     *     tags={"Partner Myaudi User"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerRMyaudiUserId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner myaudi user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PartnerMyaudiUser")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated link partner and myaudi user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/PartnerMyaudiUserComplete")
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

        $partnerMyaudiUser = $em->getRepository('PartnerBundle:PartnerMyaudiUser')->find($id);
        if (!$partnerMyaudiUser) {
            throw new NotFoundHttpException(self::CONTEXT, 'PartnerMyaudiUser not found');
        }

        $form = $this->createForm(PartnerMyaudiUserType::class, $partnerMyaudiUser);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($partnerMyaudiUser);
    }
}
