<?php

class validator
{
    public $object;

    //нижеприведённые: true/false в зависимости от наличия/отсутствия
    public $cirillic; //кириллица
    public $latinic;  //латиница
    public $number;   //цифры
    public $symbols;  //спецсимволы
    public $lenght;   //длина строки
    public $error;

    public function __construct($object) {
        $this->object = $object;
        $this->checkObject();
    }

    public function checkObject() {
        try {
            $this->latinic = preg_match("#^[^A-z]+$#", $this->object);
            $this->cirillic = preg_match("#^[^А-я]+$#", $this->object);
            $this->number = preg_match("#^[^0-9]+$#", $this->object);
            $this->symbols = !preg_match("#^[^A-zА-я0-9 ]+$#", $this->object);
            $this->lenght = mb_strlen($this->object, 'utf-8');
            $this->error = false;
        }
        catch (Exception $ex){
            $this->error = $ex;
        }
    }

}