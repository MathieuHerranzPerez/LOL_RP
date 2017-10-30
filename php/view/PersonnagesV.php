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

    echo '<select name="role">
            <option value="All" selected>All</option>
            <option value="Marksman">Marksman</option>
            <option value="Assassin">Assassin</option>
            <option value="Support">Support</option>
            <option value="Mage">Mage</option>
            <option value="Fighter">Fighter</option>
            <option value="Tank">Tank</option>
          </select><br/>';

    foreach($persos->getTab() as $champ)
    {
        echo '<input id="check' . $champ->getId() . '" class="checkChamp" value="' . $champ->getNameId() . '"
                style="display: none;" name="nomChampion[]" type="checkbox"';
        if(dichotomie($tabCookie, $champ->getId(), 0, sizeof($tabCookie)) >= 0)  // suivant la valeur du cookie, on check ou non les personnages
        {
            echo ' checked';
        }
        echo '>';

        echo '<img id="' . $champ->getId() . '" class="imgChamp';
        if(dichotomie($tabCookie, $champ->getId(), 0, sizeof($tabCookie)) >= 0)
        {
            echo ' activeChamp';
        }
        else
        {
            echo ' inactiveChamp';
        }
        echo '" src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/champion/' . $champ->getImage() . '" title="' . $champ->getName() . '"
                alt="' . $champ->getName() . '" onclick="togglePhoto(\'' . $champ->getId() . '\')">';
    }

    echo '<br/><button type="submit" name="champ"><h2>Générer</h2></button>';
    echo '</form>';

displayFin();

//$contenu = ob_get_clean();

//require_once '../../template.php';