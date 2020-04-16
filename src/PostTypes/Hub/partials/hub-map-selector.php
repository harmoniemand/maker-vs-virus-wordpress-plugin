<?php global $post; ?>

<?php $hub_lat = get_post_meta($post->ID, 'hub_lat', true); ?>
<?php $hub_long = get_post_meta($post->ID, 'hub_long', true); ?>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

<style>
    #mapid {
        height: 60vh;
    }
</style>


<section id="map" class="container mt-5">
    <div class="row">
        <div class="col" id="hub-info">
            <h3>
        </div>
        <div class="col">
            <div id="mapid"></div>
        </div>
    </div>
</section>


<?php
$hubs = get_posts(array(
    'post_type'         => 'mvv_hub',
    'posts_per_page'    =>  -1,
    'orderby'           => 'title',
    'order'              => 'ASC'
));

$other_areas_str = "";
foreach ($hubs as $hub) :
    if ($hub->ID != $post->ID) {
        $other_hub_areas = get_post_meta($hub->ID, 'hub_areas', true);
        $areas = array_filter(explode(",", $other_hub_areas));
        foreach ($areas as $area) {
            $other_areas_str .= "'" . trim($area) . "',";
        }
    }
endforeach;

$other_areas_str = trim($other_areas_str, ",");
?>



<script>
    let myAreas = [];
    let otherAreas = [<?php echo $other_areas_str; ?>];

    function whenClicked(e, feature, layer) {
        // e = event
        console.log(feature);

        if (myAreas.find(elem => elem.DEBKG_ID == feature.properties.DEBKG_ID)) {
            myAreas = myAreas.filter(elem => elem.DEBKG_ID != feature.properties.DEBKG_ID);

            layer.setStyle({
                weight: 1,
                color: '#fff',
                dashArray: '',
                fillOpacity: 0.2,
                fillColor: 'rgb(52, 155, 235)'
            });
            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
        } else {
            myAreas.push({
                DEBKG_ID: feature.properties.DEBKG_ID,
                layer: layer
            });

            layer.setStyle({
                weight: 1,
                color: '#fff',
                dashArray: '',
                fillOpacity: 0.2,
                fillColor: 'green'
            });
            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
        }

        console.log(myAreas);


        let strAreas = "";

        myAreas.forEach(m => strAreas += m.DEBKG_ID + ",");

        $('#hub_areas').val(strAreas);


        // info.update(layer.feature.properties.availability);
    }

    function onEachFeature(feature, layer) {
        //bind click
        layer.on({
            click: (e) => {
                whenClicked(e, feature, layer);
            }
        });
    }

    function polyStyle(feature) {
        console.log(feature);
    }

    var counties = $.ajax({
        url: "<?php echo plugin_dir_url(__FILE__) ?>/de-areas.geojson",
        dataType: "json",
        success: console.log("County data successfully loaded."),
        error: function(xhr) {
            alert(xhr.statusText)
        }
    });

    $.when(counties).done(() => {
        var map = L.map('mapid').setView([<?php echo $hub_lat ?>, <?php echo $hub_long ?>], 10);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 24,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiaGFybW9uaWVtYW5kIiwiYSI6ImNqYnMweG9rOTB5NGwycW1mZ3M1M3g2bGkifQ.BWxSwxb35Ed-MfVNkquz2w'
        }).addTo(map);


        <?php
        $areas = array_filter(explode(",", $hub_areas));
        $areas_str = "";
        foreach ($areas as $area) {
            $areas_str .= "'" . trim($area) . "',";
        }
        $areas_str = trim($areas_str, ",");
        ?>
        let areas = [<?php echo $areas_str; ?>];
        console.log(areas);

        counties.responseJSON.features.forEach(feature => {

            let color = 'rgb(52, 155, 235)';

            if (otherAreas.includes(feature.properties.DEBKG_ID)) {
                color = 'red';
            }
            
            if (areas.find(m => m == feature.properties.DEBKG_ID)) {
                color = 'green';
            }


            let layer = L.geoJSON(feature, {
                onEachFeature: onEachFeature,
                style: {
                    weight: 1,
                    color: '#fff',
                    dashArray: '',
                    fillOpacity: 0.2,
                    fillColor: color
                }
            }).addTo(map);

            if (areas.includes(feature.properties.DEBKG_ID)) {
                areas.forEach(a => {
                    myAreas.push({
                        DEBKG_ID: feature.properties.DEBKG_ID,
                        layer: layer
                    });
                });
            }
        });


        L.marker([<?php echo $hub_lat ?>, <?php echo $hub_long ?>]).addTo(map);
    });
</script>