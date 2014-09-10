<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">jQuery.noConflict();</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style>

</style>
<?php
$temperatureStart = 15;
$temperatureStop = 30;
$temperatureStep = .5;
?>
<label for="airPressure">Temperature:</label><select id="temperature" name="temperature">
    <?php for ($x = $temperatureStart; $x < $temperatureStop; $x = $x + $temperatureStep): ?>
        <option>
            <?php echo $x; ?>
        </option>
    <?php endfor; ?>
</select>
<?php
$airPressureStart = 80;
$airPressureStop = 105;
$airPressureStep = 5;
?>
<label for="airPressure">Air Pressure:</label><select id="airPressure" name="airPressure">
    <?php for ($x = $airPressureStart; $x < $airPressureStop; $x = $x + $airPressureStep): ?>
        <option>
            <?php echo $x; ?>
        </option>
    <?php endfor; ?>
</select>
<?php
$fields = array(array("label" => "Conversion Factor", "name" => "conversionFactor"), array("label" => "Nominal Volume", "name" => "nominalVolume"), array("label" => "Conversion Factor", "name" => "conversionFactor"));
$measures = 10;
?>
<ul><?php
    foreach ($fields as $field): ?>
        <li>
            <label><?php echo $field['label']; ?></label><input type="text" name="<?php echo $field['name']; ?>"/>
        </li>
    <?php endforeach; ?>
    <?php for ($x = 0;
               $x < $measures;
               $x++): ?>
        <li><label>Measure #<?php echo $x; ?>: </label><input type="text"
                                                              name="evaporationLoss[<?php echo $x; ?>]"/></li>
    <?php endfor; ?>
</ul>
<?php
$output = array(array("label" => "Mean Volume/uL", "name" => "meanVolume"), array("label" => "Accuracy/uL", "name" => "accuracy"), array("label" => "Relative Accuracy (%)", "name" => "relativeAccuracy"), array("label" => "Standard Deviation /uL", "name" => "relativeAccuracy"), array("label" => "Coefficient of Variation", "name" => "variatioinCoefficient"));
?>
<ul>
    <?php foreach ($output as $field): ?>
        <li>
            <label><?php echo $field['label']; ?></label><input type="text" name="<?php echo $field['name']; ?>"/>
        </li>
    <?php endforeach; ?>
</ul>
<script type="application/javascript">
    var conversionRates = {
        "15":{
            "80":1.0017, "85": 1.0018, "90": 1.0019, "95": 1.0019, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },
        "15.5":{
            "80":1.0018, "85": 1.0019, "90": 1.0019, "95": 1.0019, "100": 1.0020, "101": 1.0020,  "105": 1.0021
        },
        "16":{
            "80":1.0019, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },
        "16.5":{
            "80":1.0020, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "17":{
            "80":1.0021, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "17.5":{
            "80":1.0022, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },
        "18":{
            "80":1.0022, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "18.5":{
            "80":1.0023, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "19":{
            "80":1.0024, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "19.5":{
            "80":1.0025, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "20":{
            "80":1.0026, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "20.5":{
            "80":1.0027, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "21":{
            "80":1.0028, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "21.5":{
            "80":1.0030, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "22":{
            "80":1.0031, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "22.5":{
            "80":1.0032, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "23":{
            "80":1.0033, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        }
        ,

        "23.5":{
            "80":1.0034, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "24":{
            "80":1.0035, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "24.5":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "25":{
            "80":1.0038, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "25.5":{
            "80":1.0039, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "26":{
            "80":1.0000, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "26.5":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },

        "27":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "27.5":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "28":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "28.5":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "29":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "29.5":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        },


        "30":{
            "80":1.0037, "85": 1.0020, "90": 1.0021, "95": 1.0021, "100": 1.0020, "101": 1.0020,  "105": 1.0020
        }
    };
</script>
<script type="text/javascript">
    jQuery(document).on("ready", function() {
        jQuery("[name='temperature']").on("change", function() {
            jQuery("[name='conversionFactor']").val(conversionRates[jQuery('#temperature').val()][jQuery('#airPressure').val()]);
        })
    })
    jQuery("#airPressure").on("change", function() {
        jQuery("[name='conversionFactor']").val(conversionRates[jQuery('#temperature').val()][jQuery('#airPressure').val()]);
    })
</script>