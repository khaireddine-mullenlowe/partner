<?php

namespace PartnerBundle\Controller;


use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;

class PartnerMyaudiUserController extends MullenloweRestController
{

    const CONTEXT = 'PartnerMyaudiUser';
    /**
     * Checks Duplicate MyaudiUser Partner Rule with incoming request body data.
     *
     * @Rest\Post("/{myaudiUserId}/check_duplicate",
     *     name="_check_duplicate",
     *     requirements={"id"="\d+"}
     * )
     *
     * @SWG\Post(
     *     path="/{myaudiUserId}/check_duplicate",
     *     summary="Check Duplicate Partner Rule by myaudiUserId",
     *     operationId="checkDuplicateRuleAction",
     *     tags={"MyaudiUser"},
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="MyaudiUser id to check"
     *     ),
     *     @SWG\Parameter(
     *         name="DataToCheck",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="partnerName",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Check duplicate rule status",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="isDuplicate",
     *                 type="boolean"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     * @Rest\View()
     *
     * @param int $myaudiUserId
     * @param Request $request
     * @return View
     */
    public function postCheckDuplicateRuleAction(Request $request, int $myaudiUserId)
    {
        if (0 === $request->request->count()) {
            throw new BadRequestHttpException('Input data are empty');
        }

        if (!$request->request->get('partnerName')) {
            throw new BadRequestHttpException('Input data are not valid (%s)');
        }

        $partnerMyaudiUser = $this->getDoctrine()->getRepository('PartnerBundle:PartnerMyaudiUser')
            ->findOneBy(['myaudiUserId' => $myaudiUserId]);
        if (null === $partnerMyaudiUser) {
            throw $this->createNotFoundException('PartnerMyaudiUser not found');
        }

        $isDuplicate = $request->request->get('partnerName') == $partnerMyaudiUser->getPartner()->getCommercialName();

        return $this->createView(['isDuplicate' => $isDuplicate]);
    }
}