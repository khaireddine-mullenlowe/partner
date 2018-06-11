<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PartnerBundle\Enum\PartnerSiteTypeEnum;
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
class PartnerSiteController extends MullenloweRestController
{
    const LIMIT = 20;
    const CONTEXT = 'PartnerSite';

    /**
     * @Rest\Get("", name="partner_site")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *      path="/partner/site",
     *     summary="Get partner sites",
     *     tags={"Partner"},
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
    public function getAction(Request $request)
    {
        return $this->createView(PartnerSiteTypeEnum::getData());
    }
}
