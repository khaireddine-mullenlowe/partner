<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


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
            ->findByCriteria($request->query->all());

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $companies,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
