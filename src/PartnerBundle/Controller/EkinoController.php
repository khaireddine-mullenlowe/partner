<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use GuzzleHttp\Exception\BadResponseException;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\PluginsBundle\Service\Ekino\EkinoRESTClient;
use PartnerBundle\Form\Ekino\PackageType;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EkinoController
 * @package PartnerBundle\Controller
 */
class EkinoController extends MullenloweRestController
{
    const CONTEXT = 'Ekino';

    /**
     * @Rest\Post("/ekino/packages", name="_ekino")
     * @Rest\View
     *
     * @SWG\Post(
     *     path="/ekino/packages",
     *     summary="Gets partner's packages from Ekino",
     *     operationId="getPartnersPackages",
     *     tags={"Ekino"},
     *     @SWG\Parameter(
     *         name="payload",
     *         in="body",
     *         required=true,
     *         description="payload",
     *         @SWG\Schema(ref="#/definitions/PackagesPayload")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target partner's packages",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Property(property="data", type="object")
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
     * @param Request         $request
     * @param EkinoRESTClient $ekinoRESTClient
     *
     * @return \FOS\RestBundle\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPackagesAction(Request $request, EkinoRESTClient $ekinoRESTClient)
    {
        $form = $this->createForm(PackageType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        try {
            return $this->createView($ekinoRESTClient->getPackages(
                $form->get('apotamoxId')->getData(),
                $form->get('contractNumber')->getData()
            ));
        } catch (BadResponseException $exception) {
            return $this->createView($exception);
        }
    }

    /**
     * @Rest\Get(
     *     "/ekino/tyres/{contractNumber}",
     *     name="contractNumber",
     *     requirements={"contractNumber"="\d+"}
     * )
     *
     * @SWG\Get(
     *     path="/ekino/tyres/{contractNumber}",
     *     summary="Gets partner's tyres from Ekino",
     *     operationId="getPartnersTyres",
     *     tags={"Ekino"},
     *     @SWG\Parameter(
     *         name="contractNumber",
     *         in="path",
     *         type="string",
     *         required=true,
     *         description="Contract number of Audi Service partner"
     *     ),
     *     @SWG\Parameter(
     *         name="width",
     *         in="query",
     *         type="integer",
     *         required=true,
     *         description="Width of tyre"
     *     ),
     *     @SWG\Parameter(
     *         name="height",
     *         in="query",
     *         type="integer",
     *         required=true,
     *         description="Height of tyre"
     *     ),
     *     @SWG\Parameter(
     *         name="rim",
     *         in="query",
     *         type="integer",
     *         required=true,
     *         description="Rim of tyre"
     *     ),
     *     @SWG\Parameter(
     *         name="loadIndex",
     *         in="query",
     *         type="string",
     *         required=true,
     *         description="LoadIndex of tyre"
     *     ),
     *     @SWG\Parameter(
     *         name="speedIndex",
     *         in="query",
     *         type="string",
     *         required=true,
     *         description="SpeedIndex of tyre"
     *     ),
     *     @SWG\Parameter(
     *         name="range",
     *         in="query",
     *         type="integer",
     *         required=true,
     *         description="Winter or summer season"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target partner's tyres",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/PartnerTyres"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *   security={{ "bearer":{} }}
     * )
     *
     * @param string $contractNumber
     * @param Request $request
     * @param EkinoRESTClient $ekinoRESTClient
     * @return mixed
     */
    public function getTyresAction(
        string $contractNumber,
        Request $request,
        EkinoRESTClient $ekinoRESTClient
    )
    {
        $searchCriteria = array(
            'width' => $request->query->get('width'),
            'height' => $request->query->get('height'),
            'rim' => $request->query->get('rim'),
            'loadIndex' => $request->query->get('loadIndex'),
            'speedIndex' => $request->query->get('speedIndex'),
            'range' => $request->query->get('range')
        );

        $response = $ekinoRESTClient->getTyres($contractNumber, $searchCriteria);

        return $this->createView($response);
    }
}
