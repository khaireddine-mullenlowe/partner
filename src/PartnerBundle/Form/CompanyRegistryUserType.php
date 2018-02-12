<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\Company;
use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\CompanyPositionCode;
use PartnerBundle\Entity\CompanyRegistryUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class CompanyRegistryUserType
 * @package PartnerBundle\Form
 */
class CompanyRegistryUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registryUserId', IntegerType::class)
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'constraints' => [new Required(), new NotNull()]
            ])
            ->add('department', EntityType::class, [
                'class' => CompanyDepartment::class,
            ])
            ->add('position', EntityType::class, [
                'class' => CompanyPosition::class,
            ])
            ->add('positionDescription', TextType::class)
            ->add('positionCode', EntityType::class, [
                'class' => CompanyPositionCode::class,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanyRegistryUser::class,
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
