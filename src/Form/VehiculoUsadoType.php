<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Form\VehiculoType;
use App\Entity\VehiculoUsado;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class VehiculoUsadoType extends VehiculoType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);

    $builder
    ->add('cliente', EntityType::class, array(
      'class' => Cliente::class,
      'required' => true,
      'label' => 'Cliente',
      'placeholder' => '-- Elija cliente --',
      'attr' => array(
        'placeholder' => 'Escriba el cliente aquí.',
        'class' => 'form-control choice',
        'data-placeholder' => '-- Elija cliente --',
        'tabindex' => '5'),
    )
    )
      ->add('anio', TextType::class, array(
        'required' => true,
        'label' => 'Año',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('kilometros', TextType::class, array(
        'required' => true,
        'label' => 'Kilómetros',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('precioRevista', TextType::class, array(
        'required' => true,
        'label' => 'Precio Revista',
        'attr' => array(
          'class' => 'form-control text-right currency-format',
          'tabindex' => '5'))
      )
      ->add('kitSeguridad', CheckboxType::class, array(
        'required' => true,
        'label' => 'Kit Seguridad',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('cubreAlfombras', CheckboxType::class, array(
        'required' => true,
        'label' => 'Cubre Alfombras',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('titulo', CheckboxType::class, array(
        'required' => true,
        'label' => 'Título',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('cedulaVerde', CheckboxType::class, array(
        'required' => true,
        'label' => 'Cédula Verde',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('formulario08', CheckboxType::class, array(
        'required' => true,
        'label' => 'Formulario 08',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('grabadoAutopartes', CheckboxType::class, array(
        'required' => true,
        'label' => 'Grabado Autopartes',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('duplicadoLlaves', CheckboxType::class, array(
        'required' => true,
        'label' => 'Duplicado Llaves',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('vencimientoGnc', DateType::class, array(
        'widget' => 'single_text',
        // 'format' => 'dd/MM/yyyy',
        'years' => range(Date('Y'), 2030),
        'model_timezone' => 'America/Argentina/Buenos_Aires',
        'required' => false,
        'label' => 'Vencimiento Gnc',
        'attr' => array(
          'class' => 'form-control datepicker',
          'tabindex' => '5'))
      )
      ->add('vencimientoVtv', DateType::class, array(
        'widget' => 'single_text',
        // 'format' => 'dd/MM/yyyy',
        'years' => range(Date('Y'), 2030),
        'model_timezone' => 'America/Argentina/Buenos_Aires',
        'required' => false,
        'label' => 'Vencimiento Vtv',
        'attr' => array(
          'class' => 'form-control datepicker',
          'tabindex' => '5'))
      )
      ->add('informeDominio', TextType::class, array(
        'required' => false,
        'label' => 'Informe Dominio',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      )
      ->add('patentes', TextType::class, array(
        'required' => false,
        'label' => 'Patentes',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'))
      );
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => VehiculoUsado::class,
    ]);
  }
}
