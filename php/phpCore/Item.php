<?php

class Item
{
    private $id;
    private $name;
    private $plaintext;
    private $image;
    private $gold;
    private $maps;
    private $tags;

    /**
     * PersonnageM constructor
     * @param $id
     * @param $name
     * @param $plaintext
     * @param $image
     * @param $gold
     */
    public function __construct($id, $name, $plaintext, $image, $gold, $maps, $tags)
    {
        $this->id = $id;
        $this->name = $name;
        $this->plaintext = $plaintext;
        $this->image = $image;
        $this->gold = $gold;
        $this->maps = $maps;
        $this->tags = $tags;
    }

    public function __destruct()
    {}

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPlaintext()
    {
        return $this->plaintext;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getGold()
    {
        return $this->gold;
    }

    public function getMaps()
    {
        return $this->maps;
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $other
     * @return int
     */
    public static function compare($o1, $other)
    {
        if(!($other instanceof Item && $o1 instanceof Item)) { /* TODO EXCEPTION */ }

        $diff = strcmp($o1->getName(), $other->getName());

        if($diff > 0)
            return 1;
        else if($diff < 0)
            return -1;
        else
            return 0;
    }

    function __toString()
    {
        return "id : " . $this->id . "  name : " . $this->name;
    }
}