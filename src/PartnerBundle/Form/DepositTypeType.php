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
            ->add('vehicleWorkshop', CheckboxType::class)
            ->add('vehicleWorkshopDaysBeforeFreeCalendar', IntegerType::class)
            ->add('waitOnSpot', CheckboxType::class)
            ->add('waitOnSpotDaysBeforeFreeCalendar', IntegerType::class)
            ->add('replacementVehicle', CheckboxType::class)
            ->add('replacementVehicleDaysBeforeFreeCalendar', IntegerType::class)
            ->add('valetParking', CheckboxType::class)
            ->add('valetParkingDaysBeforeFreeCalendar', IntegerType::class)
            ->add('valetParkingPrice', NumberType::class)
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
