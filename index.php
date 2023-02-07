<?php
class Tree {
    private $id;
    public $type  = 'tree';
    public $numberOfFruits;
    public function __construct() {
        $this->getID();
        $this->getNumberOfFruits();
    }
    private function getID() {
        $this->id = uniqid();
    }
    protected function getNumberOfFruits() {
        $this->numberOfFruits = rand(0, 0);
    }

}
class Apple extends Tree {
    public $type = 'apple';
    protected function getNumberOfFruits() {
        $this->numberOfFruits = rand(40, 50);
    }
}
class Pear extends Tree {
    public $type = 'pear';
    protected function getNumberOfFruits() {
        $this->numberOfFruits = rand(0, 20);
    }
}
class FruitPicker{
    public $basket = array("apple"=>0, "pear"=>0);
    public $weight = array("apple"=>0, "pear"=>0);
    public function pickFruit($fruit){
        foreach ($fruit as $key) {
            if ($key->numberOfFruits > 0) {
                $this->basket[$key->type] += $key->numberOfFruits;
                $key->numberOfFruits = 0;
            }
        }
        $this->basketWeight();
        $this->getBasket($this->basket, $this->weight);

    }
    private function basketWeight(){
        foreach ($this->basket as $key => $value) {
            if ($key == "apple")
                for ($i = 0; $i < $value; $i++)
                    $this->weight[$key] += rand(150, 180);
            else
                for ($i = 0; $i < $value; $i++)
                    $this->weight[$key] += rand(130, 170);
        }
        return $this->weight;
    }
    private function getBasket($basket, $weight){
        foreach ($basket as $key => $value) {
            echo 'собрано ' . $key . ' : ' . $value . ' шт' . PHP_EOL;
        }
        foreach ($weight as $key => $value) {
            echo 'общий вес ' . $key . ' : ' . $value/1000 . ' кг' . PHP_EOL;
        }
    }
}

// количество яблонь
$numberOfAppleTrees = 10;
// количество груш
$numberOfPearTrees = 15;
// инициализация массива деревьев
$orchard = array();

// заполнение массива деревьев
for ($i = 0; $i < $numberOfAppleTrees; $i++) {
    $orchard[] = new Apple();
}
for ($i = 0; $i < $numberOfPearTrees; $i++) {
    $orchard[] = new Pear();
}

// инициализация сборщика фруктов
$fruitPicker = new FruitPicker();
// запуск сборщика фруктов
$fruitPicker->pickFruit($orchard);

// тестирование
function unitTest($numberOfAppleTrees, $numberOfPearTrees, $basket, $weight) {
    $errors = array();
    if ($numberOfAppleTrees <= 0 or $numberOfPearTrees <= 0)
        $errors[] = '❌  Количетсво деревьев должно быть положительным!' . PHP_EOL;
    if ($basket['apple'] < $numberOfAppleTrees * 40 or $basket['apple'] > $numberOfAppleTrees * 50)
        $errors[] = '❌  Неверное количество яблок!' . PHP_EOL;
    if ($basket['pear'] < $numberOfPearTrees * 0 or $basket['pear'] > $numberOfPearTrees * 20)
        $errors[] = '❌  Неверное количество груш!' . PHP_EOL;
    if ($weight['apple'] < $numberOfAppleTrees * $basket['apple'] * 15 or $weight['apple'] > $numberOfAppleTrees * $basket['apple'] * 18)
        $errors[] = '❌  Неверный вес яблок!' . PHP_EOL;
    if ($weight['pear'] < $numberOfAppleTrees * $basket['pear'] * 13 or $weight['pear'] > $numberOfAppleTrees * $basket['pear'] * 17)
        $errors[] = '❌  Неверный вес груш!' . PHP_EOL;
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        echo '✅  Ошибок не обнаруженно!' . PHP_EOL;
    }
}

unitTest($numberOfAppleTrees, $numberOfPearTrees, $fruitPicker->basket, $fruitPicker->weight);
