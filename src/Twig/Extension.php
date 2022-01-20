<?php

namespace App\Twig;

use Twig\TwigFilter;
use App\Entity\Joueur;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use DateTime;

class Extension extends AbstractExtension {
    public function autorisations(Joueur $joueur)
    {
        $autorisations = "";
        foreach( $joueur->getRoles() as $role){
            switch ($role) {
                case 'ROLE_ADMIN':
                    $autorisations .= "Admin, ";
                    break;
                
                case 'ROLE_JOUEUR':
                    $autorisations .= "Joueur";
                    break;
            }
        }
        return $autorisations;
    }

    public function salut(Joueur $joueur, $auj = null)
    {
        $salutations = "Bonjour ";
        if( !empty($joueur->getPrenom()) || !empty($joueur->getNom()) ){
            $salutations .= $joueur->getPrenom() . " " . $joueur->getNom();
        } else {
            $salutations .= $joueur->getEmail();
        }
        $salutations .= ", nous sommes le ";
        $auj = $auj ?? (new DateTime())->format("d/m/Y");
        $salutations .= $auj;
        return $salutations;
    }

    /**
     * Les filtres que l'on veut ajouter doivent être renvoyés dans un array par la fonction getFilters
     * Chaque valeur de cet array est un objet de la classe TwigFilter
     * Les arguments du constructeur de TwigFilter :
     *      1er : le nom du filtre à utiliser dans les fichiers Twig
     *      2eme : la fonction qui est déclaré dans cette classe 
     *                  [ $this, nom_de_la_fonction_dans_la_classe ]
     */
    public function getFilters()
    {
        return [
            new TwigFilter("autorisations", [$this, "autorisations"]),
            new TwigFilter("salutations", [$this, "salut"]),
            
        ];
    }

    public function getFunctions(){
        return [
            new TwigFunction("autorisations", [$this, "autorisations"])
        ];
    }

}