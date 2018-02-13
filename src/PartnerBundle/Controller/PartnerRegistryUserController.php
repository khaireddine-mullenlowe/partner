<?php

namespace PartnerBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use PartnerBundle\Entity\PartnerRegistryUser;
use PartnerBundle\Form\PartnerRegistryUserType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Rest\Post("/", name="_partner_registry_user")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/",
     *     summary="Link partner and registry user",
     *     operationId="postPartnerRegistryUser",
     *     tags={"Partner Registry User"},
     *     @SWG\Parameter(
     *         name="partner registry user",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             @SWG\Property(property="partner", type="integer"),
     *             @SWG\Property(property="registryUserId", type="integer"),
     *             required={"partner", "registryUserId"})
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created link partner and registry user",
     *         @SWG\Schema(
     *            allOf={
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
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partnerRegistryUser = new PartnerRegistryUser();
        $form = $this->createForm(PartnerRegistryUserType::class, $partnerRegistryUser);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($partnerRegistryUser);
        $em->flush();

        return $this->createView($partnerRegistryUser, Response::HTTP_CREATED);
    }
}
