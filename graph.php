<?php

// создание переменной год
$id = isset($_GET['polygonIDforGraph']) ? $_GET['polygonIDforGraph'] : '1';
$year = isset($_GET['yearForGraph']) ? $_GET['yearForGraph'] : '2013';

print($id);
print($year);

// $sql = "SELECT m.name, m.id_municip, a.coef_value, a.year FROM municipality m INNER JOIN v_attract_coef a ON m.id_municip = a.id_municip WHERE year = '$year'";


// // подключение к БД
// $connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");

// $result = pg_query($connection, $sql);
// // создаем ассоциативный массив
// $arr = pg_fetch_all($result, $result_type = PGSQL_ASSOC);

// $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
// print($json);


$connection = pg_connect("host=localhost port=5432 dbname=bashDB user=postgres password=1234");

if ($connection == false) {
    echo 'Не удалось подключиться к БД';
    exit;
}

function f_soc_econ_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_soc_econ_inf_new WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}

function f_demograph_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_demograph_inf WHERE id_municip = 35 AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}

function f_migrat_inf(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_migrat_inf WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}
//v_attract_coef
function f_attract_coef(&$res, $con, $year_arg)
{
    $res = pg_query($con, "SELECT * FROM v_attract_coef WHERE id_municip = " . $_GET["polyId"] . " AND year = '$year_arg'");
    if (!$res) {
        echo "Произошла ошибка.\n";
        exit;
    }
}

?>
<?php
				
                f_demograph_inf($result, $connection,2013);
				$row = pg_fetch_row($result); 
				$St=(pg_query($connection, "SELECT * FROM demograph_inf WHERE id_municip=35"));
				$St=pg_num_rows($St)+2013 ;
				$St1=(pg_query($connection, "SELECT COUNT(*) FROM demograph_inf WHERE id_municip=35"))+2;
				?>
				<h1> <strong> <?php echo $row[2]?> </strong> </h1>

     
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Год', 'Численность населения'] // - на основе этих данных формируем графики.
                    <?php 	 for ($i1=2013; $i1<$St; $i1++) { f_demograph_inf($result, $connection, $i1); $row = pg_fetch_row($result); 	 ?>
					,[<?php echo $i1 ?>, <?php echo $row[3]?>]
					<?php } ?> 	
                    ]);
                var options = {
                    title: 'Численность населения', // - заголовок диаграммы.
                    series: {0: {color: 'green'}, 1: {color: 'black'}}, // - цвета столбцов.
                    hAxis: {title: 'Год', titleTextStyle: {color: 'green'}} // - цвет и надпись, нижняя.
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('company_performance'));
                chart.draw(data, options);
            }
        </script>
    
	    
    <body>
        <div id="company_performance" style="width: 600px; height: 400px;"></div>
        <!-- Вместо этого дива будет красивая гистограмма, см. выше. -->
    </body>
