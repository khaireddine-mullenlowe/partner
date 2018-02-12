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
 * Class CompanyRegistryUserController
 * @package PartnerBundle\Controller
 */
class CompanyRegistryUserController extends MullenloweRestController
{
    const CONTEXT = 'CompanyRegistryUser';

    /**
     * Finds and displays a CompanyRegistryUser entity collection by its registryUserId.
     *
     * @Rest\Get(
     *     "/{registryUserId}",
     *     name="_company_registry_user",
     *     requirements={"registryUserId"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/registry/{registryUserId}",
     *     summary="Finds and displays a CompanyRegistryUser entity collection by its registryUserId",
     *     operationId="getCompanyRegistryUser",
     *     tags={"Company Registry User"},
     *     @SWG\Parameter(
     *         name="registryUserId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="registryUserId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target CompanyRegistryUser",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/CompanyRegistryUserComplete")),
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
        $companyRegistryUser = $this->getDoctrine()
            ->getRepository('PartnerBundle:CompanyRegistryUser')
            ->findBy(['registryUserId' => $registryUserId]);
        if (!$companyRegistryUser) {
            throw new NotFoundHttpException(static::CONTEXT, 'CompanyRegistryUser not found');
        }

        return $this->createView($companyRegistryUser);
    }
}
