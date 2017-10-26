<?php

require_once "Collection.php";
require_once "../model/SummonerSpellM.php";

class CollectionSummonerSpells extends Collection
{
    /**
     * Personnages constructor
     */
    public function __construct($mode)
    {
        $this->tab = SummonerSpellM::getSorts($mode);
    }

    /**
     * @param $nb int le nombre de SummonerSpell souhaité
     * @return SummonerSpell[]
     */
    public function getAleatoire($nb)
    {
        return array_rand($this->tab, $nb);
    }

    public function supprimer($id)
    {
        $indice = -1;
        $i = 0;
        foreach($this->tab as $summonerSpell)
        {
            if($summonerSpell->getId() == $id)
            {
                $indice = $i;
            }
            ++$i;
        }

        unset($this->tab[$indice]);
        $this->tab = array_values($this->tab);  // pour ne pas sauter d'indice
    }
}