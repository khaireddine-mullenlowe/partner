<?php

namespace PartnerBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Swagger\Annotations as SWG;

/**
 * @Rest\RouteResource("")
 *
 * Class PartnerRegistryUserController
 * @package PartnerBundle\Controller
 */
class PartnerRegistryUserController extends MullenloweRestController
{
    const CONTEXT = 'PartnerRegistryUser';

    /**
     * Finds and displays a PartnerRegistryUser entity collection by its registryUserId.
     *
     * @Rest\Get(
     *     "/{registryUserId}",
     *     name="_partner_registry_user",
     *     requirements={"registryUserId"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/registry/{registryUserId}",
     *     summary="Finds and displays a PartnerRegistryUser entity collection by its registryUserId",
     *     operationId="getPartnerRegistryUser",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="registryUserId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="registryUserId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target PartnerRegistryUser",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/PartnerRegistryUserComplete")),
     *                 ),
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @param int $registryUserId
     * @return View
     */
    public function getAction(int $registryUserId)
    {
        $partnerRegistryUser = $this->getDoctrine()
            ->getRepository('PartnerBundle:PartnerRegistryUser')
            ->findBy(['registryUserId' => $registryUserId]);
        if (!$partnerRegistryUser) {
            throw new NotFoundHttpException(static::CONTEXT, 'PartnerRegistryUser not found');
        }

        return $this->createView($partnerRegistryUser);
    }
}
