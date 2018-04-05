<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\CompanyPositionCode;
use PartnerBundle\Entity\District;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerRegistryUser;
use PartnerBundle\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class PartnerRegistryUserType
 * @package PartnerBundle\Form
 */
class PartnerRegistryUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registryUserId', IntegerType::class)
            ->add('partner', EntityType::class, [
                'class' => Partner::class,
                'constraints' => [new Required(), new NotNull()]
            ])
            ->add('department', EntityType::class, [
                'class' => CompanyDepartment::class,
            ])
            ->add('position', EntityType::class, [
                'class' => CompanyPosition::class,
            ])
            ->add('positionCode', EntityType::class, [
                'class' => CompanyPositionCode::class,
            ])
            ->add('isAdmin', CheckboxType::class)
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
            'data_class' => PartnerRegistryUser::class,
            'csrf_protection' => false,
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
