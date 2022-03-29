<?php

require_once ('constants.php');
require_once ('../../validator.php');
require_once ('../../model/model.php');


class characterController
{
    private $characterID;
    private $characterName;
    private $characterLVL;
    private $characterClass;
    private $characterStatus;//Состояние здоровья, маны, перки, текущее кол-во опыта.
    public $character;

    public function __construct() {
        $this->characterLVL = 1;
        $this->characterID = false;
        $this->characterName = false;
        $this->characterClass = false;
    }

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
                    $this->character->error = 'Нельзя использовать цифры и спецсимволы';
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
            $character = new characterModel();
            $character->ID = $this->characterID;
            $this->character->data = $character->characterInfo();
            $this->character->result = true;
            $this->character->statusCode = STATUS_NO_ERROR;
            $this->character->error = 'Выполнено успешно';
        }
        else {
            $this->character->result = false;
            $this->character->statusCode = STATUS_ERROR_ID;
            $this->character->error = 'Необходимо ввести ID персонажа';
        }
        return $this->character;
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