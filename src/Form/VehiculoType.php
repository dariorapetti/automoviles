<?php

namespace App\Form;

use App\Entity\Marca;
use App\Entity\Vehiculo;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VehiculoType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('dominio', TextType::class, array(
        'required' => true,
        'label' => 'Dominio',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('modelo', TextType::class, array(
        'required' => true,
        'label' => 'Modelo',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('tipo', TextType::class, array(
        'required' => true,
        'label' => 'Tipo',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('numeroMotor', TextType::class, array(
        'required' => true,
        'label' => 'Número Motor',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('numeroChasis', TextType::class, array(
        'required' => true,
        'label' => 'Número Chasis',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('cotizacionDolar', null, array(
        'required' => true,
        'label' => 'Cotización Dolar',
        'attr' => array(
          'class' => 'form-control text-right currency-format',
          'tabindex' => '5'))
      )
      ->add('precioCompraUsd', TextType::class, array(
        'required' => true,
        'label' => 'Dólares',
        'attr' => array(
          'class' => 'form-control text-right currency-format-usd is-readonly',
          'readonly' => true,
          'tabindex' => '5'))
      )
      ->add('precioVentaUsd', TextType::class, array(
        'required' => true,
        'label' => 'Dólares',
        'attr' => array(
          'class' => 'form-control text-right currency-format-usd is-readonly',
          'readonly' => true,
          'tabindex' => '5'))
      )
      ->add('precioCompraPesos', TextType::class, array(
        'required' => true,
        'label' => 'Pesos',
        'attr' => array(
          'class' => 'form-control text-right currency-format',
          'tabindex' => '5'))
      )
      ->add('precioVentaPesos', TextType::class, array(
        'required' => true,
        'label' => 'Pesos',
        'attr' => array(
          'class' => 'form-control text-right currency-format',
          'tabindex' => '5'))
      )      
      ->add('comentario', TextareaType::class, array(
        'required' => false,
        'label' => 'Comentarios',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('marca', EntityType::class, array(
        'class' => Marca::class,
        'required' => true,
        'label' => 'Marca',
        'placeholder' => '-- Elija marca --',
        'attr' => array(
          'placeholder' => 'Escriba el marca aquí.',
          'class' => 'form-control choice',
          'data-placeholder' => '-- Elija marca --',
          'tabindex' => '5'),
        'query_builder' => function (EntityRepository $er) {
          return $er->createQueryBuilder('m')
              ->orderBy('m.nombre', 'ASC');
        }
      )
      )
    ;

  }

  public function getBlockPrefix(): string
  {
    return 'vehiculo';
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Vehiculo::class,
    ]);
  }
}
