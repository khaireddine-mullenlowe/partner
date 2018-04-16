<?php

namespace PartnerBundle;

use Swagger\Annotations as SWG;
use PartnerBundle\Entity\Partner;

/**
 * Class SwaggerDefinitions
 * @package PartnerBundle
 */
class SwaggerDefinitions
{
    /**
     * @SWG\Swagger(
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="Partner Api"
     *     ),
     *     host="api5.audi.agence-one.net",
     *     basePath="/partner/",
     *     schemes={"http"},
     *     produces={"application/json"},
     *
     *     @SWG\Definition(
     *         definition="Context",
     *         type="object",
     *         @SWG\Property(property="context", type="string")
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Pagination",
     *         type="object",
     *         @SWG\Property(
     *             property="pagination",
     *             type="object",
     *             properties={
     *                 @SWG\Property(property="total", type="integer"),
     *                 @SWG\Property(property="count", type="integer"),
     *                 @SWG\Property(property="per_page", type="integer"),
     *                 @SWG\Property(property="current_page", type="integer"),
     *                 @SWG\Property(property="total_pages", type="integer"),
     *                 @SWG\Property(property="previous_url", type="string"),
     *                 @SWG\Property(property="next_url", type="string"),
     *             }
     *         ),
     *         required={"pagination"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Success",
     *         type="object",
     *         allOf={@SWG\Definition(ref="#/definitions/Context")},
     *         @SWG\Property(
     *             property="data",
     *             type="object",
     *             properties={@SWG\Property(property="message", type="string")}
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Error",
     *         type="object",
     *         allOf={@SWG\Definition(ref="#/definitions/Context")},
     *         @SWG\Property(
     *             property="errors",
     *             type="array",
     *             @SWG\Items(
     *                 @SWG\Property(property="message", type="string"),
     *                 @SWG\Property(property="code", type="integer"),
     *                 @SWG\Property(property="type", type="string"),
     *             )
     *         ),
     *         required={"errors"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="IdableEntity",
     *         @SWG\Property(property="id", type="integer"),
     *         required={"id"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="LegacyEntity",
     *         @SWG\Property(property="legacyId", type="integer"),
     *         required={"legacyId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="TimestampableEntity",
     *         @SWG\Property(property="createdAt", type="string", format="date-time"),
     *         @SWG\Property(property="updatedAt", type="string", format="date-time"),
     *         required={"createdAt", "updatedAt"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="NamedEntity",
     *         @SWG\Property(property="name", type="string"),
     *         required={"name"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="StatusEntity",
     *         @SWG\Property(property="status", type="integer"),
     *         required={"status"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="ReferentialEntity",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/NamedEntity"),
     *             @SWG\Definition(ref="#/definitions/StatusEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Partner",
     *         allOf={
     *             @SWG\Definition(
     *                  @SWG\Property(
     *                      property="type",
     *                      type="string",
     *                      enum={
     *                          PartnerBundle\Enum\PartnerTypeEnum::TYPE_SALES,
     *                          PartnerBundle\Enum\PartnerTypeEnum::TYPE_AFTERSALES
     *                      }
     *                  ),
     *                  @SWG\Property(property="contractNumber", type="string"),
     *                  @SWG\Property(property="commercialName", type="string"),
     *                  @SWG\Property(property="kvpsNumber", type="string"),
     *                  @SWG\Property(property="webSite", type="string"),
     *                  @SWG\Property(property="isPartnerR8", type="boolean"),
     *                  @SWG\Property(property="isTwinService", type="boolean"),
     *                  @SWG\Property(property="isPartnerPlus", type="boolean"),
     *                  @SWG\Property(property="isOccPlus", type="boolean"),
     *                  @SWG\Property(property="occPlusContractNumber", type="string"),
     *                  @SWG\Property(property="isEtron", type="boolean"),
     *                  @SWG\Property(property="group", type="integer"),
     *                  @SWG\Property(
     *                      property="siteType",
     *                      type="string",
     *                      enum={
     *                          PartnerBundle\Enum\PartnerSiteTypeEnum::SITE_TYPE_PRINCIPAL,
     *                          PartnerBundle\Enum\PartnerSiteTypeEnum::SITE_TYPE_SECONDARY
     *                      }
     *                  ),
     *                  required={"type"}
     *             ),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         }
     *     ),
     *     @SWG\Definition(
     *         definition="PartnerComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/Partner"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Group",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(
     *                  @SWG\Property(property="webSiteUrl", type="string"),
     *             ),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         }
     *     ),
     *     @SWG\Definition(
     *         definition="GroupComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/Group"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *          definition="Region",
     *          allOf={
     *              @SWG\Definition(ref="#/definitions/IdableEntity"),
     *              @SWG\Definition(ref="#/definitions/NamedEntity"),
     *              @SWG\Property(
     *                  property="type",
     *                  type="string",
     *                  enum={
     *                      PartnerBundle\Enum\PartnerTypeEnum::TYPE_SALES,
     *                      PartnerBundle\Enum\PartnerTypeEnum::TYPE_AFTERSALES
     *                  }
     *              ),
     *              @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *              @SWG\Definition(
     *                  @SWG\Property(property="legacy_id", type="string")
     *              )
     *          }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="District",
     *         allOf={
     *              @SWG\Definition(ref="#/definitions/IdableEntity"),
     *              @SWG\Definition(ref="#/definitions/NamedEntity"),
     *              @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *              @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Company",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(
     *                 @SWG\Property(property="type", type="integer"),
     *                 required={"type"}
     *             ),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(
     *                 @SWG\Property(property="type", ref="#/definitions/CompanyTypeComplete"),
     *                 required={"type"}
     *             ),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyType",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyTypeComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/CompanyType"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyDepartment",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyDepartmentComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/CompanyDepartment"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyPosition",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyPositionComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/CompanyPosition"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyPositionCode",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/ReferentialEntity"),
     *             @SWG\Definition(ref="#/definitions/LegacyEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyPositionCodeComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(ref="#/definitions/CompanyPositionCode"),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         },
     *     ),
     *
     *     @SWG\Definition(
     *         definition="PartnerMyaudiUser",
     *         @SWG\Property(property="partner", type="integer"),
     *         @SWG\Property(property="myaudiUserId", type="integer"),
     *         required={"partner", "myaudiUserId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="PartnerMyaudiUserComplete",
     *         allOf={
     *             @SWG\Definition(
     *                  @SWG\Property(property="partner", ref="#/definitions/PartnerComplete"),
     *                  @SWG\Property(property="myaudiUserId", type="integer"),
     *             ),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="PartnerRegistryUser",
     *         @SWG\Property(property="partner", type="integer"),
     *         @SWG\Property(property="registryUserId", type="integer"),
     *         @SWG\Property(property="department", type="integer"),
     *         @SWG\Property(property="position", type="integer"),
     *         @SWG\Property(property="positionCode", type="integer"),
     *         @SWG\Property(property="isAdmin", type="boolean"),
     *         @SWG\Property(property="vision", type="boolean"),
     *         @SWG\Property(property="convention", type="boolean"),
     *         @SWG\Property(property="dealersMeeting", type="boolean"),
     *         @SWG\Property(property="brandDays", type="boolean"),
     *         required={"partner", "registryUserId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="PartnerRegistryUserComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(
     *                 @SWG\Property(property="partner", ref="#/definitions/PartnerComplete"),
     *                 @SWG\Property(property="registryUserId", type="integer"),
     *                 @SWG\Property(property="department", ref="#/definitions/CompanyDepartmentComplete"),
     *                 @SWG\Property(property="position", ref="#/definitions/CompanyPositionComplete"),
     *                 @SWG\Property(property="positionCode", ref="#/definitions/CompanyPositionCodeComplete"),
     *                 @SWG\Property(property="isAdmin", type="boolean"),
     *                 @SWG\Property(property="vision", type="boolean"),
     *                 @SWG\Property(property="convention", type="boolean"),
     *                 @SWG\Property(property="dealersMeeting", type="boolean"),
     *                 @SWG\Property(property="brandDays", type="boolean"),
     *                 required={"partner", "registryUserId"}
     *             ),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyRegistryUser",
     *         @SWG\Property(property="company", type="integer"),
     *         @SWG\Property(property="registryUserId", type="integer"),
     *         @SWG\Property(property="department", type="integer"),
     *         @SWG\Property(property="position", type="integer"),
     *         @SWG\Property(property="positionDescription", type="string"),
     *         @SWG\Property(property="positionCode", type="integer"),
     *         required={"partner", "registryUserId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="CompanyRegistryUserComplete",
     *         allOf={
     *             @SWG\Definition(ref="#/definitions/IdableEntity"),
     *             @SWG\Definition(
     *                 @SWG\Property(property="company", ref="#/definitions/CompanyComplete"),
     *                 @SWG\Property(property="registryUserId", type="integer"),
     *                 @SWG\Property(property="department", ref="#/definitions/CompanyDepartmentComplete"),
     *                 @SWG\Property(property="position", ref="#/definitions/CompanyPositionComplete"),
     *                 @SWG\Property(property="positionDescription", type="string"),
     *                 @SWG\Property(property="positionCode", ref="#/definitions/CompanyPositionCodeComplete"),
     *                 required={"partner", "registryUserId"}
     *             ),
     *             @SWG\Definition(ref="#/definitions/TimestampableEntity"),
     *         }
     *     ),
     * )
     *
     * @SWG\SecurityScheme(
     *   securityDefinition="bearer",
     *   type="apiKey",
     *   in="header",
     *   name="Authorization"
     * )
     */
}
