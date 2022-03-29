<?php

class characterClass extends model
{
    private $classTable = 'classes';
    private $classesSkills = 'classesskills';

    public $ID;
    public $classLVL;
    public $className;
    public $parentClass;

    public function addClass(){
        if(is_array($this->parentClass)){
            $sql = 'INSERT INTO '.$this->classTable.' (`name`, `parrentClass`) VALUES ('.$this->className.', `'.json_decode($this->parentClass).'`)';
        }
        else{
            $sql = 'INSERT INTO '.$this->classTable.' (`name`) VALUES ('.$this->className.')';

        }
        $this->DB->query($sql);
        return $this->DB->lastInsertId();
    }

    public function addSkillToClass($skillID){
        $sql = 'INSERT INTO '.$this->classesSkills.' (`skillID`, `classID`, `classLVL`) VALUES ('.$skillID.', '.$this->ID.', '.$this->classLVL.')';
        $this->DB->query($sql);
        return $this->DB->lastInsertId();
    }

    public function removeSkillFromClass($skillID){
        $sql = 'DELETE FROM '.$this->classesSkills.' WHERE `skillID` = '.$skillID.')';
        $this->DB->query($sql);
    }
}