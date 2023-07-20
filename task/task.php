<?php

$array = [
    ['id' => 1, 'date' => "12.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "02.05.2020", 'name' => "test2"],
    ['id' => 4, 'date' => "08.03.2020", 'name' => "test4"],
    ['id' => 1, 'date' => "22.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "11.11.2020", 'name' => "test4"],
    ['id' => 3, 'date' => "06.06.2020", 'name' => "test3"],
];

function unique($array) {
    $unique = array_reduce(array_reverse($array), function ($unique, $item) {
        $unique[$item['id']] = $item;
        return $unique;
    });
    $array = array_values($unique);
    return $array;
}

function arraySort($array) {
    usort($array, function($a,$b){
        return ($a['id']-$b['id']);
    });
    return $array;
}
function mySqlConnect() {
    $mysqli = mysqli_connect('localhost', 'root', 'root', 'testTask',3307);
    if (!$mysqli) {
        die('Ошибка соединения!');
    }
    echo 'Успешное соединение с mysql';
    return $mysqli;
}
//============================ task1 ===========================
function task1($array)
{
    $arrayUnique = 'unique';
    var_dump('task1', $arrayUnique($array));
}
//============================ task 2 ===========================
function task2($array)
{
    $arrayUnique = 'unique';
    $arraySort = 'arraySort';
    var_dump('task2', $arraySort($arrayUnique($array)));
}
//============================ task 3 ===========================
function task3($array) //Не факт что понял провильно, использую оператор ввода для условия
{
    $arrayUnique = 'unique';
    $arraySort = 'arraySort';
    $stdin = fopen('php://stdin', 'r');
    $read = trim(fgets(STDIN));
    $arrayNew = [];
    $array = $arraySort($arrayUnique($array));
    //нарушил правило, но подумал что так верней будет, потому-что если делать через array_reduce, то не получится передать введёное значение
    foreach ($array as $item) {
        if(in_array($read, $item)){
            $arrayNew[] = $item;
        }
    }
    var_dump('task3', $arrayNew);
}
//============================ task 4 ===========================
function task4($array)
{
    $arrayUnique = 'unique';
    $arraySort = 'arraySort';
    $newArray = array_reduce($arraySort($arrayUnique($array)), function ($newArray, $item) {
        $newArray[] = array_combine([$item['name']], [$item['id']]);
        return $newArray;
    });
    $array = array_values($newArray);
    var_dump('task4', $array);
}
//============================ task 5 ===========================
function task5()
{
    $mysqli = 'mySqlConnect';
    $result = $mysqli()->query("SELECT goods_id, 
       (SELECT name FROM goods WHERE id = goods_id) as 'name' 
        FROM goods_tags gt WHERE (SELECT COUNT(id) FROM tags) = (SELECT COUNT(tag_id) 
        FROM goods_tags WHERE goods_id = gt.goods_id) GROUP BY goods_id;");
    var_dump('task5', $result->fetch_all());
    mysqli_close($mysqli());
}
//============================ task 5 ===========================
function task6()
{
    $mysqli = 'mySqlConnect';
    $result = $mysqli()->query("SELECT department_id, (SELECT name FROM department WHERE id = department_id ) as 'name' FROM evaluations WHERE gender = true and value > 5 GROUP BY department_id;");
    var_dump('task6', $result->fetch_all());
    mysqli_close($mysqli());
}
//Сделал как консольное приложение, чтобы каждую задачу можно было посмотреть раздельно
echo ('Выберите номер задачи (1-6): ');
$stdin = fopen('php://stdin', 'r');
$read = trim(fgets(STDIN));
switch ($read) {
    case 1:
        $task = 'task1';
        $task($array);
        break;
    case 2:
        $task = 'task2';
        $task($array);
        break;
    case 3:
        $task = 'task3';
        $task($array);
        break;
    case 4:
        $task = 'task4';
        $task($array);
        break;
    case 5:
        $task = 'task5';
        $task();
        break;
    case 6:
        $task = 'task6';
        $task();
        break;
    default: echo 'Такой задачи не существует';
}