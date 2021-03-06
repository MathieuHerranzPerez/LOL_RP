<?php

require "Comparable.php";

class Personnage implements Comparable
{
    private $id;
    private $name;
    private $nameId;
    private $title;
    private $image;
    private $spells;        // ChampionSpells
    private $tags;          // array


    /**
     * PersonnageM constructor
     * @param $id
     * @param $name
     * @param $title
     * @param $image
     * @param $spells ChampionSpells[]
     */
    public function __construct($id, $name, $nameId, $title, $image, $spells, $tags)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->image = $image;
        $this->nameId = $nameId;
        $this->spells = $spells;
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

    public function getNameId()
    {
        return $this->nameId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getSpells()
    {
        return $this->spells;
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
        if(!($other instanceof Personnage && $o1 instanceof Personnage)) { /* TODO EXCEPTION */ }

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