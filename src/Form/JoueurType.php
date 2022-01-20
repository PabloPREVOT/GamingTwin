<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Jeu;
use App\Entity\Joueur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $joueur = $options["data"];
        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Admin" => "ROLE_ADMIN",
                    "Joueur" => "ROLE_JOUEUR",
                ],
                "multiple" => true,
                "expanded" => true,
                "label" => "Droit d'accès :"
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
