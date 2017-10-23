<?php

class SummonerSpell
{
    private $id;
    private $image;
    private $modes;     // List[String]


    /**
     * SummonerSpell constructor
     * @param $id
     * @param $modes
     * @param $image
     */
    public function __construct($id, $modes, $image)
    {
        $this->id = $id;
        $this->image = $image;
        $this->modes = $modes;
    }

    public function __destruct()
    {}

    public function getId()
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getModes()
    {
        return $this->modes;
    }

    public function getName()
    {
        return str_replace(".png", "", $this->image);
    }

    function __toString()
    {
        return "id : " . $this->id . "  image : " . $this->image;
    }
}