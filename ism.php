<?php
$R1 = $_REQUEST[row1]; //переменная с номером id_demograph_inf
$R2 = $_REQUEST[row2]; // номер МО id_municip
$R3 = $_REQUEST[row3]; // population
$R4 = $_REQUEST[row4]; // mortality смертность
$R5 = $_REQUEST[row5]; // fertility рождаемость
$R6 = $_REQUEST[row6]; // год из формы
$RY = $_REQUEST[rowY]; // последний год существующий в  БД
$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");
echo ("id_demograph_inf=");
echo ($R1);
echo (",\n id_municip=");
echo ($R2);
echo (",\n population=");
echo ($R3);
echo (",\n mortality=");
echo ($R4);
echo (",\n fertility=");
echo ($R5);
echo (",\n year=");
echo ($R6);
echo (",\n последний год существующий в  БД=");
echo ($RY);


if ($connection == false) {
    echo 'Не удалось подключиться к БД';
    exit;
}
if ($R6 <= $RY) { //если год из формы меньше последнего года в БД, изменяем данные в БД, иначе добавляем новую строчку в БД
    $query = "UPDATE demograph_inf SET population=$R3, mortality=$R4, fertility=$R5 WHERE id_demograph_inf=$R1";
    pg_query($connection, $query);
} else {
    $E1 = $R2 . $R6; // это поле ключа для id_demograph_inf обьеденяет год и номер МО (например 112020)
    $query = "INSERT INTO demograph_inf (id_demograph_inf, id_municip, population, mortality, fertility, year) VALUES ( $E1, $R2, $R3, $R4, $R5,$R6)";
    pg_query($connection, $query);
}




header("Location:index.php");
