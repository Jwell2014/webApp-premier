<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType:: class, [
                'attr'=> [ 'class'=> 'form-control'],
                ]  )
            ->add('name', TextType:: class, [
                'attr'=> [ 'class'=> 'form-control'],
            ] )
            ->add('firstname', TextType:: class, [
                'attr'=> [ 'class'=> 'form-control'],
            ]  )

            ->add('dateNaissance', DateType::class, [
                'widget'=> 'single_text',
                'html5'=> true,
                    'attr'=> [ 'class'=> 'form-control'],
                ]
            )

            ->add('plainPassword', RepeatedType::class, [
                'mapped'=> false,
                'attr'=> [ 'class'=> 'form-control'],
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'options' => ['attr' => ['class' => 'password-field', 'class'=> 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ])

            ->add('image', FileType::class, [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
