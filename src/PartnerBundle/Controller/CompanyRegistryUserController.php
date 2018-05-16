<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use PartnerBundle\Entity\CompanyRegistryUser;
use PartnerBundle\Form\CompanyRegistryUserType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\RouteResource("")
 *
 * Class CompanyRegistryUserController
 * @package PartnerBundle\Controller
 */
class CompanyRegistryUserController extends MullenloweRestController
{
    const CONTEXT = 'CompanyRegistryUser';

    /**
     * Finds and displays a CompanyRegistryUser entity collection.
     *
     * @Rest\Get("/", name="_company_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/registry/",
     *     summary="Finds and displays a CompanyRegistryUser entity collection",
     *     operationId="cgetCompanyRegistryUser",
     *     tags={"Company Registry User"},
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
     *         description="CompanyRegistryUser collection",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyRegistryUserComplete")),
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
            ->getRepository('PartnerBundle:CompanyRegistryUser')
            ->createQueryBuilder('cru');
        $this->applyFilters($queryBuilder, $request);

        if ('0' === $request->query->get('paginate')) {
            $result = $queryBuilder
                ->orderBy('cru.id', 'ASC')
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
     * @Rest\Post("/", name="_company_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/company/registry/",
     *     summary="Link company and registry user",
     *     operationId="postCompanyRegistryUser",
     *     tags={"Company Registry User"},
     *     @SWG\Parameter(
     *         name="company registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CompanyRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created link company and registry user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyRegistryUserComplete")),
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

        $companyRegistryUser = new CompanyRegistryUser();
        $form = $this->createForm(CompanyRegistryUserType::class, $companyRegistryUser);
        $form->handleRequest($request);
        // validate
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($companyRegistryUser);
            $em->flush();

            return $this->createView($companyRegistryUser, Response::HTTP_CREATED);
        }

        return $this->view($form);
    }

    /**
     * @Rest\Put("/{id}", name="_company_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     path="/company/registry/{id}",
     *     summary="Updates link between company and registry user",
     *     operationId="putCompanyRegistryUser",
     *     tags={"Company Registry User"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="companyRegistryUserId"
     *     ),
     *     @SWG\Parameter(
     *         name="company registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CompanyRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated link between company and registry user",
     *         @SWG\Schema(
     *            allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyRegistryUserComplete")),
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
     * @param int     $id
     *
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $companyRegistryUser = $em->getRepository('PartnerBundle:CompanyRegistryUser')->find($id);
        if (!$companyRegistryUser) {
            throw $this->createNotFoundException('CompanyRegistryUser not found');
        }

        $form = $this->createForm(CompanyRegistryUserType::class, $companyRegistryUser, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        // validate
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->createView($companyRegistryUser);
        }

        return $this->view($form);
    }

    /**
     * @Rest\Post("/validate/", name="_company_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/company/validate/",
     *     summary="Validate CompanyRegistryUser",
     *     operationId="validateCompanyRegistryUser",
     *     tags={"Company Registry User"},
     *     @SWG\Parameter(
     *         name="company registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CompanyRegistryUser")
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="the companyRegistryUser is valid"
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="the companyRegistryUser is not valid",
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
        $companyRegistryUser = new CompanyRegistryUser();
        $form = $this->createForm(CompanyRegistryUserType::class, $companyRegistryUser, ['validation_groups' => ['orchestrator']]);
        $form->handleRequest($request);
        // validate
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->createView(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view($form);
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
        if ($registryUserId = $request->query->getInt('registryUserId')) {
            $builder
                ->andWhere('cru.registryUserId = :registryUserId')
                ->setParameter('registryUserId', $registryUserId);
        } elseif ($registryUserIds = $request->query->get('registryUserIds')) {
            $registryUserIds = explode(',', $registryUserIds);
            $builder
                ->andWhere($builder->expr()->in('cru.registryUserId', ':registryUserIds'))
                ->setParameter('registryUserIds', $registryUserIds);
        }
    }
}
