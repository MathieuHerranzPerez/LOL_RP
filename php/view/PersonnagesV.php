<?php

displayEntete(null);
//ob_start();

    echo '<button onclick="toutSelectionner()">Tout selectionner</button>';
    echo '<button onclick="toutDeselectionner()">Tout déselectionner</button><br/>';

    echo '<form method="post" action="' . WEBROOT . 'php/controller/aleatoire.php">';
    echo '<select name="mode">
            <option value="CLASSIC" selected>Summoner Rift</option>
            <option value="ARAM">Aram</option>
          </select><br/>';

    foreach($persos->getTab() as $champ)
    {
        echo '<input id="check' . $champ->getNameId() . '" class="checkChamp" value="' . $champ->getNameId() . '"
                style="display: none;" name="nomChampion[]" type="checkbox" checked>';
        echo '<img id="' . $champ->getNameId() . '" class="imgChamp activeChamp"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/champion/' . $champ->getImage() . '" title="' . $champ->getName() . '"
                alt="' . $champ->getName() . '" onclick="togglePhoto(\'' . $champ->getNameId() . '\')">';
    }

    echo '<br/><button type="submit" name="champ"><h2>Générer</h2></button>';
    echo '</form>';

displayFin();

//$contenu = ob_get_clean();

//require_once '../../template.php';