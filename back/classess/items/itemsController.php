<?php

require_once ('../../validator.php');

class itemsController
{
    private $itemId;
    private $itemName = false;
    private $itemPrice = false;    //цена предмета
    private $itemType = false;     //класс: оружие, книга, доспех, расходник и тд.
    private $itemClass = false;    //качество предмета: обычный, редкий, эпический и тд.
    private $itemMaterial = false; //материал предмета

    public function createItem() {
        if ($this->itemName) {
            itemsModel::addItemToDB($this->itemName, $this->itemPrice, $this->itemType);
            return itemsModel::$result;
        }
        else {

        }
    }

    public function updateItem() {

    }

    public function selectItem() {

    }

    public function deleteItem() {

    }
}