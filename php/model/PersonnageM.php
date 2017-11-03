<?php

require_once "../phpCore/api/riotApi.php";

class PersonnageM
{
    /**
     * @return Personnage[] tableau avec les personnages, indéxé de 0 à nbPerso
     */
    public static function getChamps()
    {
        //$result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/champions?api_key=' . RiotApi::getApiKey() . '&tags=image&dataById=true'); //TODO changer
        $result = file_get_contents('../../js/testJSON.json');
        $listeChampions = json_decode($result);

        $i = 0;
        $resultat[0] = null;

        require_once "../phpCore/Personnage.php";

        foreach($listeChampions->data as $champ)
        {
            $resultat[$i] = new Personnage($champ->id, $champ->name, $champ->title, $champ->image->full, null, $champ->tags);
            ++$i;
        }

        return $resultat;
    }

    /**
     * @param $id int l'id du champion souhaité
     * @param ChampionSpells[] la liste des sorts du champion
     * @return Personnage
     */
    public static function getChampById($id, $spell)
    {
        $result = file_get_contents('../../js/testJSON.json');
        $listeChampions = json_decode($result);


        require_once "../phpCore/Personnage.php";

        $resultat = null;
        foreach($listeChampions->data as $champ)
        {
            if($champ->id == $id)
            {
                $resultat = new Personnage($champ->id, $champ->name, $champ->title, $champ->image->full, $spell, $champ->tags);
            }
        }

        return $resultat;
    }
}