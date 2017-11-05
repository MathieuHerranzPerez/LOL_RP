<?php

require_once "Collection.php";
require_once "Item.php";
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
            case 2:
                $this->construct3($args[0], $args[1]);
                break;
            case 1:
                $this->construct2($args[0]);
                break;
            default:
                $this->construct1();
                break;
        }
    }
    public function construct1()
    {
        $this->tab = ItemM::getItems("CLASSIC", null);
        $this->changerItemOrnn();
        usort($this->tab, "Item::compare");
    }

    public function construct2($mode)
    {
        $this->tab = ItemM::getItems($mode, null);
        $this->changerItemOrnn();
        usort($this->tab, "Item::compare");
    }

    public function construct3($mode, $typeItem)
    {
        $this->tab = ItemM::getItems($mode, $typeItem);
        $this->changerItemOrnn();
        usort($this->tab, "Item::compare");
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

    /**
     * Supprimer de la collection l'item ayant l'id $id
     * @param $id int l'id de l'item a supprimer
     */
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
     * Parcours la collection et change tous les items évolués d'Ornn par leurs correspondants
     */
    public function changerItemOrnn()
    {
        //remplace les items de Ornn
        for($i = 0; $i < sizeof($this->tab); ++$i)
        {
            if(stripos($this->tab[$i]->getColloq(), "Ornn") !== false)
            {
                $idFils = $this->tab[$i]->getFrom()[0];
                $this->supprimer($this->tab[$i]->getId());
                $this->ajouter(ItemM::getItemById($idFils));
                $i -= 1;    // pour refaire l'element courant (il a été remplacé car supprimé
            }
        }
    }

    public function supprimerBoots()
    {
        foreach ($this->tab as $item)
        {
            // on supprime les boots de la collection
            if (is_array($item->getTags()))
            {
                foreach ($item->getTags() as $tag)
                {
                    if ($tag == "Boots")
                    {
                        $this->supprimer($item->getId());
                    }
                }
            }
        }
    }

    public function supprimerJungleItems()
    {
        foreach($this->tab as $item)
        {
            if(strpos($item->getName(), "Enchantment") !== false)
            {
                $this->supprimer($item->getId());
            }
        }
    }

    public function supprimerEnFonction($indice)
    {
        // s'il s'agit du Hextech
        if( strpos($this->tab[$indice]->getName(), 'Hextech') !== false )
        {
            // on supprime les autres items Hextem du tableau pour ne pas les avoir
            foreach($this->tab as $item)
            {
                if( strpos($item->getName(), 'Hextech') !== false )
                    $this->supprimer($item->getId());
            }
        }
        // s'il s'agit du item à Gold
        else if( in_array("GoldPer", $this->tab[$indice]->getTags()) == true)
        {
            // on supprime les autres items à gold du tableau pour ne pas les avoir
            foreach($this->tab as $item)
            {
                if( in_array("GoldPer", $item->getTags()) == true )
                    $this->supprimer($item->getId());
            }
        }
        //si il s'agit d'un item a ward
        else if(in_array("Vision", $this->tab[$indice]->getTags()))
        {
            // on supprime les autres items à ward du tableau pour ne pas les avoir
            foreach($this->tab as $item)
            {
                if(in_array("Vision", $item->getTags()))
                    $this->supprimer($item->getId());
            }
        }
        else
            $this->supprimer($this->tab[$indice]->getId());
    }

    /**
     * @param $nb int nombre de Items souhaité
     * @param $sumSpell1
     * @param $sumSpell2
     * @param $champion
     * @return Item[]
     */
    public function getAleatoire($nb, $sumSpell1, $sumSpell2, $champion)
    {
        $randItems = array();

        // gestion du cas particulier Viktor
        if($champion->getName() == "Viktor")
        {
            $itemVik = ItemM::getViktorItem();
            array_push($randItems, $itemVik);
            --$nb;
        }

        // gestion des boots
        if($champion->getName() != "Cassiopeia")
        {
            $cptBoots = 0;
            $itemBoots = array();
            foreach($this->tab as $item)
            {
                // on supprime les boots de la collection
                if(is_array($item->getTags()))
                {
                    foreach ($item->getTags() as $tag)
                    {
                        if ($tag == "Boots") {
                            if ($cptBoots < 1)
                            {
                                array_push($itemBoots, new Item($item->getId(), $item->getName(), $item->getPlaintext(),
                                    $item->getImage(), $item->getGold(), $item->getMaps(), $item->getTags(), $item->getColloq(), $item->getFrom()));
                            }
                            $this->supprimer($item->getId());
                        }
                    }
                }
            }
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($itemBoots));
            array_push($randItems, $itemBoots[$valeur]);
            --$nb;
        }
        else // if($champion->getName() == "Cassiopeia")
        {
            $this->supprimerBoots();
        }

        // Dans le cas où un des summoner spells est un smite
        if($sumSpell1->getName() == "SummonerSmite" || $sumSpell2->getName() == "SummonerSmite")
        {
            $itemJungle = array();
            foreach($this->tab as $item)
            {
                if(strpos($item->getName(), "Enchantment") !== false)
                {
                    array_push($itemJungle, new Item($item->getId(), $item->getName(), $item->getPlaintext(),
                        $item->getImage(), $item->getGold(), $item->getMaps(), $item->getTags(), $item->getColloq(), $item->getFrom()));
                    $this->supprimer($item->getId());
                }
            }
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($itemJungle));
            array_push($randItems, $itemJungle[$valeur]);
            --$nb;
        }
        // on supprime les items jungle
        $this->supprimerJungleItems();

        // on selectionne les items
        for($i = 0; $i < $nb; $i++)
        {
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($this->tab));
            array_push($randItems,$this->tab[$valeur]);

            $this->supprimerEnFonction($valeur);

        }
        return $randItems;
    }

    /**
     * On recupere les items essentiels et on place un item jungle si besoin
     * @param $sumSpell1
     * @param $sumSpell2
     * @param $champion
     * @param $mode
     * @return array
     */
    public function getEssentiels($sumSpell1, $sumSpell2, $champion, $mode)
    {
        $essentialItems = array();

        // Dans le cas où un des summoner spells est un smite
        if($sumSpell1->getName() == "SummonerSmite" || $sumSpell2->getName() == "SummonerSmite")
        {
            $itemJungle = array();
            foreach($this->tab as $item)
            {
                if(strpos($item->getName(), "Enchantment") !== false)
                {
                    array_push($itemJungle, new Item($item->getId(), $item->getName(), $item->getPlaintext(),
                        $item->getImage(), $item->getGold(), $item->getMaps(), $item->getTags(), $item->getColloq(), $item->getFrom()));
                    $this->supprimer($item->getId());
                }
            }
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($itemJungle));
            array_push($essentialItems, $itemJungle[$valeur]);
        }
        // on supprime les items jungle
        $this->supprimerJungleItems();

        // on recupere les id des essentiels
        $tmp = PersonnageM::getChampStuff($champion, "essential", $mode);


        // pour chaque id d'objet, on ajoute au tableau l'objet associé en le supprimant de la collection
        foreach($tmp as $id)
        {
            $indice = CollectionItems::getIndiceParId($this->tab, $id);
            if($indice >= 0)
            {
                array_push($essentialItems, $this->tab[$indice]);
                $this->supprimerEnFonction($indice);
            }
        }

        // on supprime les boots de la collection
        $this->supprimerBoots();


        return $essentialItems;
    }

    public function remplirAleatoire($nb, $tabItemsPresents)
    {
        $resultat = $tabItemsPresents;
        // on selectionne les items
        for($i = 0; $i < $nb; $i++)
        {
            srand();
            $valeur = rand();
            $valeur = $valeur % (sizeof($this->tab));
            array_push($resultat,$this->tab[$valeur]);

            $this->supprimerEnFonction($valeur);
        }

        return $resultat;
    }

    /**
     * @param $tab
     * @param $valeur string nom
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

    /**
     * @param $tab
     * @param $id int l'id de l'item cherché
     * @return int l'indice de l'emplacement de l'Item cherché
     */
    public static function getIndiceParId($tab, $id)
    {
        $indice = -1;
        $i = 0;
        foreach($tab as $item)
        {
            if($item->getId() == $id)
            {
                $indice = $i;
            }
            ++$i;
        }

        return $indice;
    }
}