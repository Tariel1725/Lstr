<?php

class characterClass extends model
{
    private $classTable = 'classes';
    private $classesSkillsTable = 'classesskills';

    public $ID;
    public $classLVL;
    public $className;
    public $modifiers = ['HPmodifier'=>0,'MPmodifier'=>0,'StaminaModifier'=>0];
    public $parentClass;
    public $classesSkills;

    public function addClass(){
        if(is_array($this->parentClass)){
            $sql = 'INSERT INTO '.$this->classTable.' (`name`, `parrentClass`, `HPmodifier`, `MPmodifier`, `StaminaModifier`) VALUES ('.$this->className.', `'.json_encode($this->parentClass).'`, '.$this->modifiers['HPmodifier'].', '.$this->modifiers['MPmodifier'].', '.$this->modifiers['StaminaModifier'].',)';
        }
        else{
            $sql = 'INSERT INTO '.$this->classTable.' (`name`) VALUES ('.$this->className.')';

        }
        $this->DB->query($sql);
        return $this->DB->lastInsertId();
    }

    public function selectClass(){
        $sql = 'SELECT * FROM'.$this->classTable.' WHERE `id` = '.$this->ID;
        $stmt = $this->DB->query($sql);
        $class = $stmt->fetchAll();
        $this->className = $class[0]['name'];
        $this->parentClass = json_decode($class[0]['parrentClass']);
        $sql = 'SELECT * FROM '.$this->classesSkillsTable.' WHERE `classID` = '.$this->ID;
        $stmt = $this->DB->query($sql);
        $skills = $stmt->fetchAll();
        $this->classesSkills = $skills;
    }

    public function deleteClass(){
        $sql = 'DELETE FROM'.$this->classTable.' WHERE `id` = '.$this->ID;
        $this->DB->query($sql);
        $sql = 'DELETE FROM '.$this->classesSkillsTable.' WHERE `classID` = '.$this->ID;
        $this->DB->query($sql);
    }

    public function addSkillToClass($skillID){
        $sql = 'INSERT INTO '.$this->classesSkillsTable.' (`skillID`, `classID`, `classLVL`) VALUES ('.$skillID.', '.$this->ID.', '.$this->classLVL.')';
        $this->DB->query($sql);
        return $this->DB->lastInsertId();
    }

    public function removeSkillFromClass($skillID){
        $sql = 'DELETE FROM '.$this->classesSkillsTable.' WHERE `skillID` = '.$skillID.' AND classID = '.$this->ID;
        $this->DB->query($sql);
    }
}