<?php

namespace App\Form;

use App\Entity\ArchivoAdjunto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArchivoAdjuntoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('archivo', FileType::class, array(
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '200M',
                        'mimeTypes' => [
                            "application/pdf",
                            "application/x-pdf",
                            "application/msword",
                            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                            "application/vnd.ms-excel",
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                            "image/png",
                            "image/jpeg",
                            "image/pjpeg",
                            "application/x-rar",
                            "application/x-rar-compressed",
                            "application/octet-stream",
                            "application/zip",
                            "application/x-zip-compressed",
                            "multipart/x-zip",
                            "text/plain",
                        ],
                        'mimeTypesMessage' => 'El tipo de archivo no es válido.',
                    ])
                ],
                'label' => 'Archivo',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array(
                    'class' => 'form-control filestyle',
                    'data-buttonText' => "Examinar"
                )
            ))
            ->add(
                'descripcion',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Descripción',
                    'attr' => array(
                        'placeholder' => 'Escriba la descripción aquí.',
                        'class' => 'form-control',
                        'tabindex' => '5'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArchivoAdjunto::class,
        ]);
    }
}
