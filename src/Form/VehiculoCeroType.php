<?php

namespace App\Form;

use App\Form\VehiculoType;
use App\Entity\VehiculoCero;
use App\Entity\Proveedor;            
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoCeroType extends VehiculoType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);

    $builder            
      ->add('proveedor', EntityType::class, array(
        'class' => Proveedor::class,
        'required' => true,
        'label' => 'Proveedor',
        'placeholder' => '-- Elija proveedor --',
        'attr' => array(
          'placeholder' => 'Escriba el proveedor aquí.',
          'class' => 'form-control choice',
          'data-placeholder' => '-- Elija proveedor --',
          'tabindex' => '5')
        )
      );      
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => VehiculoCero::class,
    ]);
  }
}
