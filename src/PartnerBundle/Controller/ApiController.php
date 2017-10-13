<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\View\View;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Form\PartnerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Partner Api"
 *     ),
 *     host="api5.audi.agence-one.net",
 *     basePath="/partner",
 *     schemes={"http", "https"},
 *     produces={"application/json"},
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"message"},
 *         @SWG\Property(
 *             property="message",
 *             type="string",
 *             default="Partner not found"
 *         )
 *     )
 * )
 *
 * @SWG\SecurityScheme(
 *   securityDefinition="bearer",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 *
 * @RouteResource("", pluralize=false)
 * @package PartnerBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * @SWG\Get(
     *     path="/{partnerId}",
     *     summary="get partner for userId",
     *     operationId="getPartnerById",
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param int $partnerId
     * @return View
     */
    public function getAction($partnerId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        return $this->view($partner, Response::HTTP_OK);
    }

    /**
     * @SWG\Get(
     *     path="/registry_user/{registryUserId}",
     *     summary="get partner for userId",
     *     operationId="getPartnerByRegistryUserId",
     *     @SWG\Parameter(
     *         name="registryUserId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="registry user Id"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @Route("/registry_user/{registryUserId}")
     * @Rest\View()
     *
     * @param int $registryUserId
     * @return View
     */
    public function getPartnerByRegistryUserIdAction($registryUserId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->findOneByRegistryUserId($registryUserId);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        return $this->view($partner, Response::HTTP_OK);
    }

    /**
     * @SWG\Get(
     *     path="/myaudi_user/{myaudiUserId}",
     *     summary="get partner for myAudi userId",
     *     operationId="getPartnerByMyaudiUserId",
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="myAudi user Id"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @Route("/myaudi_user/{myaudiUserId}")
     * @Rest\View()
     *
     * @param int $myaudiUserId
     * @return View
     */
    public function getPartnerByMyaudiUserIdAction($myaudiUserId)
    {
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:Partner');
        $partner = $repository->findOneByMyaudiUserId($myaudiUserId);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        return $this->view($partner, Response::HTTP_OK);
    }

    /**
     * @SWG\Path(
     *     path="/{partnerIdToUpdate}",
     *     @SWG\Parameter(
     *         name="partnerIdToUpdate",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *    @SWG\Put(
     *        summary="update partner for userId",
     *        operationId="putPartnerById",
     *        security={{ "bearer":{} }},
     *        @SWG\Response(
     *            response=200,
     *            description="the partner",
     *            @SWG\Schema(ref="#/definitions/Partner")
     *        ),
     *        @SWG\Response(
     *            response=404,
     *            description="not found",
     *            @SWG\Schema(ref="#/definitions/Error")
     *        ),
     *        @SWG\Response(
     *            response=500,
     *            description="updating error",
     *            @SWG\Schema(ref="#/definitions/Error")
     *       )
     *    ),
     *    @SWG\Patch(
     *        summary="patch partner for userId",
     *        operationId="patchPartnerById",
     *        security={{ "bearer":{} }},
     *        @SWG\Response(
     *            response=200,
     *            description="the partner",
     *            @SWG\Schema(ref="#/definitions/Partner")
     *        ),
     *        @SWG\Response(
     *            response=404,
     *            description="not found",
     *            @SWG\Schema(ref="#/definitions/Error")
     *        ),
     *        @SWG\Response(
     *            response=500,
     *            description="updating error",
     *            @SWG\Schema(ref="#/definitions/Error")
     *        )
     *    )
     * )
     *
     * @Route("/{partnerId}", methods={"PUT", "PATCH"})
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $partnerId
     * @return View
     */
    public function putOrPatchAction(Request $request, $partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $isPut = $request->getMethod() == "PUT";
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput, $isPut);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->view($partner, Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *     path="/",
     *     summary="create partner for userId",
     *     operationId="createPartner",
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Partner")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = new Partner();
        $em->persist($partner);
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($partner);
        $em->flush();

        return $this->view($partner, Response::HTTP_CREATED);
    }

    /**
     * @SWG\Delete(
     *     path="/{partnerIdToRemove}",
     *     summary="remove partner for Id",
     *     operationId="removePartnerById",
     *     @SWG\Parameter(
     *         name="partnerIdToRemove",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the partner",
     *         @SWG\Schema(ref="#/definitions/Success")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *    ),
     *    security={{ "bearer":{} }}
     * )
     * @SWG\Definition(
     *     definition="Success",
     *     type="object",
     *     required={"success"},
     *     @SWG\Property(property="success", type="boolean")
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param integer $partnerId
     * @return View
     */
    public function deleteAction(Request $request, $partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Partner $partner
         */
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $em->remove($partner);
        $em->flush();

        return ['context' => 'success', 'data' => ['success' => true]];
    }
}
