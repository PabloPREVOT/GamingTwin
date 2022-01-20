<?php

namespace App\Form;

use App\Entity\Jeu, App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "required" => true,
                "constraints" => [
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le nom doit faire au minimum {{ limit }} lettres",
                        "max" => 50,
                        "maxMessage" => "Le nom doit faire au maximum {{ limit }} lettres",
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                "required" => true,
            ])
            ->add('categorie', EntityType::class, [
                "class" => Categorie::class,
                "choice_label" => "nom",
                "required" => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
