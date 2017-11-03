<?php

class ChampionSpellsM
{
    public static function getChamps()
    {
        //$result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/champions/' . $id . '?api_key=' . RiotApi::getApiKey() . '&tags=spells');
        $result = file_get_contents('../../js/testJSONSpells.json');
        $infoChamp = json_decode($result);

        return $infoChamp;
    }

    /**
     * @param $id int id du perso duquel on desire les sorts
     * @return ChampionSpells[]
     */
    public static function getSpellByChampId($id)
    {
        $result = file_get_contents('../../js/testJSONSpells.json');
        $listeSortsParChamp = json_decode($result);

        require_once "../phpCore/ChampionSpells.php";

        $spells =array();
        foreach($listeSortsParChamp->data as $champ)
        {
            if($champ->id == $id)
            {
                foreach($champ->spells as $sp)
                {
                    array_push($spells, new SummonerSpell(null, $sp->name, $sp->image->full));
                }
            }
        }

        return $spells;
    }
}