<?php

displayEnteteAlea("http://ddragon.leagueoflegends.com/cdn/img/champion/splash/" . str_replace('.png', '_0.jpg', $champion->getImage()));

echo '<div class="row" >
        <div class="infos col-xl-4">
        <div class="row sectionInfos" style="margin-bottom: 15%;margin-top:15%">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-4">
                <img id="' . $champion->getNameId() . '" class="img imgChampAlea"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/champion/' . $champion->getImage() . '" title="' . $champion->getName() . '"
                alt="' . $champion->getName() . '">
            </div>
            <div class="col-sm-7">
                <h1>'. $champion->getName() .'</h1>
                <span class="infosLane">Top Lane - Tank</span>
            </div>
        </div>';


/* ____________________________________ SKILLS A MAX ALEATOIRE _______________________________*/
// tableau pour l'assignement des sorts à maxer
$arrayChiffre = array(1, 2, 3);
shuffle($arrayChiffre);

$i = 0;

echo ' <div class="row sectionInfos">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                <h3>Skills</h3>
                <div class="row">';
foreach($champion->getSpells() as $sort)
{
    echo '<div class="col-sm-3">
            <img id="' . $sort->getName() . '" class="sumSpell "
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sort->getImage() . '" title="' . $sort->getName() . '"
                alt="' . $sort->getName() . '">';
    echo $i < 3 ? ' ' . $arrayChiffre[$i] : '';
    echo '</div>';
    ++$i;
}

echo '        </div>
           </div>
        </div>';


/* ____________________________________ SUMMONERS SPELL ALEATOIRE _______________________________*/

echo '<div class="row sectionInfos">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                <h3>Summoners</h3>
                <div class="row">';

echo '<div class="col-sm-6">
                <img id="' . $sumSpell1->getId() . '" class="sumSpell "
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell1->getImage() . '" title="' . $sumSpell1->getName() . '"
                alt="' . $sumSpell1->getName() . '"></div>';


echo '<div class="col-sm-6">
                <img id="' . $sumSpell2->getId() . '" class="sumSpell "
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell2->getImage() . '" title="' . $sumSpell2->getName() . '"
                alt="' . $sumSpell2->getName() . '"></div>';


echo '          </div>
            </div>
        </div>';


/* ____________________________________ ITEMS ALEATOIRE _______________________________*/


echo '<div class="row sectionInfos">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                <h3>Items</h3>
                <div class="row">';
$cpt = 0;
foreach($items as $item)
{
    if($cpt == 3) {
        echo '</div></br><div class="row">';
        $cpt = 0;
    }
    echo '<div class="col-sm-4">
                <img id="' . $item->getName() . '" class="imgItem "
                    src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/item/' . $item->getImage() . '" title="' . $item->getName() . '"
                    alt="' . $item->getName() . '">
          </div>';
    $cpt++;
}

echo '          </div>
            </div>
        </div>';

echo '</div>';
/*______ EFFET OMBRE  ____*/

echo '<div class="madiv col-md-8">
        <div class="topDiv"></div>
        <div class="leftDiv"></div>
        <div class="rightDiv"></div>
        <div class="bottomDiv"></div>
      </div>
    </div>';

displayFinAlea();