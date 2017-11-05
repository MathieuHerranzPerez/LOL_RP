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
require_once "../phpCore/Chiffre.php";


if(isset($_POST['nomChampion']))
{
    $chaineResultat = "";   // pour que l'utilisateur puisse passer un lien

    // ------------- PERSONNAGE ALEATOIRE ---------------
    $champGarde = $_POST['nomChampion'];


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
        $role = htmlentities($_POST['role']);
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


    if(sizeof($persos->getTab()) > 0)
    {
        srand();
        $valeur = rand();
        $valeur = $valeur % (sizeof($persos->getTab()));


        $pers = ChampionSpellsM::getChamps();
        $spells = array();

        // On selectionne le personnage aléatoirement
        $idPerso = $persos->getTab()[$valeur]->getId();

        // pour le lien
        $chaineResultat .= $idPerso . "-";

        foreach ($pers->data->$idPerso->spells as $sp)
        {
            array_push($spells, new SummonerSpell(null, $sp->name, $sp->image->full));
        }

        $champion = new Personnage($idPerso, $persos->getTab()[$valeur]->getName(), $persos->getTab()[$valeur]->getNameId(),
            $persos->getTab()[$valeur]->getTitle(), $persos->getTab()[$valeur]->getImage(), $spells, $persos->getTab()[$valeur]->getTags());

        // tableau pour l'assignement des sorts à maxer
        $arrayChiffre = array(1, 2, 3);
        shuffle($arrayChiffre);

        $chaineResultat .= $arrayChiffre[0] . "-";
        $chaineResultat .= $arrayChiffre[1] . "-";
        $chaineResultat .= $arrayChiffre[2] . "-";

        // -------------- SUMMONERPELLS ALEATOIRE -------------

        $mode = htmlentities($_POST['mode']);

        $summonerSpells = new CollectionSummonerSpells($mode);

        srand();
        $valeur = rand();
        $valeur = $valeur % (sizeof($summonerSpells->getTab()));

        $sumSpell1 = new SummonerSpell($summonerSpells->getTab()[$valeur]->getId(), $summonerSpells->getTab()[$valeur]->getModes(),
            $summonerSpells->getTab()[$valeur]->getImage());

        $summonerSpells->supprimer($sumSpell1->getId());

        $chaineResultat .=  $sumSpell1->getId() . "-";

        srand();
        $valeur = rand();
        $valeur = $valeur % (sizeof($summonerSpells->getTab()));

        $sumSpell2 = new SummonerSpell($summonerSpells->getTab()[$valeur]->getId(), $summonerSpells->getTab()[$valeur]->getModes(),
            $summonerSpells->getTab()[$valeur]->getImage());

        $chaineResultat .=  $sumSpell2->getId() . "-";

        // -------------- STUFF ALEATOIRE ------------------

        // on récupere le type de stuff
        $typeStuff = htmlentities($_POST['typeStuff']);
        $chaineResultat .= $typeStuff . "-";

        // on selectionne les items
        $items = selectionnerItems($mode, $typeStuff, $sumSpell1, $sumSpell2, $champion);


        // pour le lien
        foreach($items as $it)
        {
            $chaineResultat .= $it->getId() . "-";
        }

        $chaineResultat = Chiffre::encrypt($chaineResultat);


        require_once "../view/aleatoireV.php";
    }
    else
    {
        require_once "../view/erreurV.php";
    }
}
else
{
    require_once "../view/erreurV.php";
}

/**
 * @param $mode
 * @param $typeStuff
 * @param $sumSpell1
 * @param $sumSpell2
 * @param $champion
 * @return CollectionItems les items selectionnés
 */
function selectionnerItems($mode, $typeStuff, $sumSpell1, $sumSpell2, $champion)
{
    if($typeStuff == "Random")
    {
        $listItems = new CollectionItems($mode);
        $resultat = $listItems->getAleatoire(6, $sumSpell1, $sumSpell2, $champion);
    }
    else if($typeStuff == "Medium")
    {
        $listItems = new CollectionItems($mode, $typeStuff);
//                    // TODO test a enlever
//        foreach ($listItems->getTab() as $item)
//        {
//            echo '<img src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/item/' . $item->getImage() . '" alt="' . $item->getName() . '"
//                title="' . $item->getName() . '">';
//        }
        // on recupere les items essentiels et on y ajoute un item jungle si besoin
        $resultat = $listItems->getEssentiels($sumSpell1, $sumSpell2, $champion, $mode);

        $nb = 6 - sizeof($resultat);
        // on remplie avec de l'aleatoire
        $resultat = $listItems->remplirAleatoire($nb, $resultat);
    }
    else if($typeStuff == "Correct")
    {

    }
    else
    {
        $listItems = new CollectionItems($mode, $typeStuff);
        $resultat = $listItems->getAleatoire(6, $sumSpell1, $sumSpell2, $champion);
    }


//            // TODO test a enlever
//        foreach ($listItems->getTab() as $item)
//        {
//            echo '<img src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/item/' . $item->getImage() . '" alt="' . $item->getName() . '"
//                title="' . $item->getName() . '">';
//        }
    return $resultat;
}