<?php
session_start();
require_once "../phpCore/init.php";
require_once "../phpCore/CollectionPersonnages.php";
require_once "../phpCore/Personnage.php";
require_once "../phpCore/CollectionSummonerSpells.php";
require_once "../phpCore/SummonerSpell.php";
require_once "../model/ChampionSpellsM.php";

if(isset($_POST['nomChampion']))
{
    // ------------- PERSONNAGE ALEATOIRE ---------------
    $champASupp = $_POST['nomChampion'];

//foreach($champASupp as $champ)            //TEST
//    echo $champ . ' ';
//echo '<br/>';

    $persos = unserialize($_SESSION['persos']);
    $persos = $persos->copie($champASupp);

    srand();
    $valeur = rand();
    $valeur = $valeur % (sizeof($persos->getTab()));

//foreach($persos->getTab() as $champ)      //TEST
//    echo $champ->getName() . ' ';
//echo '<br/>';

    $pers = ChampionSpellsM::getChamps();
    $spells = array();

    $idPerso = $persos->getTab()[$valeur]->getId();

    foreach($pers->data->$idPerso->spells as $sp)
    {
        array_push($spells, new SummonerSpell(null, $sp->name, $sp->image->full));
    }

    $champion = new Personnage($idPerso, $persos->getTab()[$valeur]->getName(),
                               $persos->getTab()[$valeur]->getTitle(), $persos->getTab()[$valeur]->getImage(), $spells);

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

    require_once "../view/aleatoireV.php";
}