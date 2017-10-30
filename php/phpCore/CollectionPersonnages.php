<?php
require_once "Collection.php";
require_once "../model/PersonnageM.php";

class CollectionPersonnages extends Collection
{
    /**
     * Personnages constructor
     */
    public function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch($ctp)
        {
            case 2:
                $this->constructCopie($args[0]);
                break;
            case 1:
                $this->construct2();
                break;
            default:
                $this->construct1();
                break;
        }
    }

    /**
     * Constructeur par recopie
     * @param $collectionPersos CollectionPersonnages
     * @return CollectionPersonnages
     */
    private function constructCopie($collectionPersos)
    {
        $newCollectionPersos = new CollectionPersonnages(null, null);   // pour appeller le contructeur "à deux args"
        foreach($collectionPersos->getTab() as $perso)
        {
            $newCollectionPersos->ajouter($perso);
        }
        return $newCollectionPersos;
    }

    private function construct1()
    {
        //$this->model('PersonnageM', []);
        $this->tab = PersonnageM::getChamps();
        usort($this->tab, "Personnage::compare");
    }

    /**
     * A partir de $tableauAGarder, creer un nouveau CollectionPersonnages
     * @param $tableauAGarder String[] le nom des personnages à garder
     * @return CollectionPersonnages
     */
    public function copie($tableauAGarder)
    {
        $collectionPerso = new CollectionPersonnages(null); // pour appeler le constructeur2
        foreach($tableauAGarder as $nomChamp)
        {
            $indice = CollectionPersonnages::dichotomie($this->tab, $nomChamp, 0, sizeof($this->tab));
            if($indice >= 0)
            {
                $collectionPerso->ajouter($this->tab[$indice]);
            }
        }
        return $collectionPerso;
    }

    private function construct2()
    {}

    /**
     * ajoute un Personnage au tableau $this->tab
     * @param $perso
     */
    public function ajouter($perso)
    {
        if(!($perso instanceof Personnage)) { /* TODO EXCEPTION */ }

        array_push($this->tab, $perso);
    }


    /**
     * @param $nb int nombre de personnages souhaité
     * @return Personnage
     */
    public function getAleatoire($nb)
    {
        return array_rand($this->tab, $nb);
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
            if($tab[$milieu]->getNameId() == $valeur)
                return $milieu;

            else if($tab[$milieu]->getNameId() < $valeur)
                return CollectionPersonnages::dichotomie($tab, $valeur, $milieu +1, $fin);

            else if($tab[$milieu]->getNameId() > $valeur)
                return CollectionPersonnages::dichotomie($tab, $valeur, $deb, $milieu -1);
        }
        return -1;
    }
}