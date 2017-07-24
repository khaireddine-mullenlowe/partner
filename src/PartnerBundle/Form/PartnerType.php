<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('partnerId', TextType::class)
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        0 => 'sales',
                        1 => 'aftersales',
                    ],
                ]
            )
            ->add('contractNumber', TextType::class)
            ->add('commercialName', TextType::class)
            ->add('kvpsNumber', TextType::class)
            ->add('webSite', TextType::class)
            ->add('isPartnerR8', CheckboxType::class)
            ->add('isTwinService', CheckboxType::class)
            ->add('isPartnerPlus', CheckboxType::class)
            ->add('isOccPlus', CheckboxType::class)
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
            ->add('addresses', CollectionType::class, [
                'entry_type' => PartnerAddressType::class,
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'partner';
    }
}