<?php

namespace PartnerBundle\Form;

use PartnerBundle\Entity\DepositType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DepositTypeType
 * @package PartnerBundle\Form
 */
class DepositTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depositVehicleWorkshop', CheckboxType::class)
            ->add('depositVehicleWorkshopDaysBeforeFreeCalendar', IntegerType::class)
            ->add('depositWaitOnSpot', CheckboxType::class)
            ->add('depositWaitOnSpotDaysBeforeFreeCalendar', IntegerType::class)
            ->add('depositReplacementVehicle', CheckboxType::class)
            ->add('depositReplacementVehicleDaysBeforeFreeCalendar', IntegerType::class)
            ->add('depositValetParking', CheckboxType::class)
            ->add('depositValetParkingDaysBeforeFreeCalendar', IntegerType::class)
            ->add('depositValetParkingPrice', NumberType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => DepositType::class,
            'allow_extra_fields' => false,
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
