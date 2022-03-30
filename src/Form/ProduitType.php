<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType:: class, [
                'attr'=> [ 'class'=> 'form-control'],
            ]  )
            ->add('description', TextType:: class, [
                'attr'=> [ 'class'=> 'form-control'],
            ]  )
            ->add('produitPhare', ChoiceType::class, [
                'attr'=> [ 'class'=> 'form-control'],
                'choices' => [
                    'oui'=> true,
                    'non'=> false,
                ]
                ])
            ->add('image', FileType::class, [
                'mapped'=> false,
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
            ->add('images', CollectionType::class, [
                'entry_type'=> ImageType::class,
                'allow_add'=> true,
                'prototype'=> true,
            ])
            ->add('parent', EntityType::class, [
                'required'=> false,
                'class'=> Category::class,
                'attr'=> ['class'=> 'form-control']
            ])
            ->add('prix', NumberType::class, [
                'attr'=> ['class'=> 'form-control']
            ])
            ->add('nbStar', ChoiceType::class, [
                'choices'=>[
                    '⭐️'=> 1,
                    '⭐⭐'=> 2,
                    '⭐⭐⭐'=> 3,
                    '⭐⭐⭐⭐'=> 4,
                    '⭐⭐⭐⭐⭐'=> 5,
                ],
                'attr'=> ['class'=> 'form-control px-2'],
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
