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
            $resultat[$i] = new Personnage($champ->id, $champ->name, $champ->key, $champ->title, $champ->image->full, null, $champ->tags);
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
                $resultat = new Personnage($champ->id, $champ->name, $champ->key,  $champ->title, $champ->image->full, $spell, $champ->tags);
            }
        }

        return $resultat;
    }

    /**
     * @param $champion
     * @param $type string type d'objets cherchés (essential ...)
     * @param $mode string mode de jeu (CLASSIC / ARAM ...)
     * @return array int representant les id des items $type pour le $champion
     */
    public static function getChampStuff($champion, $type, $mode)
    {
        $result = file_get_contents('../../js/testJSON.json');
        $listeChampions = json_decode($result);

        $nomChamp = $champion->getNameId();
        $boolKayn = false;
        if($nomChamp == "Kayn")
        {
            $boolKayn = true;
        }

        $tabId = array();
        $cpt = 0;
        foreach($listeChampions->data->$nomChamp->recommended as $recommended)
        {
            //cpt : pour ne pas avoir les items supp / jungle  //pour ne pas avoir la map 3v3
            if($cpt < 1 && ($recommended->mode == $mode && ($recommended->map == "SR" || $recommended->map == "HA")))
            {
                ++$cpt;
                foreach($recommended->blocks as $block)
                {
                    if(!$boolKayn)
                    {
                        if ($block->type == $type)
                        {
                            foreach ($block->items as $item)
                            {
                                array_push($tabId, $item->id);
                            }
                        }
                    }
                    else // cas special pour Kayn qui n'a pas les mêmes type que les autres --'
                    {
                        if ($block->type == $type || $block->type == "basekaynstandard")
                        {
                            foreach ($block->items as $item)
                            {
                                array_push($tabId, $item->id);
                            }
                        }
                    }
                }
            }
        }
//                    // TODO test a enlever
//        foreach ($tabId as $item)
//        {
//            echo $item . ' - ';
//        }

        return $tabId;
    }
}