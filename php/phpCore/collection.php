<?php

abstract class Collection
{
    protected $tab = array();

    public function getTab()
    {
        return $this->tab;
    }

    public function __toString()
    {
        $str = '';
        for($i = 0; $i < sizeof($this->tab); ++$i)
        {
            $str .= $this->tab[$i];
        }
        return $str;
    }

    //public abstract function getAleatoire($nb);
}