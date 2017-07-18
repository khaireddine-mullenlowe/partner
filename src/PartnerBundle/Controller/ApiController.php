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

/**
 * Class ApiController
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
     * @Route("/user/{registryUserId}")
     * @Method({"GET"})
     *
     * @param int $registryUserId
     * @return JsonResponse
     */
    public function getPartnerByRegistryUserId($registryUserId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->findOneBy(array('registryUserId' => $registryUserId));
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
