<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'Pseudo',
                'constraints' => [
                    new NotBlank(['message' => 'Vous devez entrer un pseudo !']),
                    new Length([
                        'max' => 32,
                        'maxMessage' => 'Votre pseudo doit faire 32 charactères au maximum !'
                    ]),
                ]
            ])
            ->add("content", TextareaType::class, [
                'required' => true,
                'label' => 'Commentaire',
                'constraints' => [
                    new NotBlank(['message' => 'Vous devez écrire un contenu pour poster votre commentaire !']),
                    new Length([
                        'max' => 2048,
                        'maxMessage' => 'Votre commentaire doit faire 2048 charactères au maximum !'
                    ]),
                ]
            ])
            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
