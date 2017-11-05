<?php


class ItemM
{
    /**
     * @return Items[] tableau avec les items, indéxé de 0 à nbItems
     */
    public static function getItems($mode, $filtre)
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
        //TODO les items de Ornn cassent tout ! les items conseillés n'ont pas le buff Ornn, il faut ici recuperer uniquement les rangs 3 (colloq "Ornn" "ornn" ?)
        if($filtre == null || $filtre == "Medium" || $filtre == "Correct")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false
                )    // pour retirer les Quick Charge
                {
                    $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                    ++$i;
                }
            }
        }
        else if($filtre == "AD")    // TODO ça fonctionn, mais les items jungle AP passent ...
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((!in_array("SpellDamage", (array)$item->tags) && !in_array("MagicPenetration", (array)$item->tags))
                        || (in_array("Damage", (array)$item->tags) && in_array("SpellDamage", (array)$item->tags)))
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "AP")    // TODO ça fonctionn, mais les items jungle AD passent ...
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((!in_array("Damage", (array)$item->tags) && !in_array("CriticalStrike", (array)$item->tags))
                        || (in_array("Damage", (array)$item->tags) && in_array("SpellDamage", (array)$item->tags)))
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "Tank")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((in_array("Health", (array)$item->tags) || in_array("HealthRegen", (array)$item->tags)
                        || in_array("Armor", (array)$item->tags) || in_array("SpellBlock", (array)$item->tags))
                        || !array_key_exists("tags", $item)) // pour les items jungle
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "FullAD")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((in_array("Damage", (array)$item->tags) || in_array("CriticalStrike", (array)$item->tags)
                        || in_array("AttackSpeed", (array)$item->tags) || in_array("OnHit", (array)$item->tags)
                        || in_array("ArmorPenetration", (array)$item->tags))
                        || !array_key_exists("tags", $item)) // pour les items jungle
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "FullAP")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((in_array("SpellDamage", (array)$item->tags) || in_array("MagicPenetration", (array)$item->tags))
                        || !array_key_exists("tags", $item))    // pour les items jungle
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "FullTank")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if(((in_array("Health", (array)$item->tags) || in_array("HealthRegen", (array)$item->tags)
                        || in_array("Armor", (array)$item->tags) || in_array("SpellBlock", (array)$item->tags))
                        && (!in_array("SpellDamage", (array)$item->tags) && !in_array("MagicPenetration", (array)$item->tags)
                        && !in_array("Damage", (array)$item->tags) && !in_array("CriticalStrike", (array)$item->tags)))
                        || !array_key_exists("tags", $item))    // pour les items jungle
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }
        else if($filtre == "Active")
        {
            foreach ((array)$listeItems->data as $item) {
                if (($item->maps->$map == true) &&
                    !array_key_exists("requiredChampion", $item) &&
                    $item->gold->purchasable == true &&
                    // pour ne pas se farcire les enchantements des boosts
                    // les chaussures et les items de rang 4
                    ((($item->depth == 3 && !array_key_exists("into", $item) || $item->depth == 4)) || ($item->depth == 2 && in_array("Boots", $item->tags))) &&
                    array_key_exists("plaintext", $item) && // pour retirer les enchantements avec image de boots
                    strpos($item->name, "(Quick Charge)") === false  // pour retirer les Quick Charge
                )
                {
                    if((in_array("Active", (array)$item->tags) || in_array("Boots", (array)$item->tags))
                        || !array_key_exists("tags", $item))    // pour les items jungle
                    {
                        $resultat[$i] = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
                        ++$i;
                    }

                }
            }
        }

        return $resultat;
    }

    public static function getViktorItem()
    {
        $result = file_get_contents('../../js/testJSONViktorItem.json');
        $listeItems = json_decode($result);
        $resultat = new Item(str_replace(".png", "", $listeItems->image->full), $listeItems->name, $listeItems->plaintext, $listeItems->image->full, $listeItems->gold->total, $listeItems->maps, $listeItems->tags, $listeItems->colloq, $listeItems->from);

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
                $resultat = new Item($item->id, $item->name, $item->plaintext, $item->image->full, $item->gold->total, $item->maps, $item->tags, $item->colloq, $item->from);
            }
        }

        return $resultat;
    }
}