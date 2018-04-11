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
class CompanyPositionCodeController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'PartnerCompanyPositionCode';

    /**
     * @Rest\Get("/", name="_company_position_code")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/company/position/code",
     *     summary="Get position code collection",
     *     tags={"Position code"},
     *     @SWG\Parameter(
     *         name="deparment",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="deparment id"
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
     *         description="Position code list",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyPositionCode")),
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
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:CompanyPositionCode');
        $queryBuilder = $repository->createQueryBuilder('cpc');
        $queryBuilder = $repository->applyFilterDepartment(
            $queryBuilder,
            $request->query->get('department', null),
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
