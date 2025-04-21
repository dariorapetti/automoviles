<?php

namespace App\Form;

use App\Entity\Grupo;
use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, array(
                'attr' => array('class' => 'form-control'))
            )
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control'))
            )
            ->add('apellido', TextType::class, array(
                'attr' => array('class' => 'form-control'))
            )
            ->add('cuit', TextType::class, array(
                'attr' => array('class' => 'form-control'))
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Contraseña',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La contraseña debe contener al menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'attr' => array('class' => 'form-control')
            ])
            ->add('grupos', EntityType::class,[
                'class' => Grupo::class,
                'required' => true,
                'multiple' => true,
                'label' => 'Grupos',
                'placeholder' => '-- Elija grupo --',
                'attr' => array(
                    'placeholder' => 'Escriba el grupo aquí.',
                    'class' => 'form-control choice',
                    'data-placeholder' => '-- Elija grupo --',
                    'tabindex' => '5'),
            ])
            ->add('allowPasswordChange', CheckboxType::class, array(
                    'required' => true,
                    'label' => 'Puede cambiar contraseña',
                    'attr' => array(
                        'class' => 'form-control',
                        'tabindex' => '5'
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class
        ]);
    }
}