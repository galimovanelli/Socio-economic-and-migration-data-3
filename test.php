<?php
//создаем переменную connection для соединения с БД Postgre
$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");
//если подключение не установлено - выводим сообщение об ошибке
if ($connection == false) {
    echo 'Не удалось подключиться к БД';
    exit;
}
//функция запроса к таблице (представлению) v_soc_econ_inf_new
//передаем параметры для результата запроса - res, подключения к БД - con и год year_arg
function f_soc_econ_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_soc_econ_inf_new WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}
//аналогично функции с социаьно-экономическими данными. Тут для ДЕМОГРАФИЧЕСКИХ
function f_demograph_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_demograph_inf WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}
//аналогично функции с социаьно-экономическими данными. Тут для МИГРАЦИОННЫХ
function f_migrat_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_migrat_inf WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}
//аналогично функции с социаьно-экономическими данными. Тут для КОЭФФИЦИЕНТА ПРИВЛЕКАТЕЛЬНОСТИ
function f_attract_coef(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_attract_coef WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}
?>
<!-- подключаем библиотеки bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<style>
    /* стиль для вкладок */
    .nav-link {
        padding: 5px;
    }

    .nav-item {
        text-align: center;
    }

    table,
    th,
    td {
        border: 1px solid #0d6efd;
    }

    table {
        border: 1px solid #0d6efd;
    }

    td,
    th {
        padding: 10px;
    }

    .datatable td {
        box-sizing: border-box;
        width: 185px;
    }

    .datatable td:first-child {
        width: 35px;
    }

    .datatable td:nth-child(2) {
        width: 50px;
    }

    .datatable td:last-child {
        width: 100px;
    }

    .input_textbox {
        width: 100px;
    }

    .datatable_soc td {
        box-sizing: border-box;
        width: 136px;
    }

    .datatable_soc td:first-child {
        width: 35px;
    }

    .datatable_soc td:nth-child(2) {
        width: 48px;
    }

    .datatable_soc td:last-child {
        width: 100px;
    }

    .submit__save {
        color: #fff;
        background-color: #5d9eff;
        border-radius: .3rem;
        font: 12px/1.5 "Helvetica Neue", Arial, Helvetica, sans-serif;
        border-color: white;
        border-style: solid;
    }
    .table_koef td{
        background-color: #c4dcff;
    }
    .table_koef td:first-child{
        background-color: white;
    }
    .table_koef td:nth-child(2){
        background-color: white;
    }
    .table_koef td:nth-child(3){
        background-color: white;
    }
    .table_koef td:nth-child(4){
        background-color: white;
    }
    .table_koef td:nth-child(5){
        background-color: white;
    }
    .table_koef td:nth-child(6){
        background-color: white;
    }
    .table_koef td:nth-child(7){
        background-color: white;
    }
    .table_koef td:nth-child(8){
        background-color: white;
    }

</style>

<!-- ВЕРСТКА. Вкладки по всем таблицам из БД + графики (динимика) -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="demog-tab" data-bs-toggle="tab" href="#demog" role="tab" aria-controls="demog" aria-selected="true">Демографические<br>данные</a>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="demog-dinam-tab" data-bs-toggle="tab" href="#demog-dinam" role="tab" aria-controls="demog-dinam" aria-selected="false">Динамика <br>демографических<br> данных</a>
    </li> -->
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="migr-tab" data-bs-toggle="tab" href="#migr" role="tab" aria-controls="migr" aria-selected="true">Миграционные <br>данные</a>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="migr-dinam-tab" data-bs-toggle="tab" href="#migr-dinam" role="tab" aria-controls="migr-dinam" aria-selected="false">Динамика<br> миграционных <br>данных</a>
    </li> -->
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="soc-econ-tab" data-bs-toggle="tab" href="#soc-econ" role="tab" aria-controls="soc-econ" aria-selected="false">Социально-<br>экономические<br> данные</a>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="soc-econ-dinam-tab" data-bs-toggle="tab" href="#soc-econ-dinam" role="tab" aria-controls="soc-econ-dinam" aria-selected="false">Динамика <br>социально-экономических<br> данных</a>
    </li> -->
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="koef-tab" data-bs-toggle="tab" href="#koef" role="tab" aria-controls="koef" aria-selected="false">Коэфиициент <br>привлекательности</a>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="forecast-tab" data-bs-toggle="tab" href="#forecast" role="tab" aria-controls="forecast" aria-selected="false">Прогноз КП</a>
    </li> -->
</ul>
<!-- Содержимое вкладки демографические данные -->
<div class="tab-content" id="myTabContent">
    <br>
    <div class="tab-pane fade show active" id="demog" role="tabpanel" aria-labelledby="demog-tab">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-initial-demog-tab" data-bs-toggle="pill" href="#pills-initial-demog" role="tab" aria-controls="pills-initial-demog" aria-selected="true">Исходные</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-edit-demog-tab" data-bs-toggle="pill" href="#pills-edit-demog" role="tab" aria-controls="pills-edit-demog" aria-selected="false">Редактировать</a>
            </li>
            <!-- <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-gist-demog-tab" data-bs-toggle="pill" href="#pills-gist-demog" role="tab" aria-controls="pills-gist-demog" aria-selected="false">Гистограмма</a>
            </li> -->
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-initial-demog" role="tabpanel" aria-labelledby="pills-initial-demog-tab">
                <!-- содержимое вкладки исходные данные -->
                <?php
                f_demograph_inf($result, $connection, 2013);
                $row = pg_fetch_row($result);
                $St = (pg_query($connection, "SELECT * FROM demograph_inf WHERE id_municip=" . $_GET["polyId"]));
                $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)
                $St1 = (pg_query($connection, "SELECT COUNT(*) FROM demograph_inf WHERE id_municip=" . $_GET["polyId"])) + 2;
                ?>
                <h1> <strong> <?php echo $row[2] ?> </strong> </h1>

                <input type="hidden" name=row1 value="<?php echo $row[1] ?>">

                <table>
                    <tr>
                        <td><strong>Год:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_demograph_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo $row[6] ?> </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Численность населения:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_demograph_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo $row[3] ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Коэффициент смертности:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_demograph_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo $row[4] ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Коэффициент рождаемости:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_demograph_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo $row[5] ?></td>
                        <?php }
                        ?>
                    </tr>
                </table>

            </div>
            <!-- содержимое вкладки редактировать данные -->
            <div class="tab-pane fade" id="pills-edit-demog" role="tabpanel" aria-labelledby="pills-edit-demog-tab">
                <?php

                f_demograph_inf($result, $connection, 2013);
                $row = pg_fetch_row($result);
                $St = (pg_query($connection, "SELECT * FROM demograph_inf WHERE id_municip=" . $_GET["polyId"]));
                $St = pg_num_rows($St) + 1; //подсчет строк в таблице демография у МО (polyId)
                $St2 = $St + 2012; // это номер года которого нет в БД для данного МО

                ?>
                <h1> <strong> <?php echo $row[2] ?> </strong> </h1>

                <table class="datatable">

                    <tr>
                        <td><strong>№ </strong></td>
                        <td><strong>Год</strong></td>
                        <td><strong>Численность населения</strong></td>
                        <td><strong>Коэффициент смертности</strong></td>
                        <td><strong>Коэффициент рождаемости</strong></td>
                        <td><strong>Сохранить</strong></td>
                    </tr>
                </table>
                <?php
                for ($i2 = 1; $i2 < $St; $i2++) // цикл для вывода всех строк из БД

                {
                    f_demograph_inf($result, $connection, $i2 + 2012);
                    $row = pg_fetch_row($result); ?>

                    <tr>
                        <form action="ism.php">
                            <table class="datatable">
                                <tr>
                                    <td><?php echo $i2 ?> <input type="hidden" name=row1 value="<?php echo $row[0] ?>"></td>
                                    <td><?php echo $row[6] ?><input type="hidden" name=row6 value="<?php echo $row[6] ?>">
                                        <input type="hidden" name=rowY value="<?php echo $row[6] ?>">
                                    </td>
                                    <td><input value="<?php echo $row[3] ?>" name=row3></td>
                                    <td><input value="<?php echo $row[4] ?>" name=row4></td>
                                    <td><input value="<?php echo $row[5] ?>" name=row5></td>
                                    <td><input class="submit__save" type="submit" value="Сохранить"></td>

                                </tr>
                            </table>

                        </form>
                    </tr>
                <?php }
                ?> <p><b>
                        <font size="4"> Добавить данные за <?php echo $St2 ?> год:</font>
                    </b></p>

                <tr>
                    <form action="ism.php">
                        <table class="datatable">
                            <tr>
                                <td>
                                    <input type="hidden" name=row2 value="<?php echo $_GET["polyId"] ?>"> <?php // hidden это скрытое поле для передачи переменной в файл ism.php
                                                                                                            ?>
                                    <input type="hidden" name=rowY value="<?php echo $row[6] ?>">
                                </td> <?php // последний год из БД
                                        ?>
                                <td><?php echo $St2 ?><input type="hidden" name=row6 value="<?php echo $St2 ?>"></td> <?php //  это номер года которого нет в БД для данного МО
                                                                                                                        ?>
                                <td><input value="0" name=row3></td>
                                <td><input value="0" name=row4></td>
                                <td><input value="0" name=row5></td>
                                <td><input class="submit__save" type="submit" value="Добавить"></td>
                            </tr>
                        </table>
                    </form>
                </tr>
            </div>
            <!-- <div class="tab-pane fade" id="pills-gist-demog" role="tabpanel" aria-labelledby="pills-gist-demog-tab">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-nasel-demog-tab" data-bs-toggle="pill" href="#pills-nasel-demog" role="tab" aria-controls="pills-nasel-demog" aria-selected="true">Численность населения</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-smert-demog-tab" data-bs-toggle="pill" href="#pills-smert-demog" role="tab" aria-controls="pills-smert-demog" aria-selected="false">Коэффициент смертности</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-rozd-demog-tab" data-bs-toggle="pill" href="#pills-rozd-demog" role="tab" aria-controls="pills-rozd-demog" aria-selected="false">Коэффициент рождаемости</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-nasel-demog" role="tabpanel" aria-labelledby="pills-nasel-demog-tab"></div>
                    <div class="tab-pane fade" id="pills-smert-demog" role="tabpanel" aria-labelledby="pills-smert-demog-tab"></div>
                    <div class="tab-pane fade" id="pills-rozd-demog" role="tabpanel" aria-labelledby="pills-rozd-demog-tab"></div>
                </div>

            </div> -->
        </div>
    </div>
    <!-- Содержимое вкладки динамика демографических данных -->
    <div class="tab-pane fade" id="demog-dinam" role="tabpanel" aria-labelledby="demog-dinam-tab">Динамика демографических</div>

    <!-- Содержимое вкладки миграционные данные -->
    <div class="tab-pane fade" id="migr" role="tabpanel" aria-labelledby="migr-tab">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-abs-migr-tab" data-bs-toggle="pill" href="#pills-abs-migr" role="tab" aria-controls="pills-abs-migr" aria-selected="true">Абсолютные данные</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-1_1000-migr-tab" data-bs-toggle="pill" href="#pills-1_1000-migr" role="tab" aria-controls="pills-1_1000-migr" aria-selected="false">Данные 1 к 1000</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-abs-migr" role="tabpanel" aria-labelledby="pills-abs-migr-tab">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-initial-migr-tab" data-bs-toggle="pill" href="#pills-initial-migr" role="tab" aria-controls="pills-initial-migr" aria-selected="true">Исходные</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-edit-migr-tab" data-bs-toggle="pill" href="#pills-edit-migr" role="tab" aria-controls="pills-edit-migr" aria-selected="false">Редактирование</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-initial-migr" role="tabpanel" aria-labelledby="pills-initial-migr-tab">
                        <!-- содержимое вкладки исходные данные для миграционной информации -->
                        <?php
                        f_migrat_inf($result, $connection, 2013);
                        $row = pg_fetch_row($result);
                        $St = (pg_query($connection, "SELECT * FROM migrat_inf WHERE id_municip=" . $_GET["polyId"]));
                        $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)
                        $St1 = (pg_query($connection, "SELECT COUNT(*) FROM migrat_inf WHERE id_municip=" . $_GET["polyId"])) + 2;
                        ?>
                        <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                        <table>
                            <tr>
                                <td><strong>Год:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_migrat_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[9] ?> </td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Численность выбывших:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_migrat_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result); ?>
                                    <td><?php echo $row[2] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Численность прибывших:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_migrat_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result); ?>
                                    <td><?php echo $row[4] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Сальдо миграции:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_migrat_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[6] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Численность населения:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_migrat_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[8] ?></td>
                                <?php }
                                ?>
                            </tr>
                        </table>
                    </div>
                    <!-- Содержимое вкладки редактирование МИГРАЦИОННЫХ данных -->
                    <div class="tab-pane fade" id="pills-edit-migr" role="tabpanel" aria-labelledby="pills-edit-migr-tab">
                        <?php

                        f_migrat_inf($result, $connection, 2013);
                        $row = pg_fetch_row($result);
                        $St = (pg_query($connection, "SELECT * FROM migrat_inf WHERE id_municip=" . $_GET["polyId"]));
                        $St = pg_num_rows($St) + 1; //подсчет строк в таблице демография у МО (polyId)
                        $St2 = $St + 2012; // это номер года которого нет в БД для данного МО

                        ?>
                        <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                        <table class="datatable">

                            <tr>
                                <td><strong>№ </strong></td>
                                <td><strong>Год</strong></td>
                                <td><strong>Численность выбывших</strong></td>
                                <td><strong>Численность прибывших</strong></td>
                                <td><strong>Сальдо миграции</strong></td>
                                <td><strong>Сохранить</strong></td>
                            </tr>
                        </table>
                        <?php
                        for ($i2 = 1; $i2 < $St; $i2++) // цикл для вывода всех строк из БД

                        {
                            f_migrat_inf($result, $connection, $i2 + 2012);
                            $row = pg_fetch_row($result); ?>

                            <tr>
                                <form action="ism_migr.php">
                                    <table class="datatable">
                                        <tr>
                                            <td><?php echo $i2 ?> <input type="hidden" name=row2 value="<?php echo $row[0] ?>"></td>
                                            <td><?php echo $row[9] ?><input type="hidden" name=row6 value="<?php echo $row[9] ?>">
                                                <input type="hidden" name=rowY value="<?php echo $row[9] ?>">
                                            </td>
                                            <td><input value="<?php echo $row[2] ?>" name=row3></td>
                                            <td><input value="<?php echo $row[4] ?>" name=row4></td>
                                            <td> <?php echo $row[6] ?> <input type="hidden" value="<?php echo $row[6] ?>" name=row5></td>
                                            <td><input class="submit__save" type="submit" value="Сохранить"></td>
                                        </tr>
                                    </table>

                                </form>
                            </tr>
                        <?php }
                        ?> <p><b>
                                <font size="4"> Добавить данные за <?php echo $St2 ?> год:</font>
                            </b></p>

                        <tr>
                            <form action="ism_migr.php">
                                <table class="datatable">
                                    <tr>
                                        <td>
                                            <input type="hidden" name=row2 value="<?php echo $_GET["polyId"] ?>"> <?php // hidden это скрытое поле для передачи переменной в файл ism.php
                                                                                                                    ?>
                                            <input type="hidden" name=rowY value="<?php echo $row[6] ?>">
                                        </td> <?php // последний год из БД
                                                ?>
                                        <td><?php echo $St2 ?><input type="hidden" name=row6 value="<?php echo $St2 ?>"></td> <?php //  это номер года которого нет в БД для данного МО
                                                                                                                                ?>
                                        <td><input value="0" name=row3></td>
                                        <td><input value="0" name=row4> <input type="hidden" value="0" name=row5></td>
                                        <td><input class="submit__save" type="submit" value="Добавить"></td>
                                    </tr>
                                </table>
                            </form>
                        </tr>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="pills-1_1000-migr" role="tabpanel" aria-labelledby="pills-1_1000-migr-tab">
                <!-- содержимое вкладки исходные данные для миграционной информации 1 к 1000 -->
                <?php
                f_migrat_inf($result, $connection, 2013);
                $row = pg_fetch_row($result);
                $St = (pg_query($connection, "SELECT * FROM migrat_inf WHERE id_municip=" . $_GET["polyId"]));
                $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)
                $St1 = (pg_query($connection, "SELECT COUNT(*) FROM migrat_inf WHERE id_municip=" . $_GET["polyId"])) + 2;
                ?>
                <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                <table>
                    <tr>
                        <td><strong>Год:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_migrat_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[9], 2) ?> </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Численность выбывших:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_migrat_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo round($row[3], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Численность прибывших:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_migrat_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo round($row[5], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Сальдо миграции:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_migrat_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[7], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <!-- содержимое вкладки динамики миграционных данных -->
    <div class="tab-pane fade" id="migr-dinam" role="tabpanel" aria-labelledby="migr-dinam-tab">Динамика миграционных данных</div>

    <!-- содержимое вкладки социально-экономических данных -->
    <div class="tab-pane fade" id="soc-econ" role="tabpanel" aria-labelledby="soc-econ-tab">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-abs-soc-econ-tab" data-bs-toggle="pill" href="#pills-abs-soc-econ" role="tab" aria-controls="pills-abs-soc-econ" aria-selected="true">Абсолютные данные</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-1_1000-soc-econ-tab" data-bs-toggle="pill" href="#pills-1_1000-soc-econ" role="tab" aria-controls="pills-1_1000-soc-econ" aria-selected="false">Данные 1 к 1000 населения</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-normir-soc-econ-tab" data-bs-toggle="pill" href="#pills-normir-soc-econ" role="tab" aria-controls="pills-normir-soc-econ" aria-selected="false">Нормированные данные</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-abs-soc-econ" role="tabpanel" aria-labelledby="pills-abs-soc-econ-tab">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-initial-soc-econ-tab" data-bs-toggle="pill" href="#pills-initial-soc-econ" role="tab" aria-controls="pills-initial-soc-econ" aria-selected="true">Исходные</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-edit-soc-econ-tab" data-bs-toggle="pill" href="#pills-edit-soc-econ" role="tab" aria-controls="pills-edit-soc-econ" aria-selected="false">Редактирование</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-initial-soc-econ" role="tabpanel" aria-labelledby="pills-initial-soc-econ-tab">
                        <!-- содержимое вкладки исходные данные для социально-экономическое информации -->
                        <?php
                        f_soc_econ_inf($result, $connection, 2013);
                        $row = pg_fetch_row($result);
                        $St = (pg_query($connection, "SELECT * FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"]));
                        $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)
                        $St1 = (pg_query($connection, "SELECT COUNT(*) FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"])) + 2;
                        ?>
                        <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                        <table>
                            <tr>
                                <td><strong>Год:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[17] ?> </td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Среднесписочная численность занятых в экономике:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result); ?>
                                    <td><?php echo $row[2] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Среднемесячная заработная плата:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result); ?>
                                    <td><?php echo $row[5] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Выброшено в атмосферу загрязняющих веществ, <br>отходящих от стационарных источников:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[7] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Объем инвестиций в основной капитал:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[10] ?></td>
                                <?php }
                                ?>
                            </tr>
                            <tr>
                                <td><strong>Объем отгруженной продукции:</strong></td>
                                <?php
                                for ($i1 = 2013; $i1 < $St; $i1++) {
                                    f_soc_econ_inf($result, $connection, $i1);
                                    $row = pg_fetch_row($result);
                                ?>
                                    <td><?php echo $row[13] ?></td>
                                <?php }
                                ?>
                            </tr>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="pills-edit-soc-econ" role="tabpanel" aria-labelledby="pills-edit-soc-econ-tab">
                        <?php
                        f_soc_econ_inf($result, $connection, 2013);
                        $row = pg_fetch_row($result);
                        $St = (pg_query($connection, "SELECT * FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"]));
                        $St = pg_num_rows($St) + 1; //подсчет строк в таблице демография у МО (polyId)
                        $St2 = $St + 2012; // это номер года которого нет в БД для данного МО
                        ?>

                        <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                        <table class="datatable_soc">
                            <tr>
                                <td><strong>№ </strong></td>
                                <td><strong>Год</strong></td>
                                <td><strong>Среднесписочная численность занятых в экономике</strong></td>
                                <td><strong>Среднемесячная заработная плата</strong></td>
                                <td><strong>Выброшено в атмосферу загрязняющих веществ,<br>отходящих от стационарных источников</strong></td>
                                <td><strong>Объем инвестиций в основной капитал</strong></td>
                                <td><strong>Объем отгруженной продукции</strong></td>
                                <td><strong>Сохранить</strong></td>
                            </tr>
                        </table>

                        <?php
                        for ($i2 = 1; $i2 < $St; $i2++) // цикл для вывода всех строк из БД
                        {
                            f_soc_econ_inf($result, $connection, $i2 + 2012);
                            $row = pg_fetch_row($result); ?>
                            <tr>
                                <form action="ism_soc-econ.php">
                                    <table class="datatable_soc">
                                        <tr>
                                            <td><?php echo $i2 ?> <input type="hidden" name=row2 value="<?php echo $row[0] ?>"></td>
                                            <td><?php echo $row[17] ?><input type="hidden" name=row8 value="<?php echo $row[17] ?>">
                                                <input type="hidden" name=rowY value="<?php echo $row[17] ?>">
                                            </td>
                                            <td><input class="input_textbox" value="<?php echo $row[2] ?>" name=row3></td>
                                            <td><input class="input_textbox" value="<?php echo $row[5] ?>" name=row4></td>
                                            <td><input class="input_textbox" value="<?php echo $row[7] ?>" name=row5></td>
                                            <td><input class="input_textbox" value="<?php echo $row[10] ?>" name=row6></td>
                                            <td><input class="input_textbox" value="<?php echo $row[13] ?>" name=row7></td>
                                            <td><input class="submit__save" type="submit" value="Сохранить"></td>
                                        </tr>
                                    </table>
                                </form>
                            </tr>
                        <?php }
                        ?> <p><b>
                                <font size="4"> Добавить данные за <?php echo $St2 ?> год:</font>
                            </b></p>

                        <tr>
                            <form action="ism_soc-econ.php">
                                <table class="datatable_soc">
                                    <tr>
                                        <td>
                                            <input type="hidden" name=row2 value="<?php echo $_GET["polyId"] ?>"> <?php // hidden это скрытое поле для передачи переменной в файл ism.php
                                                                                                                    ?>
                                            <input type="hidden" name=rowY value="<?php echo $row[6] ?>">
                                        </td> <?php // последний год из БД
                                                ?>
                                        <td><?php echo $St2 ?><input type="hidden" name=row8 value="<?php echo $St2 ?>"></td> <?php //  это номер года которого нет в БД для данного МО
                                                                                                                                ?>
                                        <td><input class="input_textbox" value="0" name=row3></td>
                                        <td><input class="input_textbox" value="0" name=row4></td>
                                        <td><input class="input_textbox" value="0" name=row5></td>
                                        <td><input class="input_textbox" value="0" name=row6></td>
                                        <td><input class="input_textbox" value="0" name=row7></td>
                                        <td><input class="submit__save" type="submit" value="Добавить"></td>
                                    </tr>
                                </table>
                            </form>
                        </tr>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="pills-1_1000-soc-econ" role="tabpanel" aria-labelledby="pills-1_1000-soc-econ-tab">
                <!-- содержимое вкладки исходные данные для социально-экономическое информации 1 к 1000-->
                <?php
                f_soc_econ_inf($result, $connection, 2013);
                $row = pg_fetch_row($result);
                $St = (pg_query($connection, "SELECT * FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"]));
                $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)                
                ?>
                <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                <table>
                    <tr>
                        <td><strong>Год:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo $row[17] ?> </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Среднесписочная численность занятых в экономике:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo round($row[3], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Выброшено в атмосферу загрязняющих веществ, <br>отходящих от стационарных источников:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[8], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Объем инвестиций в основной капитал:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[11], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Объем отгруженной продукции:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[14], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                </table>

            </div>
            <div class="tab-pane fade" id="pills-normir-soc-econ" role="tabpanel" aria-labelledby="pills-normir-soc-econ-tab">
                <!-- содержимое вкладки исходные данные для социально-экономическое информации НОРМИРОВАННЫЕ-->
                <?php
                f_soc_econ_inf($result, $connection, 2013);
                $row = pg_fetch_row($result);
                $St = (pg_query($connection, "SELECT * FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"]));
                $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)
                $St1 = (pg_query($connection, "SELECT COUNT(*) FROM soc_econ_inf WHERE id_municip=" . $_GET["polyId"])) + 2;
                ?>
                <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

                <table>
                    <tr>
                        <td><strong>Год:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo $row[17] ?> </td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Среднесписочная численность занятых в экономике:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo round($row[4], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Среднемесячная заработная плата:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result); ?>
                            <td><?php echo round($row[6], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Выброшено в атмосферу загрязняющих веществ, <br>отходящих от стационарных источников:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[9], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Объем инвестиций в основной капитал:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[12], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td><strong>Объем отгруженной продукции:</strong></td>
                        <?php
                        for ($i1 = 2013; $i1 < $St; $i1++) {
                            f_soc_econ_inf($result, $connection, $i1);
                            $row = pg_fetch_row($result);
                        ?>
                            <td><?php echo round($row[15], 2) ?></td>
                        <?php }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- содержимое вкладки динамика социально-экономических данных -->
    <div class="tab-pane fade" id="soc-econ-dinam" role="tabpanel" aria-labelledby="soc-econ-dinam-tab"> Динамика данных СЭ</div>

    <!-- содержимое вкладки коэффициент привлекательности -->
    <div class="tab-pane fade" id="koef" role="tabpanel" aria-labelledby="koef-tab">
        <!-- содержимое вкладки исходные данные для социально-экономическое информации НОРМИРОВАННЫЕ-->
        <?php
        f_attract_coef($result, $connection, 2013);
        $row = pg_fetch_row($result);
        $St = (pg_query($connection, "SELECT * FROM v_attract_coef WHERE id_municip=" . $_GET["polyId"]));
        $St = pg_num_rows($St) + 2013; //подсчет строк в таблице демография у МО (polyId)

        ?>
        <h1> <strong> <?php echo $row[1] ?> </strong> </h1>

        <table class="table_koef">
            <tr>
                <td><strong>Год</strong></td>
                <?php
                for ($i1 = 2013; $i1 < $St; $i1++) {
                    f_attract_coef($result, $connection, $i1);
                    $row = pg_fetch_row($result);
                ?>
                    <td><?php echo $row[3] ?> </td>
                <?php }
                ?>
            </tr>
            <tr>
                <td><strong>Коэффициент привлекательности</strong></td>
                <?php
                for ($i1 = 2013; $i1 < $St; $i1++) {
                    f_attract_coef($result, $connection, $i1);
                    $row = pg_fetch_row($result); ?>
                    <td><?php echo round($row[2], 2) ?></td>
                <?php }
                ?>
            </tr>
        </table>

    </div>

    <div class="tab-pane fade" id="forecast" role="tabpanel" aria-labelledby="forecast-tab">Тут будет прогноз</div>

</div>

<?php
