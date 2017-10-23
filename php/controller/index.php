<?php
    session_start();
    require_once "../phpCore/init.php";
//
//    echo '<!doctype html>
//    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
//              <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
//              <!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
//              <!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
//                  <head>
//                      <meta charset="utf-8">
//                      <title>Random Champ LOL</title>
//                      <meta name="description" content="">
//                      <meta name="viewport" content="width=device-width, initial-scale=1">
//                      <link rel="stylesheet" href="../../css/main.css" id="css">
//                      <link rel="icon" type="image/png" href="" />
//                  </head>
//    <body>';
//
//    $result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/champions?api_key=' . $apiKey . '&tags=image&dataById=true'); //&tags=image&DataById=true
////https://discussion.developer.riotgames.com/questions/309/where-can-i-find-the-server-path-for-champions-ima.html
//
//    $listeChampions = json_decode($result);
//
//    //ksort($listeChampions->data);
//
//    echo '<form method="post" action="selectionnerChamp.php">';
//    foreach($listeChampions->data as $champ)
//    {
//        echo '<input id="check' . $champ->name . '" class="checkChamp" value="' . $champ->name . '"
//                style="display: none;" name="nomChampion[]" type="checkbox">';
//        echo '<img id="' . $champ->name . '" class="imgChamp activeChamp"
//                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/champion/' . str_replace('\'', '', str_replace('\'', '', str_replace(' ', '', strval($champ->image->full)))) . '" title="' . $champ->name . '"
//                alt="' . $champ->name . '" onclick="activerPhoto(\'' . $champ->name . '\')">';
//    }
//    echo '</form>';

//    echo '
//    </body>
//</html>
//';

    require_once "../model/PersonnageM.php";

    require_once "../phpCore/CollectionPersonnages.php";
    require_once "../phpCore/Personnage.php";


    $persos = new CollectionPersonnages();
    $_SESSION['persos'] = serialize($persos);

    require_once "../view/PersonnagesV.php";
