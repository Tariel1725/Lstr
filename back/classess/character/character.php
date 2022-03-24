<?php

require_once ('constants.php');

class characterController
{
    private $characterID = false;
    private $characterName = false;
    private $characterLVL = 1;
    private $characterClass = false;
    private $characterStatus;//Состояние здоровья, маны, перки, текущее кол-во опыта.
    public $character;

    public function createCharacter(){
        if ($this->characterName & $this->characterClass) {
            characterModel::addCharacterToDB($this->characterName, $this->characterLVL, $this->characterClass);
            return characterModel::$result;
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_DATA;
            $this->character->error = 'Отсутствуют необходимые данные';
        }
    }

    public function updateCharacter(){
        if ($this->characterID) {
            setlocale(LC_ALL, "ru_RU.UTF-8");
            if (!preg_match("#^[^A-zА-я ]+$#",$this->characterName)) {
                if (intval($this->characterLVL)>0) {
                    characterModel::updateCharacterFromDB($this->characterName, $this->characterLVL, $this->characterClass);
                    return characterModel::$result;
                }
                else {
                    $this->character->result = false;
                    $this->character->statusCode = STATUS_ERROR_LVL;
                    $this->character->error = 'Уровень персонажа не может быть ниже 1';
                }
            } else {
                $this->character->result = false;
                $this->character->statusCode = STATUS_ERROR_NAME;
                $this->character->error = 'Нельзя использовать цифры и спецсимволы в имени персонажа';
            }
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_DATA;
            $this->character->error = 'Отсутствуют необходимые данные';
        }
    }

    public function getCharacterInfo(){
        if ($this->characterID) {
            characterModel::selectCharacterFromDB();
            return characterModel::$result;
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_ID;
            $this->character->error = 'Необходимо ввести ID персонажа';
        }
    }

    public function deleteCharacter() {
        if ($this->characterID) {
            characterModel::deleteCharacterFromDB();
            return characterModel::$result;
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_ID;
            $this->character->error = 'Необходимо ввести ID персонажа';
        }
    }
}