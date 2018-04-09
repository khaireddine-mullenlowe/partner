<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use PartnerBundle\Enum\OperatorEnum;
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
    const LIMIT = 50;

    /**
     * @Rest\Get("/", name="_positions")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/position",
     *     summary="get positions",
     *     tags={"Position"},
     *     @SWG\Parameter(
     *         name="deparment",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="deparment id"
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
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:CompanyPosition');
        $queryBuilder = $repository->createQueryBuilder('cp');

        if ($request->query->has('department')) {
            $repository->applyFilterDepartment(
                $queryBuilder,
                $request->query->get('department'),
                $request->query->get('operator', OperatorEnum::EQUAL));
        }

        /** @var SlidingPagination $pager */
        $pager = $this->get('knp_paginator')->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}

