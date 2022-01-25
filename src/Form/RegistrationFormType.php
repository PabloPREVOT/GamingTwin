<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Jeu;
use App\Entity\Joueur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                "label" => "Pseudo :",
                "required" => true,
                'constraints' => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le pseudo doit faire au minimum {{ limit }} caractères",
                        "max" => 20,
                        "maxMessage" => "Le pseudo doit faire au maximum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" => "Conditions générales d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez acceptez les conditions générales d’utilisation',
                    ]),
                ],
            ])
            ->add('chartreToxic', CheckboxType::class, [
                "label" => "Je certifie de respecter les autres joueurs",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez acceptez la chartre',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                "label" => "Mot de passe :",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add("nom", TextType::class, [
                "label" => "Nom :",
                "required" => true,
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le nom doit faire au minimum {{ limit }} lettres",
                        "max" => 20,
                        "maxMessage" => "Le nom doit faire au maximum {{ limit }} lettres",
                    ])
                ]
            ])
            ->add("prenom", TextType::class, [
                "label" => "Prénom :",
                "required" => true,
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le prénom doit faire au minimum {{ limit }} lettres",
                        "max" => 20,
                        "maxMessage" => "Le prénom doit faire au maximum {{ limit }} lettres",

                    ])
                ]
            ])
            ->add("email", EmailType::class, [
                "label" => "Email :",
                "required" => true,
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "L'email peut faire au maximum {{ limit }} charactères",
                    ])
                ]
            ])
            ->add("discord_id", TextType::class, [
                "label" => "Id discord :",
                "required" => false,
                "constraints" => [
                    new Length([
                        "max" => 30,
                        "maxMessage" => "L'id discord peut faire au maximum {{ limit }} charactères",
                    ])
                ]
            ])
            ->add("steam_id", TextType::class, [
                "label" => "Id steam :",
                "required" => false,
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "L'id steam peut faire au maximum {{ limit }} charactères",
                    ])
                ]
            ])
            ->add("tryhard_meter", RangeType::class, [
                "label" => "Niveau de chill / tryhard",
                "required" => true,
                'attr' => [
                    'min' => 0,
                    'max' => 10
                ],
            ])
            ->add("description", TextareaType::class, [
                "label" => "Votre description :",
                "required" => false,
                "constraints" => [
                    new Length([
                        "max" => 400,
                        "maxMessage" => "La descripion peut faire au maximum {{ limit }} charactères",
                    ])
                ]
            ])
            ->add('categorie', EntityType::class, [
                "label" => "Catégorie de jeux que vous préférez :",
                "class" => Categorie::class,
                "choice_label" => "nom",
                "required" => false,
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('jeu', EntityType::class, [
                "label" => "Vos jeux préférés :",
                "class" => Jeu::class,
                "choice_label" => "nom",
                "required" => false,
                "multiple" => true,
                "expanded" => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
