<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\Company;
use PartnerBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class CompanyType
 * @package PartnerBundle\Form
 */
class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new Required(), new NotNull()]
            ])
            ->add('type', EntityType::class, [
                'class' => \PartnerBundle\Entity\CompanyType::class,
                'constraints' => [new Required(), new NotNull()]
            ])
            ->add('registryUsers', CollectionType::class, [
                'entry_type'   => PartnerRegistryUserType::class,
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('status', IntegerType::class, [
                'constraints' => [new Required(), new NotNull()]
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
            'data_class' => Company::class,
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
