<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomImage', FileType::class, [
                'mapped'=> false,
                'attr'=> [ 'class'=> 'form-control'],
                'required'=> false,
                'constraints'=> [
                    new File([

                        'mimeTypes'=> [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage'=> 'Veuillez télécharger une image JPG ou PNG'
                    ])
                ]

            ])
            ->add('alt', TextType::class, [

                'attr'=> [ 'class'=> 'form-control']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
