<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PartnerBundle\Enum\PartnerTypeEnum;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class PartnerTypeController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'PartnerType';

    /**
     * @Rest\Get("", name="partner_type")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/type",
     *     summary="Get partner type collection",
     *     tags={"Partner type"},
     *     @SWG\Response(
     *         response=200,
     *         description="Partner type list",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(type="string")),
     *                 ),
     *             }
     *         )
     *     ),
     *
     *     security={{ "bearer":{} }}
     * )
     */
    public function getAction(Request $request)
    {

        return $this->createView(PartnerTypeEnum::getData());
    }
}
