<?php
    session_start();
    require_once "../phpCore/init.php";

    require_once "../model/PersonnageM.php";

    require_once "../phpCore/CollectionPersonnages.php";
    require_once "../phpCore/Personnage.php";

    // recuperer cookie persos : tabCookie contient les id des persos
    $tabCookie = array();
    $tabCookie = unserialize($_COOKIE["Persos"]);
    sort($tabCookie);


    $persos = new CollectionPersonnages();
    $_SESSION['persos'] = serialize($persos);


    function dichotomie($tab, $valeur, $deb, $fin)
    {
        if($deb <= $fin)
        {
            $milieu = (int)(($deb + $fin) /2);
            if($tab[$milieu] == $valeur)
                return $milieu;

            else if($tab[$milieu] < $valeur)
                return dichotomie($tab, $valeur, $milieu +1, $fin);

            else if($tab[$milieu] > $valeur)
                return dichotomie($tab, $valeur, $deb, $milieu -1);
        }
        return -1;
    }

    require_once "../view/PersonnagesV.php";
