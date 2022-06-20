<?php

include_once('curl.php');

class Content extends Curl
{
    private $category;
    private $indexes;
    private $contentInfo;

    public function __construct($url, $jsonflag, $category)
    {
        parent::__construct($url, $jsonflag);
        $this->category = $category;
        $this->indexes = [];
        $this->contentInfo = [];
    }

    public function getContentInfo()
    {
        $categories = parent::getResult();

        $content = new Curl($categories->{$this->category}, true);

        $this->contentInfo = $content->getResult()->results;


        if ($this->category == "spells") {
            $this->indexes = [
                'name',
                'desc',
                'material',
                'range'
            ];
        } else if ($this->category == "weapons") {
            $this->indexes = [
                'name',
                'category',
                'cost',
                'damage_dice'
            ];
        } else if ($this->category == "monsters") {
            $this->indexes = [
                'name',
                'type',
                'size',
                'hit_points'
            ];
        } else if ($this->category == "races") {
            $this->indexes = [
                'name',
                'desc',
                'age',
                'size'
            ];
        }

        $this->setContentInfo($this->indexes);

        return $this->contentInfo;
    }

    /*public function getContentNames()
    {
        return $this->contentInfo;
    }*/

    public function getContentNames()
    {
        return $this->contentInfo;
    }

    public function getIndexNames()
    {
        return $this->indexes;
    }

    private function setContentInfo(array $indexes)
    {
        $return = [];

        foreach (array_slice($this->contentInfo, 0, 10) as $key => $value) {
            foreach ($indexes as $index) {
                $return[$key][$index] = $value->$index;
            }
        }

        $this->contentInfo = $return;
    }
}
