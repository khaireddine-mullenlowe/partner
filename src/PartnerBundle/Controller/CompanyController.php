<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use PartnerBundle\Entity\Company;
use PartnerBundle\Form\CompanyType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

/**
 * Class CompanyController
 * @package PartnerBundle\Controller
 */
class CompanyController extends MullenloweRestController
{
    const CONTEXT = 'Company';

    /**
     * @Rest\Get("/", name="_companies")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/",
     *     summary="get companies",
     *     operationId="getCompanies",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="company type id"
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
     *         description="Companies",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/CompanyComplete")
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
        $paginator = $this->get('knp_paginator');

        $companies = $this
            ->getDoctrine()
            ->getRepository('PartnerBundle:Company')
            ->findByCustomFilters($request->query->getInt('type'));

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $companies,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_company")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/company/",
     *     summary="create company",
     *     operationId="createCompany",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="company",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Company")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created company",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CompanyComplete"),
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

        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($company);
        $em->flush();

        return $this->createView($company, Response::HTTP_CREATED);
    }
}