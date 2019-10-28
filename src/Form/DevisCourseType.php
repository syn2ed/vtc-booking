<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DevisCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departAdress', TextType::class, [
                'label' => "Adresse de depart"
            ])
            ->add('destinationAdress', TextType::class, [
                'label' => "Adresse de destination"
            ])
            ->add('date', DateType::class, [
                'label' => "Date",
                'format' => 'dd-MM-yyyy',
            ])
            ->add('time', TimeType::class, [
                'label' => "Heure de prise en charge"
            ])
            ->add('tel', TelType::class, [
                'label' => "Numéro de téléphone"
            ])
            ->add('cost', HiddenType::class, [

            ])
            ->add('distance', HiddenType::class, [

            ])
            ->add('duration', HiddenType::class, [

            ])
            ->add('reserverButton', SubmitType::class,[
                'label' => "Réserver le trajet"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
