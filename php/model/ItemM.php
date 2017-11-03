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
            if(($item->maps->$map == true) &&
            ! array_key_exists("requiredChampion", $item) &&
            $item->gold->purchasable == true &&
            // pour ne pas se farcire les enchantements des boosts
                // les chaussures et les items de rang 4
            ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                strpos($item->name, "(Quick Charge)") === false)    // pour retirer les Quick Charge
            {
                $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags);
                ++$i;
            }
        }

        return $resultat;
    }

    public static function getViktorItem()
    {
        $result = file_get_contents('../../js/testJSONViktorItem.json');
        $listeItems = json_decode($result);
        $resultat = new Item(str_replace(".png", "", $listeItems->image->full), $listeItems->name, $listeItems->plaintext, $listeItems->image->full, $listeItems->gold->total, $listeItems->maps, $listeItems->tags);

        return $resultat;
    }

    /**
     * @param $id int l'id de l'item souhaité
     * @return Item l'item correspondant à l'ID
     */
    public static function getItemById($id)
    {
        $result = file_get_contents('../../js/testJSONItems.json');
        $listeItems = json_decode($result);

        $resultat = null;
        foreach((array) $listeItems->data as $item)
        {
            if($item->id == $id)
            {
                $resultat = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags);
            }
        }

        return $resultat;
    }
}