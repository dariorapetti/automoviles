<?php

namespace App\Form;

use App\Entity\Marca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class MarcaType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nombre', TextType::class, array(
        'required' => true,
        'label' => 'Nombre',
        'attr' => array(
          'class' => 'form-control',
          'tabindex' => '5'
        ))
      );
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Marca::class,
    ]);
  }
}
