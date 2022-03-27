<?php

require_once ('constants.php');
require_once ('../../validator.php');
require_once ('../../model/model.php');


class characterController
{
    private $characterID = false;
    private $characterName = false;
    private $characterLVL = 1;
    private $characterClass = false;
    private $characterStatus;//Состояние здоровья, маны, перки, текущее кол-во опыта.
    public $character;

    public function createCharacter(){
        if ($this->characterName && $this->characterClass) {
            setlocale(LC_ALL, "ru_RU.UTF-8");
            $validator = new validator($this->characterName);
            if (!$validator->error) {
                if (!$validator->symbols && !$validator->number) {
                    if (intval($this->characterLVL)>0) {
                        $character = new characterModel();
                        $character->Name = $this->characterName;
                        $this->characterID = $character->createCharacter($this->characterClass);
                    }
                    else {
                        $this->character->result = false;
                        $this->character->statusCode = STATUS_ERROR_LVL;
                        $this->character->error = 'Уровень персонажа не может быть ниже 1';
                    }
                }
                else {
                    $this->character->result = false;
                    $this->character->statusCode = STATUS_ERROR_NAME;
                    $this->character->error = 'Нельзя использовать цифры и спецсимволы в имени персонажа';
                }
            }
            else {
                $this->character->result = false;
                $this->character->statusCode = FATAL_ERROR;
                $this->character->error = $validator->error;
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
            $character = new characterModel();
            $character->ID = $this->characterID;
            $character->deleteCharacter();
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_ID;
            $this->character->error = 'Необходимо ввести ID персонажа';
        }
    }
}