<?php

displayEntete("http://ddragon.leagueoflegends.com/cdn/img/champion/splash/" . str_replace('.png', '_0.jpg', $champion->getImage()));
    echo '<div class="col-md-6">';
    echo '<img id="' . $champion->getNameId() . '" class="img img-responsive imgChampMedium"
                src="http://ddragon.leagueoflegends.com/cdn/img/champion/loading/' . str_replace('.png', '_0.jpg', $champion->getImage()) . '" title="' . $champion->getName() . '"
                alt="' . $champion->getName() . '">';
    echo '<br/>';
    echo '</div>';
    echo '<div class="col-md-6">';
    foreach($champion->getSpells() as $sort)
    {
        echo '<img id="' . $sort->getName() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sort->getImage() . '" title="' . $sort->getName() . '"
                alt="' . $sort->getName() . '"><br/>';
    }

    echo '<br/><br/><img id="' . $sumSpell1->getId() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell1->getImage() . '" title="' . $sumSpell1->getId() . '"
                alt="' . $sumSpell1->getId() . '"><br/>';

    echo '<img id="' . $sumSpell2->getId() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell2->getImage() . '" title="' . $sumSpell2->getId() . '"
                alt="' . $sumSpell2->getId() . '">';
    echo '</div>';

displayFin();