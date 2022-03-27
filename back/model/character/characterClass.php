<?php

class characterClass extends model
{
    private $classTable = 'classes';
    private $classesSkills = '';
    public $className;


    public function addClass(){
        $sql = 'INSERT INTO '.$this->classTable.' () VALUES ('.')';
    }
}