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
    <link rel="stylesheet" href="css/L.Control.Locate.min.css">
    <link rel="stylesheet" href="css/qgis2web.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <style>
        html,
        body,
        #map {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
    </style>
    <title></title>
</head>

<body>
    <div id="map">
    </div>
    <script src="js/qgis2web_expressions.js"></script>
    <script src="js/leaflet.js"></script>
    <script src="js/L.Control.Locate.min.js"></script>
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="js/leaflet.pattern.js"></script>
    <script src="js/leaflet-hash.js"></script>
    <script src="js/Autolinker.min.js"></script>
    <script src="js/rbush.min.js"></script>
    <script src="js/labelgun.min.js"></script>
    <script src="js/labels.js"></script>
    <script src="data/municipality_1.js"></script>
    <script src="data/city_2.js"></script>
    <script>
        var highlightLayer;

        //функция, которая отвечает за изменения цвета объекта при наведении на него мышью
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
                highlightLayer.setStyle({
                    color: '#ffff00', //желтый цвет
                });
            } else {
                highlightLayer.setStyle({
                    fillColor: '#ffff00', //желтый цвет
                    fillOpacity: 1
                });
            }
        }
        var map = L.map('map', {
            zoomControl: true,
            maxZoom: 20,
            minZoom: 1
        }).fitBounds([
            [50.55261705447391, 50.84276840881497],
            [57.64154347898654, 64.2033728815451]
        ]);
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        var autolinker = new Autolinker({
            truncate: {
                length: 30,
                location: 'smart'
            }
        });
        L.control.locate({
            locateOptions: {
                maxZoom: 19
            }
        }).addTo(map);
        var bounds_group = new L.featureGroup([]);

        function setBounds() {}
        map.createPane('pane_OSMStandard_0');
        map.getPane('pane_OSMStandard_0').style.zIndex = 400;
        var layer_OSMStandard_0 = L.tileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            pane: 'pane_OSMStandard_0',
            opacity: 1.0,
            attribution: '<a href="https://www.openstreetmap.org/copyright">© OpenStreetMap contributors, CC-BY-SA</a>',
            minZoom: 1,
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
            // layer.bindPopup(popupContent, {
            //     maxHeight: 400
            // });
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