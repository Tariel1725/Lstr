<?php

require_once ('../../validator.php');
require_once ('../../model/model.php');
setlocale(LC_ALL, "ru_RU.UTF-8");

class classController
{
    public $classID;
    public $className;
    public $parentClass;
    public $classDescription;
    public $skillID;
    public $class;
    public $classLVL = false;

    public function __construct() {
        $this->classID = false;
        $this->className = false;
        $this->parentClass = false;
        $this->classDescription = false;
        $this->result = false;
        $this->skillID = false;
    }

    public function createClass() {
        $validator = new validator($this->className);
        if (!$validator->error) {
            if (!$validator->symbols && !$validator->number) {
                $classModel = new characterClass();
                $classModel->className = $this->className;
                $classModel->parentClass = $this->parentClass;
                $classModel->description = $this->classDescription;
                $this->classID = $classModel->addClass();
            }
            else {
                $this->class->result = false;
                $this->class->statusCode = STATUS_ERROR_NAME;
                $this->class->error = 'Нельзя использовать цифры и спецсимволы';
            }
        }
        else {
            $this->class->result = false;
            $this->class->statusCode = FATAL_ERROR;
            $this->class->error = $validator->error;
        }
    }

    public function selectClass() {
        if (!$this->classID) {
            $classModel = new characterClass();
            $classModel->selectClass($this->classID);
            $this->class->data = ['name' =>$classModel->className, 'parentClass'=> $classModel->parentClass, 'skills' => $classModel->classesSkills];
            $this->class->result = true;
            $this->class->statusCode = STATUS_NO_ERROR;
            $this->class->error = 'Выполненно успешно';
        }
        else {
            $this->class->result = false;
            $this->class->statusCode = STATUS_ERROR_CLASS_ID;
            $this->class->error = 'Необходимо ввести ID класса';
        }
        return $this->class;
    }

    public function deleteClass() {
        if (!$this->classID) {
            $classModel = new characterClass();
            $classModel->deleteClass($this->classID);
            $this->class->result = true;
            $this->class->statusCode = STATUS_NO_ERROR;
            $this->class->error = 'Выполнено успешно';
        }
        else {
            $this->class->result = false;
            $this->class->statusCode = STATUS_ERROR_CLASS_ID;
            $this->class->error = 'Необходимо ввести ID класса';
        }
    }

    //В зависимости от присланного операнда $operand (add/remove) привязывает/отвязывает скилл и класс
    public function SkillToClass($operand) {
        if (!$this->classID && !$this->skillID) {
            $classModel = new characterClass();
            switch ($operand) {
                case 'add':
                    if (!$this->classLVL && $this->classLVL>0) {
                        $classModel->ID = $this->classID;
                        $classModel->classLVL = $this->classLVL;
                        $classModel->addSkillToClass($this->skillID);
                    }
                    else {
                        $this->class->result = false;
                        $this->class->statusCode = STATUS_ERROR_CLASS_LVL;
                        $this->class->error = 'Неправильно указан необходимый уровень персонажа';
                    }
                case 'remove':
                    $classModel->ID = $this->classID;
                    $classModel->removeSkillFromClass($this->skillID);
                    break;
                default:
                    $this->class->result = false;
                    $this->class->statusCode = STATUS_ERROR_SWITCH;
                    $this->class->error = 'Неправильно указан операнд';
            }
        }
        else {
            $this->class->result = false;
            $this->class->statusCode = STATUS_ERROR_CLASS_ID;
            $this->class->error = 'Необходимо ввести ID класса и ID скилла';
        }
    }
}