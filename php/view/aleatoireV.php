<?php

displayEntete("http://ddragon.leagueoflegends.com/cdn/img/champion/splash/" . str_replace('.png', '_0.jpg', $champion->getImage()));
    echo '<div class="col-md-6">';
    echo '<img id="' . $champion->getNameId() . '" class="img img-responsive imgChampMedium"
                src="http://ddragon.leagueoflegends.com/cdn/img/champion/loading/' . str_replace('.png', '_0.jpg', $champion->getImage()) . '" title="' . $champion->getName() . '"
                alt="' . $champion->getName() . '">';
    echo '<br/>';
    echo '</div>';
    echo '<div class="col-md-6">';

    // tableau pour l'assignement des sorts à maxer
    $arrayChiffre = array(1, 2, 3);
    shuffle($arrayChiffre);

    $i = 0;
    foreach($champion->getSpells() as $sort)
    {
        echo '<img id="' . $sort->getName() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sort->getImage() . '" title="' . $sort->getName() . '"
                alt="' . $sort->getName() . '">';
        echo $i < 3 ? ' ' . $arrayChiffre[$i] : '';
        echo '<br/>';
        ++$i;
    }

    echo '<br/><br/><img id="' . $sumSpell1->getId() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell1->getImage() . '" title="' . $sumSpell1->getName() . '"
                alt="' . $sumSpell1->getName() . '"><br/>';

    echo '<img id="' . $sumSpell2->getId() . '" class="sumSpell"
                src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/spell/' . $sumSpell2->getImage() . '" title="' . $sumSpell2->getName() . '"
                alt="' . $sumSpell2->getName() . '">';
    echo '</div>';

    echo '<br/><br/>';

    foreach($items as $item)
    {
        echo '<img id="' . $item->getName() . '" class="imgItem"
                    src="http://ddragon.leagueoflegends.com/cdn/7.20.2/img/item/' . $item->getImage() . '" title="' . $item->getName() . '"
                    alt="' . $item->getName() . '">';
    }

displayFin();