<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PartnerBundle\Enum\PartnerPrestigeTypeEnum;
use PartnerBundle\Enum\PartnerSiteTypeEnum;
use PartnerBundle\Enum\PartnerTypeEnum;
use PartnerBundle\Enum\SellingVolumeEnum;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class PartnerOptionController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'PartnerOption';

    /**
     * @Rest\Get("/type", name="partner_option_type")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/option/type",
     *     summary="Get types",
     *     tags={"Partner option"},
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
    public function getTypeAction(Request $request)
    {
        return $this->createView(PartnerTypeEnum::getData());
    }

    /**
     * @Rest\Get("/site", name="partner_option_site")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/option/site",
     *     summary="Get sites",
     *     tags={"Partner option"},
     *     @SWG\Response(
     *         response=200,
     *         description="Partner site list",
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
    public function getSiteAction(Request $request)
    {
        return $this->createView(PartnerSiteTypeEnum::getData());
    }

    /**
     * @Rest\Get("/selling-volume", name="partner_option_selling_volume")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/option/selling-volume",
     *     summary="Get selling volume",
     *     tags={"Partner option"},
     *     @SWG\Response(
     *         response=200,
     *         description="Partner selling volume list",
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
    public function getSellingVolumeAction(Request $request)
    {
        return $this->createView(SellingVolumeEnum::getData());
    }

    /**
     * @Rest\Get("/prestige", name="partner_option_prestige")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/option/prestige",
     *     summary="Get prestige",
     *     tags={"Partner option"},
     *     @SWG\Response(
     *         response=200,
     *         description="Partner prestige list",
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
    public function getPrestigeAction(Request $request)
    {
        return $this->createView(PartnerPrestigeTypeEnum::getData());
    }
}
