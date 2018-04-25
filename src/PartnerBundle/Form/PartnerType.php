<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\District;
use PartnerBundle\Entity\Group;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\Region;
use PartnerBundle\Enum\PartnerTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PartnerType
 * @package PartnerBundle\Form
 */
class PartnerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('legacyId', IntegerType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [PartnerTypeEnum::TYPE_SALES, PartnerTypeEnum::TYPE_AFTERSALES],
            ])
            ->add('contractNumber', TextType::class)
            ->add('commercialName', TextType::class)
            ->add('corporateName', TextType::class)
            ->add('kvpsNumber', TextType::class)
            ->add('webSite', UrlType::class)
            ->add('isPartnerR8', CheckboxType::class)
            ->add('isTwinService', CheckboxType::class)
            ->add('isPartnerPlus', CheckboxType::class)
            ->add('isOccPlus', CheckboxType::class)
            ->add('occPlusContractNumber', TextType::class)
            ->add('isEtron', CheckboxType::class)
            ->add('registryUsers', CollectionType::class, [
                'entry_type'   => PartnerRegistryUserType::class,
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('myaudiUsers', CollectionType::class, [
                'entry_type' => PartnerMyaudiUserType::class,
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('group', EntityType::class, [
                'class' => Group::class,
            ])
            ->add('siteType', TextType::class)
            ->add('category', TextType::class)
            ->add('representationType', TextType::class)
            ->add('prestigeType', TextType::class)
            ->add('dealersMeeting', CheckboxType::class)
            ->add('brandDays', CheckboxType::class)
            ->add('rent', CheckboxType::class)
            ->add('extraHour', CheckboxType::class)
            ->add('ferMembership', CheckboxType::class)
            ->add('onlineQuotation', CheckboxType::class)
            ->add('amexPayment', CheckboxType::class)
            ->add('isDigitAll', CheckboxType::class)
            ->add('digitAllId', TextType::class)
            ->add('isV12', CheckboxType::class)
            ->add('v12Id', TextType::class)
            ->add('sellingVolume', IntegerType::class)
            ->add('region', EntityType::class, [
                'class' => Region::class,
            ])
            ->add('district', EntityType::class, [
                'class' => District::class,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Partner::class,
            'allow_extra_fields' => false,
            'extra_fields_message' => 'This form should not contain extra fields : "{{ extra_fields }}".',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
