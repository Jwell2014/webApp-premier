<?php

namespace App\Form;

use App\Entity\Category;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchBar', TextType::class, [
                'required'=> false,
                'attr'=> [ 'class'=> 'form-control']
            ] )

            ->add('category', EntityType::class, [
                'required'=> false,
                'class'=> Category::class,
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
                'expanded'=> true,
                'multiple'=> true,
                'attr'=> ['class'=> 'form-control px-2'],
            ])
            ->add('prixMin', NumberType::class, [
                'required'=> false,
                'attr'=> ['class'=> 'form-control']
                ])

            ->add('prixMax', NumberType::class, [
                'required'=> false,
                'attr'=> ['class'=> 'form-control']
            ])

            ->add('Save', SubmitType::class, [
                'attr'=> ['class'=> 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
