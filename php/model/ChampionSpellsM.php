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
}