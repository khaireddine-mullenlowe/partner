<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
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
     *     tags={"Partner"},
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

        $response = $ekinoRESTClient->getPackages(
            $form->get('apotamoxId')->getData(),
            $form->get('contractNumber')->getData()
        );

        return $this->createView($response);
    }
}
