<?php

namespace App\Form;

use App\Entity\Proveedor;
use Mpdf\Tag\TextArea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;                                 

class ProveedorType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder    
      ->add('razonSocial', TextType::class, array(
                'required' => true,
                'label' => 'Razón Social',
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
      ->add('telefonoOperador', TextType::class, array(
              'required' => true,
              'label' => 'Teléfono Operador',
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
        'data_class' => Proveedor::class,
      ]);
    }
}
