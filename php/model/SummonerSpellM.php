<?php

class SummonerSpellM
{
    /**
     * @return SummonerSpell[] tableau avec les sorts, indéxé de 0 à nbSort
     */
    public static function getSorts($mode)
    {
        //$result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/summoner-spells?api_key=' . RiotApi::getApiKey() . '&tags=modes&tags=image');
        $result = file_get_contents('../../js/testJSONSummoner.json');
        $listeSorts = json_decode($result);

        $i = 0;
        $resultat[0] = null;

        require_once "../phpCore/SummonerSpell.php";

        foreach($listeSorts->data as $sort)
        {
            if(in_array($mode, $sort->modes))
            {
                $resultat[$i] = new SummonerSpell($sort->id, $sort->modes, $sort->image->full);
                ++$i;
            }
        }

        return $resultat;
    }
}