<?php

namespace PartnerBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\DepositType;
use PartnerBundle\Form\DepositTypeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\RouteResource("")
 *
 * @package PartnerBundle\Controller
 */
class DepositTypeController extends MullenloweRestController
{
    const CONTEXT = 'DepositType';
    const LIMIT = 20;

    /**
     * @Rest\Get("/", name="_deposit_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/deposit/{partnerId}/type/",
     *     summary="Get a Deposit Partner from id",
     *     operationId="getDepositTypeByPartnerId",
     *     tags={"DepositType"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target depositType",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/DepositTypeComplete"),
     *                 )
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
     * @param int $partnerId
     * @return View
     */
    public function getAction($partnerId)
    {
        $partner = $this->getDoctrine()->getRepository('PartnerBundle:Partner')->find($partnerId);
        /** Partner $partner */
        if (!$partner) {
            throw new NotFoundHttpException(self::CONTEXT, 'Partner not found');
        }

        if (!$partner->getDepositType()) {
            throw new NotFoundHttpException(self::CONTEXT, 'Deposit Type not found');
        }

        return $this->createView($partner->getDepositType());
    }

    /**
     * @Rest\Put("/", name="_deposit_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="update depositType from partnerId",
     *     operationId="putDepositTypeByPartnerId",
     *     security={{ "bearer":{} }},
     *     path="/deposit/{partnerId}/type/",
     *     tags={"DepositType"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/DepositType")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated deposit partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/DepositTypeComplete"),
     *                 )
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
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @param int     $partnerId
     * @return View
     */
    public function putAction(Request $request, $partnerId)
    {
        return $this->putOrPatch($request, $partnerId);
    }

    /**
     * @Rest\Patch("/", name="_deposit_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Patch(
     *     path="/deposit/{partnerId}/type/",
     *     summary="patch depositType from partnerId",
     *     operationId="patchDepositTypeByPartnerId",
     *     security={{ "bearer":{} }},
     *     tags={"DepositType"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Parameter(
     *         name="partner",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/DepositType")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated deposit partner",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/DepositTypeComplete"),
     *                 )
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
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @param int     $partnerId
     * @return View
     */
    public function patchAction(Request $request, $partnerId)
    {
        return $this->putOrPatch($request, $partnerId, false);
    }

    /**
     * @Rest\Post("/", name="_deposit_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/deposit/{partnerId}/type/",
     *     summary="create deposit type",
     *     operationId="createDepositType",
     *     tags={"DepositType"},
     *     @SWG\Parameter(
     *         name="depositType",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/DepositType")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created deposit type",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/DepositTypeComplete"),
     *                 )
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
     * @param Request $request
     * @param integer $partnerId
     * @return View
     */
    public function postAction(Request $request, $partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        /** @var Partner $partner */
        $partner = $em->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw new NotFoundHttpException(self::CONTEXT, 'Partner not found');
        }

        if (is_null($partner->getDepositType())) {
            $depositeType = new DepositType();
        } else {
            $depositeType = $partner->getDepositType();
        }

        $form = $this->createForm(DepositTypeType::class, $depositeType);

        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }
        $partner->setDepositType($depositeType);

        $em->persist($partner);
        $em->flush();

        return $this->createView($depositeType, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/", name="_deposit_partner")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/deposit/{partnerId}/type/",
     *     summary="remove deposit type",
     *     operationId="removeDepositTypeByPartnerId",
     *     tags={"DepositType"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="partnerId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the deposit type",
     *         @SWG\Schema(ref="#/definitions/Success")
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
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param integer $partnerId
     * @return View
     */
    public function deleteAction($partnerId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Partner $partner
         */
        $partner = $em->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw new NotFoundHttpException(self::CONTEXT, 'Partner not found');
        }

        $depositType = $partner->getDepositType();
        $partner->setDepositType(null);

        $em->persist($partner);
        $em->remove($depositType);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * Handles put or patch action
     *
     * @param Request $request
     * @param int $id $partner id
     * @param bool $clearMissing
     *
     * @return View
     */
    private function putOrPatch(Request $request, int $partnerId, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $partner = $em->getRepository('PartnerBundle:Partner')->find($partnerId);
        if (!$partner) {
            throw new NotFoundHttpException(self::CONTEXT, 'Partner not found');
        }

        if (is_null($partner->getDepositType())) {
            $depositeType = new DepositType();
        } else {
            $depositeType = $partner->getDepositType();
        }

        $form = $this->createForm(DepositTypeType::class, $depositeType);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($depositeType);
    }
}
