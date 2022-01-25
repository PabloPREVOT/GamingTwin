<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Jeu;
use App\Entity\Joueur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $joueur = $options["data"];
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
            ->add('password', PasswordType::class, [
                "mapped" => false,
                "label" => "Mot de passe",
                "required" => $joueur->getId() ? false : true,
            ])
            ->add("nom", TextType::class, [
                "label" => "nom :",
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
                "label" => "prénom :",
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
                "label" => "email :",
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
                "label" => "Catégorie de jeux :",
                "class" => Categorie::class,
                "choice_label" => "nom",
                "required" => false,
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('jeu', EntityType::class, [
                "label" => "Jeux préférés :",
                "class" => Jeu::class,
                "choice_label" => "nom",
                "required" => false,
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('profil_img', ChoiceType::class, [
                "label" => "Image de profil :",
                "attr" => ["id" => "profil_select"],
                "choices" => [
                    "icone1" => "icone1.png",
                    "icone2" => "icone2.png",
                    "icone3" => "icone3.png",
                    "icone4" => "icone4.png",
                    "icone5" => "icone5.png",
                    "icone6" => "icone6.png",
                    "icone7" => "icone7.png",
                    "icone8" => "icone8.png",
                    "icone9" => "icone9.png",
                    "icone10" => "icone10.png",
                    "icone11" => "icone11.png",
                    "icone12" => "icone12.png",
                    "icone13" => "icone13.png",
                    "icone14" => "icone14.png",
                    "icone15" => "icone15.png",
                    "icone16" => "icone16.png",
                    "icone17" => "icone17.png",
                    "icone18" => "icone18.png",
                    "icone19" => "icone19.png",
                    "icone20" => "icone20.png",
                    "icone21" => "icone21.png",
                    "icone22" => "icone22.png",
                    "icone23" => "icone23.png",
                    "icone24" => "icone24.png",
                    "icone25" => "icone25.png",
                    "icone26" => "icone26.png",
                ], 
                "multiple" => false,
                "expanded" => false,
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
