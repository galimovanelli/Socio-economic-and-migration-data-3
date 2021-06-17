<?php
$district = isset($_GET['district']) ? $_GET['district'] : 10;
$table = isset($_GET['table']) ? $_GET['table'] : 'v_demograph_inf';
$param = isset($_GET['param']) ? $_GET['param'] : 'population';

$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");

if ($connection == false) {
    echo 'Не удалось подключиться к БД';
    exit;
}
$sql = "SELECT $param, year FROM $table WHERE id_municip = $district";
$result = pg_query($connection, $sql);
$graph_data = pg_fetch_all($result, PGSQL_ASSOC);
$graph_json = json_encode($graph_data, JSON_UNESCAPED_UNICODE);
print($graph_json);
?>