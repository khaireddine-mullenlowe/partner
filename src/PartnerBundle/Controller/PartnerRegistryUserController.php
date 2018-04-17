<?php

namespace PartnerBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use PartnerBundle\Entity\PartnerRegistryUser;
use PartnerBundle\Form\PartnerRegistryUserType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\QueryBuilder;

/**
 * @Rest\RouteResource("")
 *
 * Class PartnerRegistryUserController
 * @package PartnerBundle\Controller
 */
class PartnerRegistryUserController extends MullenloweRestController
{
    const CONTEXT = 'PartnerRegistryUser';

    /**
     * Finds and displays a PartnerRegistryUser entity collection.
     *
     * @Rest\Get("/", name="_partner_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/registry/",
     *     summary="Finds and displays a PartnerRegistryUser entity collection",
     *     operationId="cgetPartnerRegistryUser",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="registryUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Filter collection by RegistryUser Id"
     *     ),
     *     @SWG\Parameter(
     *         name="registryUserIds",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Filter collection by a string representation of an array of RegistryUser Ids seperated by ','"
     *     ),
     *     @SWG\Parameter(
     *         name="paginate",
     *         in="query",
     *         type="boolean",
     *         required=false,
     *         description="Whether to apply pagination to RegistryUser collection or not"
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
     *         description="PartnerRegistryUser collection",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/PartnerRegistryUserComplete")),
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
        $queryBuilder = $this->getDoctrine()
            ->getRepository('PartnerBundle:PartnerRegistryUser')
            ->createQueryBuilder('pru');
        $this->applyFilters($queryBuilder, $request);

        if ('0' === $request->query->get('paginate')) {
            $result = $queryBuilder
                ->orderBy('pru.id', 'ASC')
                ->getQuery()
                ->execute();

            return $this->createView($result);
        }

        $paginator = $this->get('knp_paginator');
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_partner_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/registry/",
     *     summary="Link partner and registry user",
     *     operationId="postPartnerRegistryUser",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="partner registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PartnerRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created link partner and registry user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/PartnerRegistryUserComplete")),
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

        $partnerRegistryUser = new PartnerRegistryUser();
        $form = $this->createForm(PartnerRegistryUserType::class, $partnerRegistryUser);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($partnerRegistryUser);
        $em->flush();

        return $this->createView($partnerRegistryUser, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/{id}", name="_partner_registry_user", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="update link partner registry user by id",
     *     operationId="putPartnerRegistryUserById",
     *     security={{ "bearer":{} }},
     *     path="/registry/{id}",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerRegistryUserId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PartnerRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated link partner and registry user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/PartnerRegistryUserComplete")),
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
     * @Rest\Post("/validate/", name="_partner_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/registry/validate/",
     *     summary="Validate PartnerRegistryUser",
     *     operationId="validatePartnerRegistryUser",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="partner registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/PartnerRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="the partnerRegistryUser is valid"
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="the partnerRegistryUser is not valid",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @return View
     */
    public function validateAction(Request $request)
    {
        $partnerRegistryUser = new PartnerRegistryUser();
        $form = $this->createForm(PartnerRegistryUserType::class, $partnerRegistryUser, ['validation_groups' => ['orchestrator']]);
        $form->handleRequest($request);
        // validate
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->createView(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view($form);
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

        $partnerRegistryUser = $em->getRepository('PartnerBundle:PartnerRegistryUser')->find($id);
        if (!$partnerRegistryUser) {
            throw $this->createNotFoundException('PartnerRegistryUser not found');
        }

        $form = $this->createForm(PartnerRegistryUserType::class, $partnerRegistryUser);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($partnerRegistryUser);
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
        if ($registryUserId = $request->query->get('registryUserId')) {
            $builder
                ->andWhere('pru.registryUserId = :registryUserId')
                ->setParameter('registryUserId', $registryUserId);
        } elseif ($registryUserIds = $request->query->get('registryUserIds')) {
            $registryUserIds = explode(',', $registryUserIds);
            $builder
                ->andWhere($builder->expr()->in('pru.registryUserId', ':registryUserIds'))
                ->setParameter('registryUserIds', $registryUserIds);
        }
    }
}
