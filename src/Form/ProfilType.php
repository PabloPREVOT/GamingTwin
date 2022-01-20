<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Jeu;
use App\Entity\Joueur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $joueur = $options["data"];
        $builder
            ->add('pseudo')
            ->add('password', PasswordType::class, [
                "mapped" => false,
                "label" => "Mot de passe",
                "required" => $joueur->getId() ? false : true,
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('discord_id')
            ->add('steam_id')
            ->add("tryhard_meter", RangeType::class, [
                "label" => "Niveau de chill / tryhard",
                "required" => true,
                'attr' => [
                    'min' => 0,
                    'max' => 10
                ],
            ])
            ->add('description')
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
                    "icone14" => "icones14.png",
                    "icone15" => "icones15.png",
                    "icone16" => "icones16.png",
                    "icone17" => "icones17.png",
                    "icone18" => "icones18.png",
                    "icone19" => "icones19.png",
                    "icone20" => "icones20.png",
                    "icone21" => "icones21.png",
                    "icone22" => "icones22.png",
                    "icone23" => "icones23.png",
                    "icone24" => "icones24.png",
                    "icone25" => "icones25.png",
                    "icone26" => "icones26.png",
                ], 
                "multiple" => false,
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
