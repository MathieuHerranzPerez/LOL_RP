<?php


class ItemM
{
    /**
     * @return Items[] tableau avec les items, indéxé de 0 à nbItems
     */
    public static function getItems($mode)
    {
        //$result = file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/items?api_key=' . $apiKey . '&tags=all'); //TODO changer
        $result = file_get_contents('../../js/testJSONItems.json');
        $listeItems = json_decode($result);

        $i = 0;
        $resultat[0] = null;

        require_once "../phpCore/Item.php";
        if($mode == "CLASSIC")
        {
            $map = 11; // id correspondants aux maps
        }
        else // aram
        {
            $map = 12;
        }

        foreach((array) $listeItems->data as $item)
        {
            //TODO enlever les "quick charge" des objets
            if(($item->maps->$map == true) &&
            ! array_key_exists("requiredChampion", $item) &&
            $item->gold->purchasable == true &&
            // pour ne pas se farcire les enchantements des boosts
            ($item->depth == 3 || ($item->depth == 2 && in_array("Boots", $item->tags))) &&// pour les chaussures
                array_key_exists("plaintext", $item)) // pour retirer les enchantements avec image de boots
            {
                $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps);
                ++$i;
            }
        }

        return $resultat;
    }
}