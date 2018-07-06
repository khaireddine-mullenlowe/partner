<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\OpeningHour;
use PartnerBundle\Entity\Partner;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class OpeningHourType
 * @package PartnerBundle\Form
 */
class OpeningHourType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partner', EntityType::class, [
                'class' => Partner::class
            ])
            ->add('openingDay', TextType::class)
            // An example of input of all time 12:17
            ->add('amStartHour', TimeType::class, [
                'widget' => 'single_text',
                'with_minutes' => true
            ])
            ->add('amEndHour', TimeType::class, [
                'widget' => 'single_text',
                'with_minutes' => true
            ])
            ->add('pmStartHour', TimeType::class, [
                'widget' => 'single_text',
                'with_minutes' => true
            ])
            ->add('pmEndHour', TimeType::class, [
                'widget' => 'single_text',
                'with_minutes' => true
            ])
            ->add('nox', CheckboxType::class)
            ->add('status', IntegerType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpeningHour::class,
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
