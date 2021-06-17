<!-- главные файл проекта, стартовая страница -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/leaflet.css">
    <link rel="stylesheet" href="css/qgis2web.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/leaflet-control-geocoder.Geocoder.css">
    <link rel="stylesheet" href="css/choroplet.css">

    <style>
        html,
        body,
        #map {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }

        .graph {
            text-align: center;
            /* width: 120px; */
            /* height: 100%; */
            top: 145px;
            left: 10px;
            padding: 0px;
            z-index: 410;
            position: absolute;
            visibility: inherit;
            display: flex;
            flex-direction: column;
            background-color: rgba(255, 255, 255, 0);
            border-radius: 5px;
            align-items: center;
            box-shadow: 0 1px 5px rgb(0 0 0 / 0%);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
        }

        .modal .modal_content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 750px;
            z-index: 99999;
            /* display: flex;
    justify-content: center; */
        }

        .modal .modal_content .close_modal_window {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        #graph__go {
            padding: 0;
            justify-content: flex-start;
            border-bottom: none;
            display: inline-block;
            border-radius: 4px;
            /* width: 90px; */
            height: 26px;
            border: none;
            background-color: grey;
            font: 13px/1.5 "Helvetica Neue", Arial, Helvetica, sans-serif;
            color: white;
            margin-bottom: 5px;
            background-color: #0d6efd;
        }

        #btn_modal_window {
            width: 26px;
            height: 26px;
            /* justify-content: start; */
            background-color: white;
            padding: 3px;
            border-radius: 4px;
            background-image: url(images/graph.png);
            box-shadow: 0 1px 5px rgb(0 0 0 / 40%);
            border-width: 0px;
        }

        #graph__content {
            width: 650px;
            height: 500px;
            border: red dashed 2px;
            margin: auto;
        }
    </style>

    <title></title>
</head>

<body>
    <div id="map">
    </div>
    <div class="chproplet">
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle">
        </label>
        <div class="menu__box">
            <div class="in">
                <p class="chproplet_text">Год</p>
                <input id="textbox" type="text" value="2013">
            </div>
            <button type="button" id="chproplet_go">Районировать</button>
            <button type="button" id="chproplet_del"> <img class="chproplet_del_img" src="css/images/del_blue.png" alt="Кнопка «button»"></button>
        </div>

        <div class="legend leaflet-control">
            <b>
                <h4>Коэффициент<br>привлекательности</h4>
            </b>
            <i style="background: #ec1e24"></i><span>0 – 0.393</span><br>
            <i style="background: #ed779e"></i><span>0.393 – 0.815</span><br>
            <i style="background: #fcf181"></i><span>0.815 – 2.075</span><br>
            <i style="background: #7cc36c"></i><span>2.075+</span><br>
        </div>
    </div>

    <div class="graph">
        <button id="btn_modal_window">Open Modal</button>
        <div id="my_modal" class="modal">
            <div class="modal_content">
                <span class="close_modal_window">×</span>
                <select id="select__id">
                    <option value="1">Абзелиловский район</option>
                    <option value="2">Альшеевский район</option>
                    <option value="3">Архангельский район</option>
                    <option value="4">Аскинский район</option>
                    <option value="5">Аургазинский район</option>
                    <option value="6">Баймакский район</option>
                    <option value="7">Бакалинский район</option>
                    <option value="8">Балтачевский район</option>
                    <option value="9">Белебеевский район</option>
                    <option value="10">Белокатайский район</option>
                    <option value="11">Белорецкий район</option>
                    <option value="12">Бижбулякский район</option>
                    <option value="13">Бирский район</option>
                    <option value="14">Благоварский район</option>
                    <option value="15">Благовещенский район</option>
                    <option value="16">Буздякский район</option>
                    <option value="17">Бураевский район</option>
                    <option value="18">Бурзянский район</option>
                    <option value="19">Гафурийский район</option>
                    <option value="20">Давлекановский район</option>
                    <option value="21">Дуванский район</option>
                    <option value="22">Дюртюлинский район</option>
                    <option value="23">Ермекеевский район</option>
                    <option value="24">Зианчуринский район</option>
                    <option value="25">Зилаирский район</option>
                    <option value="26">Иглинский район</option>
                    <option value="27">Илишевский район</option>
                    <option value="28">Ишимбайский район</option>
                    <option value="29">Калтасинский район</option>
                    <option value="30">Караидельский район</option>
                    <option value="31">Кармаскалинский район</option>
                    <option value="32">Кигинский район</option>
                    <option value="33">Краснокамский район</option>
                    <option value="34">Кугарчинский район</option>
                    <option value="35">Куюргазинский район</option>
                    <option value="36">Кушнаренковский район</option>
                    <option value="37">Мелеузовский район</option>
                    <option value="38">Мечетлинский район</option>
                    <option value="39">Мишкинский район</option>
                    <option value="40">Миякинский район</option>
                    <option value="41">Нуримановский район</option>
                    <option value="42">Салаватский район</option>
                    <option value="43">Стерлибашевский район</option>
                    <option value="44">Стерлитамакский район</option>
                    <option value="45">Татышлинский район</option>
                    <option value="46">Туймазинский район</option>
                    <option value="47">Уфимский район</option>
                    <option value="48">Учалинский район</option>
                    <option value="49">Фёдоровский район</option>
                    <option value="50">Хайбуллинский район</option>
                    <option value="51">Чекмагушевский район</option>
                    <option value="52">Чишминский район</option>
                    <option value="53">Шаранский район</option>
                    <option value="54">Янаульский район</option>
                    <option value="55">г. Уфа</option>
                    <option value="56">г. Агидель</option>
                    <option value="57">г. Кумертау</option>
                    <option value="58">г. Нефтекамск</option>
                    <option value="59">г. Октябрьский</option>
                    <option value="60">г. Салават</option>
                    <option value="61">г. Сибай</option>
                    <option value="62">г. Стерлитамак</option>
                </select>
                <div id="graph__content">
                    <canvas id="graph__element" style="width: 600px; height: 400px;"></canvas>
                </div>
                <button type="button" id="graph__go">Построить график</button>
            </div>
        </div>
    </div>


    <script src="js/qgis2web_expressions.js"></script>
    <script src="js/leaflet.js"></script>
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="js/leaflet.pattern.js"></script>
    <script src="js/leaflet-hash.js"></script>
    <script src="js/Autolinker.min.js"></script>
    <script src="js/rbush.min.js"></script>
    <script src="js/labelgun.min.js"></script>
    <script src="js/labels.js"></script>
    <script src="js/leaflet-control-geocoder.Geocoder.js"></script>
    <script src="data/municipality_1.js"></script>
    <script src="data/city_2.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var highlightLayer;
        console.log(google);
        window.google = google;

        //функция, которая отвечает за изменения цвета объекта при наведении на него мышью
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
                highlightLayer.setStyle({
                    color: '#a7f943', //салатовый цвет
                });
            } else {
                highlightLayer.setStyle({
                    fillColor: '#a7f943', //салатовый цвет
                    fillOpacity: 1
                });
            }
        }
        var map = L.map('map', {
            zoomControl: true,
            maxZoom: 20,
            minZoom: 4
        }).fitBounds([
            [50.560064359602706, 47.40830049454001],
            [57.63526907373332, 67.63784079582013]
        ]);
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        var autolinker = new Autolinker({
            truncate: {
                length: 30,
                location: 'smart'
            }
        });
        var bounds_group = new L.featureGroup([]);

        function setBounds() {}
        map.createPane('pane_OSMStandard_0');
        map.getPane('pane_OSMStandard_0').style.zIndex = 400;
        var layer_OSMStandard_0 = L.tileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            pane: 'pane_OSMStandard_0',
            opacity: 1.0,
            attribution: '<a href="https://www.openstreetmap.org/copyright">© OpenStreetMap contributors, CC-BY-SA</a>',
            minZoom: 4,
            maxZoom: 20,
            minNativeZoom: 0,
            maxNativeZoom: 19
        });
        layer_OSMStandard_0;
        map.addLayer(layer_OSMStandard_0);

        function pop_municipality_1(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
                mouseover: highlightFeature,
            });

            var polygonID = autolinker.link(feature.properties['id_municip'].toLocaleString());

            //получаем айдишник из БД с помощью асинхронного запроса
            fetch("test.php?polyId=" + polygonID).then((response) => {
                // тут HTTP-ответ, вытаскиваем данные из него
                return response.text()
            }).then((content) => {
                // тут уже есть данные, передаем их во всплывающее окно
                layer.bindPopup(content, {
                    // maxWidth: 50000,
                    minWidth: 880,
                    maxHeight: 20000
                })
            })
            // var popupContent = '<table>\
            //         <tr>\
            //             <td colspan="2"><strong>name</strong><br />' + (feature.properties['name'] !== null ? autolinker.link(feature.properties['name'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //         <tr>\
            //             <td colspan="2"><strong>id_municip</strong><br />' + (feature.properties['id_municip'] !== null ? autolinker.link(feature.properties['id_municip'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //     </table>';
            // layer.bindPopup(popupContent, {maxHeight: 400});
        }

        chproplet_go.onclick = function() {
            // сразу блокируем кнопку "районированить", чтоб пользователь ее разблокировал, нужно нажать на корзину, т.е. очистить карту
            document.getElementById("chproplet_go").disabled = true;
            // создаю переменную, которая хранить знаечение из тега input
            var val = document.getElementById('textbox').value;
            // проверка переменной в консоли
            console.log('Значение года');
            console.log(val);

            // ассинхронный запрос на год в БД
            fetch("api.php?year=" + val).then((response) => {
                // тут HTTP-ответ, вытаскиваем данные из него
                return response.text()
            }).then((content) => {
                // в koefArr записываем JSON-файл с коэффикиентами. Тот самый файл, который сформирован в api.php на сервере
                var koefArr = JSON.parse(content);
                // передаем эти данные в консоль
                // console.log(koefArr);
                // создаем копию JSON-файла json_municipality_1, который является главным и хранит геометрию (координаты)
                var json_municipality_2 = Object.assign({}, json_municipality_1);
                // создаем переменную features, в которую записываем features из json_municipality_2
                var features = json_municipality_2.features;
                // цикл for of перечисляет все этементы в features
                for (const feature of features) {
                    if (feature.properties.id_municip !== 63) {
                        // создаем поле coef_value у feature. и присвоиваем отфильтрованное значение JSON-файла koefArr
                        feature.properties.coef_value = koefArr.filter((value, index, array) => {
                            // фильтрующая функция для  filter(). снавниваем айдишники районов
                            return value.id_municip == feature.properties.id_municip;
                        })[0].coef_value; // метод фильтр возвращает массив, в котором один элемент. и этот этемент coef_value
                        // console.log(feature.properties);
                    } else {
                        // для ЗАТО Межгорья исключение
                        feature.properties.coef_value = 0;
                    }
                }

                // выводим новый собранный json в консоль для проверки
                console.log(json_municipality_2);

                // элемент управления, отображающий информацию о КП в каждом МО при наведении курсора
                var info = L.control();
                // добавить на карту компоненты div и info
                info.onAdd = function(map) {
                    this._div = L.DomUtil.create('div', 'info');
                    this.update();
                    return this._div;
                };
                // обновить информацию
                info.update = function(props) {
                    this._div.innerHTML = '<h4>Коэффициент привлекательности</h4>' + (props ?
                        '<b>' + props.name + '</b><br />' + props.coef_value.substr(0, 4) :
                        'Наведите курсор на муниципальный округ');
                };
                // добавить все на карту
                info.addTo(map);

                // определяем интервалы знчений КП и цвета
                function getColor(d) {
                    return d > 2.075 ? '#7cc36c' : //зеленый 7cc36c 
                        d > 0.815 ? '#fcf181' : //желтый fcf181
                        d > 0.393 ? '#ed779e' : // розовый 
                        '#ec1e24'; // красный 
                }

                // добавили стиль слою
                function style(json_file) {
                    return {
                        fillColor: getColor(json_file.properties.coef_value),
                        weight: 1,
                        opacity: 1,
                        color: '#810f33',
                        dashArray: '3',
                        fillOpacity: 1,
                        zIndex: 9000
                    };
                }

                // подсветка полигонов при наведении
                function highlightFeature(e) {
                    var layer = e.target;

                    // стиль полигонов при наведении на них курсором
                    layer.setStyle({
                        weight: 5,
                        color: '#0d6efd',
                        dashArray: '',
                        fillOpacity: 0.7
                    });

                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                        layer.bringToFront();
                    }

                    info.update(layer.feature.properties);
                }

                var layer_json_municipality_2;

                function resetHighlight(e) {
                    layer_json_municipality_2.resetStyle(e.target);
                    info.update();
                }

                function onEachFeature(json_file, layer) {
                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight,
                    });
                }

                // добвлене json-файла в виде слоя на карту
                map.createPane('pane_json_municipality_2');
                map.getPane('pane_json_municipality_2').style.zIndex = 401;
                map.getPane('pane_json_municipality_2').style['mix-blend-mode'] = 'normal';
                layer_json_municipality_2 = new L.geoJson(json_municipality_2, {
                    attribution: '',
                    interactive: true,
                    dataVar: 'json_municipality_2',
                    layerName: 'layer_json_municipality_2',
                    pane: 'pane_json_municipality_2',
                    style: style,
                    onEachFeature: onEachFeature,
                });
                bounds_group.addLayer(layer_json_municipality_2);
                map.addLayer(layer_json_municipality_2);

                // при нажатии на кнопку "корзину" очищается карта от слоя с районированием и удаляется инфо-поле
                chproplet_del.onclick = function() {
                    map.removeLayer(layer_json_municipality_2); // удалить слой с районированием
                    document.getElementsByClassName("info")[0].remove(); // удалить блок инфо-поля с class='info'
                    document.getElementById("chproplet_go").disabled = false; // активированить кнопку "районированить"
                }
            })
        };

        var modal = document.getElementById("my_modal");
        var btn = document.getElementById("btn_modal_window");
        var span = document.getElementsByClassName("close_modal_window")[0];
        var canv = document.querySelector('#graph__element');

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        var polygonIDforGraph = 10;
        var yearForGraph = 2013;
        var table = 'v_migrat_inf';
        var param = 'drop_out';
        var dataForGraph = [
            ['Год', 'Значение']
        ];
        var dataForGraphData = [];
        var dataFromGraphLabel = [];
        var dataGraphFromServer = [];


        graph__go.onclick = function() {
            console.log(canv);
            //получаем айдишник из БД с помощью асинхронного запроса
            fetch("data_graph.php?district=" + polygonIDforGraph + "&table=" + table + "&param=" + param).then((response) => {
                // тут HTTP-ответ, вытаскиваем данные из него
                return response.text()
            }).then((content) => {
                console.log(content);
                dataGraphFromServer = JSON.parse(content);
                for (const data of dataGraphFromServer) {
                    dataForGraph.push(Object.values(data));
                    dataForGraphData.push(Object.values(data)[0]);
                    dataFromGraphLabel.push(Object.values(data)[1]);
                }
                console.log(dataFromGraphLabel);
                console.log(dataForGraphData);
                dataChartJs = {
                    labels: dataFromGraphLabel,
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        barPercentage: 0.5,
                        barThickness: 6,
                        maxBarThickness: 8,
                        minBarLength: 2,
                        data: dataForGraphData
                    }]
                }
                const config = {
                    type: 'bar',
                    data: dataChartJs,
                    options: {}
                };
                console.log(config);
                var myChart = new Chart(
                    canv,
                    config
                );

                // console.log(dataForGraph);
                // console.log(google);
                // google.load("visualization", "1", {packages: ["corechart"]});
                // google.setOnLoadCallback(drawChart);
                // var drawChart = function() {
                //     console.log('Draw');
                //     var googleData = window.google.visualization.arrayToDataTable(dataForGraph);
                // var options = {
                //     title: 'График', // - заголовок диаграммы.
                //     series: {0: {color: 'green'}, 1: {color: 'black'}}, // - цвета столбцов.
                //     hAxis: {title: 'Год', titleTextStyle: {color: 'green'}} // - цвет и надпись, нижняя.
                // };
                // var chart = new google.visualization.ColumnChart(document.getElementById('graph__element'));
                // chart.draw(googleData, options);

                // };




                // document.getElementById('graph__content').innerHTML = content;

            });
        }


        function style_municipality_1_0() {
            return {
                pane: 'pane_municipality_1',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(114,155,111,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_municipality_1');
        map.getPane('pane_municipality_1').style.zIndex = 401;
        map.getPane('pane_municipality_1').style['mix-blend-mode'] = 'normal';
        var layer_municipality_1 = new L.geoJson(json_municipality_1, {
            attribution: '',
            interactive: true,
            dataVar: 'json_municipality_1',
            layerName: 'layer_municipality_1',
            pane: 'pane_municipality_1',
            onEachFeature: pop_municipality_1,
            style: style_municipality_1_0,
        });
        bounds_group.addLayer(layer_municipality_1);
        map.addLayer(layer_municipality_1);

        function pop_city_2(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
                // mouseover: highlightFeature,
            });
            // var popupContent = '<table>\
            //         <tr>\
            //             <td colspan="2">' + (feature.properties['name_municip'] !== null ? autolinker.link(feature.properties['name_municip'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //         <tr>\
            //             <td colspan="2">' + (feature.properties['id_municip'] !== null ? autolinker.link(feature.properties['id_municip'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //         <tr>\
            //             <td colspan="2">' + (feature.properties['lat'] !== null ? autolinker.link(feature.properties['lat'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //         <tr>\
            //             <td colspan="2">' + (feature.properties['lot'] !== null ? autolinker.link(feature.properties['lot'].toLocaleString()) : '') + '</td>\
            //         </tr>\
            //     </table>';
            // layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_city_2_0() {
            return {
                pane: 'pane_city_2',
                radius: 4.0,
                opacity: 1,
                color: 'rgba(0,0,0,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 2.0,
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,255,255,1.0)',
                interactive: true,
            }
        }
        map.createPane('pane_city_2');
        map.getPane('pane_city_2').style.zIndex = 402;
        map.getPane('pane_city_2').style['mix-blend-mode'] = 'normal';
        var layer_city_2 = new L.geoJson(json_city_2, {
            attribution: '',
            interactive: true,
            dataVar: 'json_city_2',
            layerName: 'layer_city_2',
            pane: 'pane_city_2',
            onEachFeature: pop_city_2,
            pointToLayer: function(feature, latlng) {
                var context = {
                    feature: feature,
                    variables: {}
                };
                return L.circleMarker(latlng, style_city_2_0(feature));
            },
        });
        bounds_group.addLayer(layer_city_2);
        map.addLayer(layer_city_2);

        //Функция геокодирования, т.е. поиска
        var osmGeocoder = new L.Control.Geocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Search',
            title: 'Testing'
        }).addTo(map);
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
            .className += ' fa fa-search';
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
            .title += 'Search for a place';
        var baseMaps = {};
        L.control.layers(baseMaps, {
            '<img src="legend/city_2.png" /> city': layer_city_2,
            '<img src="legend/municipality_1.png" /> municipality': layer_municipality_1,
            "OSM Standard": layer_OSMStandard_0,
        }, {
            collapsed: false
        }).addTo(map);
        setBounds();
        var i = 0;
        layer_municipality_1.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['id_municip'] !== null ? String('<div style="color: #000000; font-size: 10pt; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['id_municip']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_municipality_1'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        var i = 0;
        layer_city_2.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['name_municip'] !== null ? String('<div style="color: #ffffff; font-size: 12pt; font-weight: bold; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['name_municip']) + '</div>' : ''), {
                permanent: true,
                offset: [-0, -16],
                className: 'css_city_2'
            });
            labels.push(layer);
            totalMarkers += 1;
            layer.added = true;
            addLabel(layer, i);
            i++;
        });
        resetLabels([layer_municipality_1, layer_city_2]);
        map.on("zoomend", function() {
            resetLabels([layer_municipality_1, layer_city_2]);
        });
        map.on("layeradd", function() {
            resetLabels([layer_municipality_1, layer_city_2]);
        });
        map.on("layerremove", function() {
            resetLabels([layer_municipality_1, layer_city_2]);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>