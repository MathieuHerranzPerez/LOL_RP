<?php
require_once "../phpCore/init.php";
require_once "../phpCore/CollectionPersonnages.php";
require_once "../phpCore/Personnage.php";
require_once "../phpCore/CollectionSummonerSpells.php";
require_once "../phpCore/SummonerSpell.php";
require_once "../model/ChampionSpellsM.php";
require_once "../phpCore/CollectionItems.php";
require_once "../phpCore/Item.php";
require_once "../phpCore/Chiffre.php";

if(isset($_GET['chaine']))
{
    $chaine = Chiffre::decrypt($_GET['chaine']);

    // on recupere la chaine qu'on range dans un array
    $data = array();
    $str = "";
    for ($i = 0; $i < strlen($chaine); ++$i)
    {
        if ($chaine[$i] != '-')
        {
            $str .= $chaine[$i];
        }
        else
        {
            array_push($data, $str);
            $str = "";
        }
    }

    $perso = $data[0];
    $arrayChiffre = array();
    array_push($arrayChiffre, $data[1]);
    array_push($arrayChiffre, $data[2]);
    array_push($arrayChiffre, $data[3]);
    $sum1 = $data[4];
    $sum2 = $data[5];
    $item[0] = $data[6];
    $item[1] = $data[7];
    $item[2] = $data[8];
    $item[3] = $data[9];
    $item[4] = $data[10];
    $item[5] = $data[11];

    $chaineResultat = $perso . '-' . $sum1 . '-' . $sum2 . '-' . $item[0] . '-' . $item[1] . '-' . $item[2] . '-' .
        $item[3] . '-' . $item[4] . '-' . $item[5] . '-';
    $chaineResultat = Chiffre::encrypt($chaineResultat);

    $spells = ChampionSpellsM::getSpellByChampId($perso);
    $champion = PersonnageM::getChampById($perso, $spells);
    $sumSpell1 = SummonerSpellM::getSortById($sum1);
    $sumSpell2 = SummonerSpellM::getSortById($sum2);
    $items = array();
    for ($i = 0; $i < 6; ++$i)
    {
        array_push($items, ItemM::getItemById($item[$i]));
    }

    if ($spells != null && $champion != null && $sumSpell1 != null && $sumSpell2 != null && $items != null)
    {
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