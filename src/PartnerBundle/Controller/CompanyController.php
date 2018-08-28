<?php

namespace PartnerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use PartnerBundle\Entity\Company;
use PartnerBundle\Form\CompanyType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

/**
 * Class CompanyController
 * @package PartnerBundle\Controller
 */
class CompanyController extends MullenloweRestController
{
    const CONTEXT = 'Company';
    const LIMIT = 20;

    /**
     * @Rest\Get("/{id}", name="_company", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/{id}",
     *     summary="Get a Company from id",
     *     operationId="getCompanyById",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="companyId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Target company",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CompanyComplete"),
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
     * @param int $id
     * @return View
     */
    public function getAction($id)
    {
        $company = $this->getDoctrine()->getRepository('PartnerBundle:Company')->find($id);
        if (!$company) {
            throw new NotFoundHttpException(self::CONTEXT, 'Company not found');
        }

        return $this->createView($company);
    }

    /**
     * @Rest\Get("/", name="_companies")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Get(
     *     path="/company/",
     *     summary="get companies",
     *     operationId="getCompanies",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="company type id"
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="page number"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="max items per page"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Companies",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/CompanyComplete")
     *                     ),
     *                 ),
     *             }
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return View
     */
    public function cgetAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');

        $companies = $this
            ->getDoctrine()
            ->getRepository('PartnerBundle:Company')
            ->findByCustomFilters($request->query->getInt('type'));

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $companies,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/", name="_company")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/company/",
     *     summary="create company",
     *     operationId="createCompany",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="company",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Company")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created company",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CompanyComplete"),
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
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($company);
        $em->flush();

        return $this->createView($company, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/{id}", name="_company", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Put(
     *     summary="Update company by Id",
     *     operationId="putCompanyById",
     *     security={{ "bearer":{} }},
     *     path="/company/{id}",
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="companyId"
     *     ),
     *     @SWG\Parameter(
     *         name="company",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Company")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated company",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CompanyComplete"),
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
     * @param int     $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id);
    }

    /**
     * @Rest\Patch(
     *     "/{id}",
     *     name="_company",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Patch(
     *     path="/company/{id}",
     *     summary="patch company from id",
     *     operationId="patchCompanyById",
     *     security={{ "bearer":{} }},
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="companyId"
     *     ),
     *     @SWG\Parameter(
     *         name="company",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Company")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated company",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CompanyComplete"),
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
     * @param int     $id
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id, false);
    }

    /**
     * Handles put or patch action
     *
     * @param Request $request
     * @param int $id company id
     * @param bool $clearMissing
     *
     * @return View
     */
    private function putOrPatch(Request $request, int $id, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $company = $em->getRepository('PartnerBundle:Company')->find($id);
        if (!$company) {
            throw new NotFoundHttpException(self::CONTEXT, 'Company not found');
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->submit($dataInput, $clearMissing);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->flush();

        return $this->createView($company);
    }

    /**
     * @Rest\Delete("/{id}", name="_company")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Delete(
     *     path="/company/{id}",
     *     summary="Delete company from id",
     *     operationId="deleteCompanyById",
     *     security={{ "bearer":{} }},
     *     tags={"Company"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="companyId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success message",
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
     *     )
     * )
     * @param Request $request
     * @return View
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var Company $company
         */
        $company = $em->getRepository('PartnerBundle:Company')->find($id);
        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        $em->remove($company);
        $em->flush();

        return $this->deleteView();
    }
}
