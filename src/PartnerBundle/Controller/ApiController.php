<?php

namespace PartnerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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
 * @Route("/api/v1/partner")
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
        $this->serialiser = new Serializer([$normalizer], [new JsonEncoder()]);
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
     *         @SWG\Schema(
     *             ref="#/definitions/Error"
     *         )
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
}
