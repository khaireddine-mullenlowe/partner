<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\View\View;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Form\PartnerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Partner Api"
 *     ),
 *     @SWG\Tag(name="partner"),
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
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class PartnerController extends FOSRestController
{
    /**
     * @SWG\Get(
     *     path="/{id}",
     *     summary="get partner from id",
     *     operationId="getPartnerById",
     *     tags={"partner"},
     *     @SWG\Parameter(
     *         name="id",
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
     * @param int $id
     * @return View
     */
    public function getAction($id)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        return $this->createView($partner);
    }

    /**
     * @SWG\Get(
     *     path="/registry_user/{registryUserId}",
     *     summary="get partner from userId",
     *     operationId="getPartnerByRegistryUserId",
     *     tags={"partner"},
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
     * todo : refact this action (it needs to be restful)
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

        return $this->createView($partner);
    }

    /**
     * @SWG\Get(
     *     path="/myaudi_user/{myaudiUserId}",
     *     summary="get partner for myAudi userId",
     *     operationId="getPartnerByMyaudiUserId",
     *     tags={"partner"},
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

        return $this->createView($partner);
    }

    /**
     * @SWG\Put(
     *     summary="update partner from userId",
     *     operationId="putPartnerById",
     *     security={{ "bearer":{} }},
     *     path="/{id}",
     *     tags={"partner"},
     *     @SWG\Parameter(
     *         name="id",
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
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
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

        return $this->createView($partner);
    }

    /**
     * @SWG\Patch(
     *     path="/{id}",
     *     summary="patch partner from id",
     *     operationId="patchPartnerById",
     *     security={{ "bearer":{} }},
     *     tags={"partner"},
     *     @SWG\Parameter(
     *         name="id",
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
     *     )
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $id
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
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

        return $this->createView($partner);
    }

    /**
     * @SWG\Post(
     *     path="/",
     *     summary="create partner",
     *     operationId="createPartner",
     *     tags={"partner"},
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

        return $this->createView($partner, Response::HTTP_CREATED);
    }

    /**
     * @SWG\Delete(
     *     path="/{id}",
     *     summary="remove partner from id",
     *     operationId="removePartnerById",
     *     tags={"partner"},
     *     @SWG\Parameter(
     *         name="id",
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
     * @param integer $id
     * @return View
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Partner $partner
         */
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($id);
        if (!$partner) {
            throw $this->createNotFoundException('Partner not found');
        }

        $em->remove($partner);
        $em->flush();

        return $this->view(['context' => 'success', 'data' => ['success' => true]], Response::HTTP_OK);
    }

    protected function createView(Partner $partner, $statusCode = Response::HTTP_OK)
    {
        return $this->view(['context' => 'partner', 'data' => $partner], $statusCode);
    }
}
