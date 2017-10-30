<?php
session_start();
require_once "../phpCore/init.php";
require_once "../phpCore/CollectionPersonnages.php";
require_once "../phpCore/Personnage.php";
require_once "../phpCore/CollectionSummonerSpells.php";
require_once "../phpCore/SummonerSpell.php";
require_once "../model/ChampionSpellsM.php";
require_once "../phpCore/CollectionItems.php";
require_once "../phpCore/Item.php";


if(isset($_POST['nomChampion']))
{
    // ------------- PERSONNAGE ALEATOIRE ---------------
    $champGarde = $_POST['nomChampion'];

//foreach($champASupp as $champ)            //TEST
//    echo $champ . ' ';
//echo '<br/>';

    $persos = unserialize($_SESSION['persos']);
    $persos = $persos->copie($champGarde);

    // POUR LE COOKIE
    $tabCookie = array();
    foreach($persos->getTab() as $p)
    {
        array_push($tabCookie, $p->getId());
    }
    $tabCookie = serialize($tabCookie);
    setcookie("Persos",$tabCookie, time() + (180*24*60*60*1000), '/');
    // fin création cookie

    // si on a placé des "filtres", on supprime les champions qui ne correspondent pas
    if(isset($_POST['role']))
    {
        $role = $_POST['role'];
        if($role != "All")
        {
            $persosCopie = new CollectionPersonnages(null); // pour appeller le contructeur "par defaut"
            foreach ($persos->getTab() as $perso)
            {
                if (in_array($role, $perso->getTags())) 
                {
                    $persosCopie->ajouter($perso);
                }
            }
            $persos = $persosCopie;
        }
    }


    srand();
    $valeur = rand();
    $valeur = $valeur % (sizeof($persos->getTab()));


    $pers = ChampionSpellsM::getChamps();
    $spells = array();

    // On selectionne le personnage aléatoirement
    $idPerso = $persos->getTab()[$valeur]->getId();

    foreach($pers->data->$idPerso->spells as $sp)
    {
        array_push($spells, new SummonerSpell(null, $sp->name, $sp->image->full));
    }

    $champion = new Personnage($idPerso, $persos->getTab()[$valeur]->getName(),
                               $persos->getTab()[$valeur]->getTitle(), $persos->getTab()[$valeur]->getImage(), $spells, $persos->getTab()[$valeur]->getTags());

    // -------------- SUMMONERPELLS ALEATOIRE -------------

    $mode = htmlentities($_POST['mode']);

    $summonerSpells = new CollectionSummonerSpells($mode);

    srand();
    $valeur = rand();
    $valeur = $valeur % (sizeof($summonerSpells->getTab()));

    $sumSpell1 = new SummonerSpell($summonerSpells->getTab()[$valeur]->getId(), $summonerSpells->getTab()[$valeur]->getModes(),
        $summonerSpells->getTab()[$valeur]->getImage());

    $summonerSpells->supprimer($sumSpell1->getId());

    srand();
    $valeur = rand();
    $valeur = $valeur % (sizeof($summonerSpells->getTab()));

    $sumSpell2 = new SummonerSpell($summonerSpells->getTab()[$valeur]->getId(), $summonerSpells->getTab()[$valeur]->getModes(),
        $summonerSpells->getTab()[$valeur]->getImage());

    // -------------- STUFF ALEATOIRE ------------------

    $listItems = new CollectionItems($mode);

    // TODO test a enlever
    foreach($listItems->getTab() as $item)
    {
        echo '<img src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/item/' . $item->getImage() . '" alt="' . $item->getName() . '" 
                title="' . $item->getName() . '">';
    }



    $items = $listItems->getAleatoire(6, $sumSpell1, $sumSpell2, $champion);

    require_once "../view/aleatoireV.php";
}