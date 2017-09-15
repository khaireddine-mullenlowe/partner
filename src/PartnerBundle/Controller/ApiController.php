<?php

namespace PartnerBundle\Controller;

use PartnerBundle\Entity\Partner;
use PartnerBundle\Form\PartnerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Swagger\Annotations as SWG;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Partner Api"
 *     ),
 *     host="api5.audi.agence-one.net",
 *     basePath="/partner/api/v1/partner",
 *     schemes={"http"},
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
 * @Route("/api/v1/partner", defaults={"_format": "json"})
 * @package PartnerBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @var Serializer
     */
    protected $serialiser;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizer->setIgnoredAttributes(['partner']);

        $this->serialiser = new Serializer([new DateTimeNormalizer(), $normalizer], [new JsonEncoder()]);
    }

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
     * @Route("/{partnerId}")
     * @Method({"GET"})
     *
     * @param int $partnerId
     * @return JsonResponse
     */
    public function getPartnerById($partnerId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $this->serialiser->serialize($partner, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
    }

    /**
     * @SWG\Get(
     *     path="/user/{registryUserId}",
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
     * @Route("/user/{registryUserId}")
     * @Method({"GET"})
     *
     * @param int $registryUserId
     * @return JsonResponse
     */
    public function getPartnerByRegistryUserId($registryUserId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->findOneByRegistryUserId($registryUserId);
        if (!$partner) {
            return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $this->serialiser->serialize($partner, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
    }


    /**
     * @SWG\Get(
     *     path="/myaudiuser/{myaudiUserId}",
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
     * @Route("/myaudiuser/{myaudiUserId}")
     * @Method({"GET"})
     *
     * @param int $myaudiUserId
     * @return JsonResponse
     */
    public function getPartnerByMyaudiUserId($myaudiUserId)
    {
        $repository = $this->getDoctrine()->getRepository('PartnerBundle:Partner');
        $partner = $repository->findOneByMyaudiUserId($myaudiUserId);
        if (!$partner) {
            return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $this->serialiser->serialize($partner, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
    }


    /**
     * @SWG\Put(
     *     path="/{partnerIdToUpdate}",
     *     summary="update partner for userId",
     *     operationId="updatePartnerById",
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
     *   security={{ "bearer":{} }}
     * )
     *
     * @Route("/{partnerId}")
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param int     $partnerId
     * @return JsonResponse
     */
    public function updatePartnerById(Request $request, $partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Partner $partner
         */
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        $dataInput = json_decode($request->getContent(), true);
        if (null === $dataInput) {
            throw new \InvalidArgumentException("json input data is invalid");
        }

        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            throw new \InvalidArgumentException($form->getErrors());
        }

        $em->persist($partner);
        $em->flush();

        $jsonContent = $this->serialiser->serialize($partner, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
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
     * @Route("")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createPartner(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = json_decode($request->getContent(), true);
        if (null === $dataInput) {
            throw new \InvalidArgumentException("json input data is invalid");
        }

        $partner = new Partner();
        $em->persist($partner);
        $form = $this->createForm(PartnerType::class, $partner);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            throw new \InvalidArgumentException($form->getErrors());
        }

        $em->persist($partner);

        $em->flush();

        $jsonContent = $this->serialiser->serialize($partner, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
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
     * @Route("/{partnerId}")
     * @Method({"DELETE"})
     *
     * @param Request $request
     * @param integer $partnerId
     * @return JsonResponse
     */
    public function removePartnerById(Request $request, $partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Partner $partner
         */
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            return new JsonResponse(['message' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($partner);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}
