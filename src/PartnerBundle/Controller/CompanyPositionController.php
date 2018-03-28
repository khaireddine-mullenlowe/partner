<?php

namespace PartnerBundle\Controller;

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
class CompanyPositionController extends MullenloweRestController
{
    const CONTEXT = 'CompanyPosition';

    /**
     * @Rest\Get("/", name="_positions")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/position",
     *     summary="get positions",
     *     tags={"Position"},
     *     @SWG\Parameter(
     *         name="deparmentId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="deparmentId"
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
     *         description="Target position collection",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyPositionComplete")),
     *                 ),
     *             }
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function cgetAction(Request $request)
    {
        $queryBuilder = $this->getDoctrine()->getRepository('PartnerBundle:CompanyPosition')
            ->createQueryBuilder('cp');

        if ($request->query->has('departmentId')) {
            $queryBuilder
                ->innerJoin('cp.departments', 'd')
                ->andWhere('d.id = :departmentId')
                ->setParameter('departmentId', $request->query->get('departmentId'));
        }

        /** @var SlidingPagination $pager */
        $pager = $this->get('knp_paginator')->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}

