<?php

namespace App\Form;

use Mpdf\Tag\TextArea;
use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class ClienteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nombre', TextType::class, array(
              'required' => true,
              'label' => 'Nombre',
              'attr' => array(
                'class' => 'form-control',
                'tabindex' => '5'))
            )
      ->add('direccion', TextType::class, array(
              'required' => true,
              'label' => 'Dirección',
              'attr' => array(
                'class' => 'form-control',
                'tabindex' => '5'))
            )   
      ->add('telefono', TextType::class, array(
              'required' => true,
              'label' => 'Teléfono',
              'attr' => array(
                'class' => 'form-control',
                'tabindex' => '5'))
            )
      ->add('email', EmailType::class, array(
              'required' => true,
              'label' => 'Email',
              'attr' => array(
                'class' => 'form-control',
                'tabindex' => '5'))
            )
      ->add('comentario', TextArea::class, array(
              'required' => false,
              'label' => 'Comentario',
              'attr' => array(
                'class' => 'form-control',
                'tabindex' => '5'))
      );        
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Cliente::class,
    ]);
  }
}
