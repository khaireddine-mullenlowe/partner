<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PartnerBundle\Enum\OperatorEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class DistrictController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'PartnerDistrict';

    /**
     * @Rest\Get("/", name="_district")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/district",
     *     summary="Get district collection",
     *     tags={"District"},
     *     @SWG\Parameter(
     *         name="region",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Filter by region id"
     *     ),
     *     @SWG\Parameter(
     *         name="operator",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Operator to filter (equal or different)"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="District list",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/Region")),
     *                 ),
     *             }
     *         )
     *     ),
     *
     *     security={{ "bearer":{} }}
     * )
     */
    public function cgetAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:District');
        $queryBuilder = $repository->createQueryBuilder('d');
        $queryBuilder = $repository->applyFilterRegion(
            $queryBuilder,
            $request->query->get('region', null),
            $request->query->get('operator', OperatorEnum::EQUAL)
        );

        /** @var SlidingPagination $pager */
        $pager = $this->get('knp_paginator')->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
