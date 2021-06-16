<?php
$R1 = $_REQUEST[row1]; //переменная с номером id_soc_econ_inf
$R2 = $_REQUEST[row2]; // номер МО id_municip
$R3 = $_REQUEST[row3]; // employed Среднесписочная численность занятых в экономике
$R4 = $_REQUEST[row4]; // aver_salary Среднемесячная заработная плата
$R5 = $_REQUEST[row5]; // emission Выбросы
$R6 = $_REQUEST[row6]; // investment Инвестиции
$R7 = $_REQUEST[row7]; // ship_products Отгруженная продукция
$R8 = $_REQUEST[row8]; // год из формы
$RY = $_REQUEST[rowY]; // последний год существующий в  БД
$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");

echo ("id_soc_econ_inf=");
echo ($R1);
echo (",\n id_municip=");
echo ($R2);
echo (",\n employed=");
echo ($R3);
echo (",\n aver_salary=");
echo ($R4);
echo (",\n emission=");
echo ($R5);
echo (",\n investment=");
echo ($R6);
echo (",\n ship_products=");
echo ($R7);
echo (",\n year=");
echo ($R8);
echo (",\n последний год существующий в  БД=");
echo ($RY);

if ($connection == false) {
    echo 'Не удалось подключиться к БД';
    exit;
}
if ($R8 <= $RY) { //если год из формы меньше последнего года в БД, изменяем данные в БД, иначе добавляем новую строчку в БД
    $query = "UPDATE soc_econ_inf SET employed=$R3, aver_salary=$R4, emission=$R5, investment=$R6, ship_products=$R7 WHERE id_municip=$R2 AND year='$R8'";
    pg_query($connection, $query);
} else {
    $E1 = $R2 . $R8; // это поле ключа для id_soc_econ_inf обьеденяет год и номер МО (например 112020)
    $query = "INSERT INTO soc_econ_inf (id_soc_econ_inf, id_municip, employed, aver_salary, emission, investment, ship_products, year) VALUES ( $E1, $R2, $R3, $R4, $R5, $R6, $R7, $R8)";
    pg_query($connection, $query);
}




header("Location:index.php");
