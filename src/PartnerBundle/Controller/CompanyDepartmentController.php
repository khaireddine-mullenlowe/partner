<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

/**
* @Rest\RouteResource("")
*
* @package PartnerBundle\Controller
*/
class CompanyDepartmentController extends MullenloweRestController
{
    const CONTEXT = 'CompanyDepartment';

    /**
     * @Rest\Get("/", name="_departments")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/department",
     *     summary="get departments",
     *     tags={"Department"},
     *     @SWG\Parameter(
     *         name="ids",
     *         in="query",
     *         type="array",
     *         required=false,
     *         description="company department id's",
     *         @SWG\Items(type="string")
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
     *         description="Target department collection",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyDepartmentComplete")),
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
        $companyDepartments = $this->getDoctrine()
            ->getRepository('PartnerBundle:CompanyDepartment')
            ->findByCriteria($request->query->all())
        ;

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $companyDepartments,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100)
        );

        return $this->createPaginatedView($pager);
    }
}

