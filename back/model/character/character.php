<?php

class characterModel extends model
{
    private $characterTable = 'gamecharacter';
    private $classTable = 'classes';
    private $characterClassesTable = 'characterclasses';

    public $ID;
    public $Name;
    public $LVL = 1;
    public $STR = 10;
    public $AGI = 10;
    public $CON = 10;
    public $PER = 10;
    public $INT = 10;
    public $WIS = 10;
    public $LUC = 10;
    public $CHA = 10;

    public function createCharacter($addedClassID){
        $sql = 'INSERT INTO '.$this->characterTable.' 
        (`name`, `lvl`, `STR`, `AGI`, `CON`, `PER`, `INL`, `WIS`, `LUC`, `CHA`) 
        VALUES 
        (`'.$this->Name.'`, '.$this->LVL.', '.$this->STR.', '.$this->AGI.', '.$this->CON.', '.$this->PER.', '.$this->INT.', '.$this->WIS.', '.$this->LUC.', '.$this->CHA.')';
        $this->DB->query($sql);
        $characterID = $this->DB->lastInsertId();

        $sql = 'INSERT INTO '.$this->characterClassesTable.' (`characterID`, `classID`, `classLVL`) VALUES ('.$this->ID.', '.$addedClassID.', 1)';
        $this->DB->query($sql);
        return $characterID;
    }

    public function characterInfo(){
        $sql = 'SELECT * FROM '.$this->characterTable.' WHERE `id` = '.$this->ID;
        $stmt = $this->DB->query($sql);
        $character = $stmt->fetchAll();
        $this->LVL = $character[0]['lvl'];
        $this->STR = $character[0]['STR'];
        $this->AGI = $character[0]['AGI'];
        $this->CON = $character[0]['CON'];
        $this->PER = $character[0]['PER'];
        $this->INT = $character[0]['INL'];
        $this->WIS = $character[0]['WIS'];
        $this->LUC = $character[0]['LUC'];
        $this->CHA = $character[0]['CHA'];
    }

    public function LVLupCharacter($uppedStat, $addedClassID){
        $sql = 'SELECT * FROM '.$this->characterTable.' WHERE `id` = '.$this->ID;
        $stmt = $this->DB->query($sql);
        $character = $stmt->fetchAll();

        if($uppedStat=='INT'){
            $uppedStat = 'INL';
        }
        $sql = 'UPDATE '.$this->characterTable.' SET '.$uppedStat.' = '.($character[$uppedStat]+1).', lvl = '.($character['lvl']+1);
        $this->DB->query($sql);

        $characterClasses =  $this->getCharacterClasses();
        if(in_array($addedClassID, $characterClasses)){
            $key = array_search($addedClassID, $characterClasses);
            $sql = 'UPDATE '.$this->characterClassesTable.' SET classLVL = '.($characterClasses[$key]['lvl']+1).' WHERE id = '.$characterClasses[$key]['rowID'];
        }
        else{
            $sql = 'INSERT INTO '.$this->characterClassesTable.' (`characterID`, `classID`, `classLVL`) VALUES ('.$this->ID.', '.$addedClassID.', 1)';
        }
        $this->DB->query($sql);
    }

    public function getCharacterClasses(){
        $sql = 'SELECT c.`name` as `name`, c.`id` as `id`, cc.`classLVL` as `lvl`, cc.`id` as `rowID`
                FROM '.$this->characterClassesTable.' cc INNER JOIN '.$this->classTable.' c ON c.`id` = cc.classID 
                WHERE cc.characterID = '.$this->ID;
        $stmt = $this->DB->query($sql);
        return $stmt->fetchAll();
    }

    public function deleteCharacter(){
        $sql = 'DELETE FROM '.$this->characterTable.' WHERE `id` = '.$this->ID;
        $this->DB->query($sql);
        $sql = 'DELETE FROM '.$this->characterClassesTable.' WHERE `characterID` = '.$this->ID;
        $this->DB->query($sql);
    }
}