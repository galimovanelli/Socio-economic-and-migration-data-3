<?php
// создание переменной год 
$year = isset($_GET['year']) ? $_GET['year'] : '2013';
// $sql = "SELECT m.geom, m.name, m.id_municip, a.coef_value, a.year FROM municipality m INNER JOIN v_attract_coef a ON m.id_municip = a.id_municip WHERE year = " . $year;
$sql = "SELECT m.name, m.id_municip, a.coef_value, a.year FROM municipality m INNER JOIN v_attract_coef a ON m.id_municip = a.id_municip WHERE year = '$year'";


// подключение к БД
$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");

$result = pg_query($connection, $sql);
// создаем ассоциативный массив
$arr = pg_fetch_all($result, $result_type = PGSQL_ASSOC);

$json = json_encode($arr, JSON_UNESCAPED_UNICODE);
print($json);
