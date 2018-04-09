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
class RegionController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'Region';

    /**
     * @Rest\Get("/", name="_region")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/region",
     *     summary="Get region collection",
     *     tags={"Region"},
     *     @SWG\Parameter(
     *         name="partnerType",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Type of partner (sales or aftersales)"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Region list",
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
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:Region');
        $queryBuilder = $repository->createQueryBuilder('r');
        $queryBuilder = $repository->applyFilterPartnerType(
            $queryBuilder,
            $request->query->get('partnerType', null),
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
