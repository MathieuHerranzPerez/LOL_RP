<?php

require_once "Collection.php";
require_once "../model/ItemM.php";

class CollectionItems extends Collection
{

    /**
     * Items constructor
     */
    public function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch($ctp)
        {
            case 1:
                $this->construct2();
                break;
            default:
                $this->construct1();
                break;
        }
    }
    public function construct1()
    {
        $this->tab = ItemM::getItems();
        usort($this->tab, "Item::compare");
    }

    public function construct2()
    {
    }

    /**
     * ajoute un Item au tableau $this->tab
     * @param $item
     */
    public function ajouter($item)
    {
        if(!($item instanceof Item)) { /* TODO EXCEPTION */ }

        array_push($this->tab, $item);
    }


    public function supprimer($id)
    {
        $indice = -1;
        $i = 0;
        foreach($this->tab as $item)
        {
            if($item->getId() == $id)
            {
                $indice = $i;
            }
            ++$i;
        }

        unset($this->tab[$indice]);
        $this->tab = array_values($this->tab);  // pour ne pas sauter d'indice
    }


    /**
     * @param $nb int nombre de Items souhaité
     * @return Item
     */
    public function getAleatoire($nb)
    {
        $randItems = array();

        for($i = 0; $i < $nb; $i++) {
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($this->tab));
            array_push($randItems,$this->tab[$valeur]);
            $this->supprimer($this->tab[$valeur]->getId());
        }
        return $randItems;
    }

    /**
     * @param $tab
     * @param $valeur
     * @param $deb
     * @param $fin
     * @return int indice si trouvé, -1 si non trouvé
     */
    private static function dichotomie($tab, $valeur, $deb, $fin)
    {
        if($deb <= $fin)
        {
            $milieu = (int)(($deb + $fin) /2);
            if($tab[$milieu]->getName() == $valeur)
                return $milieu;

            else if($tab[$milieu]->getName() < $valeur)
                return CollectionItems::dichotomie($tab, $valeur, $milieu +1, $fin);

            else if($tab[$milieu]->getName() > $valeur)
                return CollectionItems::dichotomie($tab, $valeur, $deb, $milieu -1);
        }
        return -1;
    }
}