<?php
$R1 = $_REQUEST[row1]; //переменная с номером id_migrat_inf
$R2 = $_REQUEST[row2]; // номер МО id_municip
$R3 = $_REQUEST[row3]; // drop_out количество выбывших
$R4 = $_REQUEST[row4]; // arrive кол-во прибывших
$R5 = $_REQUEST[row5]; // balance сальдо
$R6 = $_REQUEST[row6]; // год из формы
$RY = $_REQUEST[rowY]; // последний год существующий в  БД
$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");
echo ("id_migrat_inf=");
echo ($R1);
echo (",\n id_municip=");
echo ($R2);
echo (",\n drop_out=");
echo ($R3);
echo (",\n arrive=");
echo ($R4);
echo (",\n balance=");
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
    $query = "UPDATE migrat_inf SET drop_out=$R3, arrive=$R4, balance=$R5 WHERE id_municip=$R2 AND year='$R6'";
    pg_query($connection, $query);
} else {
    $E1 = $R2 . $R6; // это поле ключа для id_migrat_inf обьеденяет год и номер МО (например 112020)
    $query = "INSERT INTO migrat_inf (id_migrat_inf, id_municip, drop_out, arrive, balance, year) VALUES ( $E1, $R2, $R3, $R4, $R5, $R6)";
    pg_query($connection, $query);
}




header("Location:index.php");
