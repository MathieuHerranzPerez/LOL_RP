<?php

displayEntete("img/summonerRift.jpg");
//ob_start();
echo '<h1 style="font-family: Cinzel, Helvetica, serif; font-size: 50px; margin-top: 50px; color: #cac1bd;">RANDOM PICK<br/>LEAGUE OF LEGENDS</h1>';
echo '<div class="col-xl-12 degradeHautBas"></div>';
echo '<div class="row personnagesRow">';


echo '<form method="post" action="' . WEBROOT . 'php/controller/aleatoire.php" style="overflow: auto;">';
    echo '<div class="col-xl-4 degrade" style="float: left;">';

    echo '<h2>On which map ?</h2>';
    echo '<select name="mode">
            <option value="CLASSIC" selected>Summoner Rift</option>
            <option value="ARAM">Aram</option>
          </select><br/>';

    echo '<h2>What king of stuff ?</h2>';
    echo '<select name="typeStuff">
            <option value="Random" selected>Random</option>
            <!--<option value="Medium">Medium</option>-->
            <!--<option value="Correct">Correct</option>-->
            <option value="AD">AD</option>
            <option value="AP">AP</option>
            <option value="Tank">Tank</option>
            <option value="FullAD">Full AD</option>
            <option value="FullAP">Full AP</option>
            <option value="FullTank">Full Tank</option>
          </select><br/>';

    echo '<br/><center><button  class="btnGenerer" type="submit" name="champ">Get Started</button></center>';
echo '</div>';
    echo '<div class="col-md-8 listeChamp" style="padding: 3% 3% 3% 10%; overflow: hidden; height: 100%">';
    echo '<div style="overflow: hidden;">';
    echo '<button type=button class="btnPerso" onclick="toutSelectionner()">Select all</button>';
    echo '<button type=button class="btnPerso" onclick="toutDeselectionner()">Unselect all</button>';

    echo '<div class="role">';
    echo 'Role : <select name="role">
                <option value="All" selected>All</option>
                <option value="Marksman">Marksman</option>
                <option value="Assassin">Assassin</option>
                <option value="Support">Support</option>
                <option value="Mage">Mage</option>
                <option value="Fighter">Fighter</option>
                <option value="Tank">Tank</option>
              </select><br/>';
    echo '</div>';
    echo '</div>';

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

    echo '</div>';
echo '</form>';
echo '</div>';      // row
displayFin();

//$contenu = ob_get_clean();

//require_once '../../template.php';