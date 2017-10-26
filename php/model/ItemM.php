<?php


class ItemM
{
    /**
     * @return Items[] tableau avec les items, indéxé de 0 à nbItems
     */
    public static function getItems()
    {
        //$result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/items?api_key=' . $apiKey . '&tags=image&dataById=true&tags=gold&tags=maps&tags=requiredChampion&dataById=true&tags=depth&tags=tags'); //TODO changer
        $result = file_get_contents('../../js/testJSONItems.json');
        $listeItems = json_decode($result);

        $i = 0;
        $resultat[0] = null;

        require_once "../phpCore/Item.php";
        $summonerRift = 11; // id correspondants aux maps
        $howlingAbyss = 12;

        foreach( (array) $listeItems->data as $item)
        {
            //TODO faire le lien automatiquement entre le nom de la map et ca place dans le tableau "maps" via le json des maps
            if(($item->maps->$summonerRift == true || $item->maps->$howlingAbyss == true) &&
            ! array_key_exists("requiredChampion", $item) &&
            $item->gold->purchasable == true && $item->depth == 3) {
                $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps);
                ++$i;
            }
        }

        return $resultat;
    }
}