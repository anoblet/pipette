<?php if (!isset($_REQUEST['ajax'])): ?>
    <html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">jQuery.noConflict();</script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <style>
            label {
                display: block;
            }
        </style>
    </head>
    <body class="container">
    <form id="form">
        <div class="row">
            <div class="col col-lg-4">
                <ul>
                    <li>
                        <?php
                        $temperatureStart = 15;
                        $temperatureStop = 30;
                        $temperatureStep = .5;
                        ?>
                        <label for="airPressure">Temperature:</label><select id="temperature" name="temperature">
                            <?php for ($x = $temperatureStart;
                                       $x <= $temperatureStop;
                                       $x = $x + $temperatureStep): ?>
                                <option>
                                    <?php echo $x; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </li>
                    <li>
                        <?php
                        $airPressureStart = 80;
                        $airPressureStop = 105;
                        $airPressureStep = 5;
                        ?>
                        <label for="airPressure">Air Pressure:</label><select id="airPressure" name="airPressure">
                            <?php for ($x = $airPressureStart;
                                       $x <= $airPressureStop;
                                       $x = $x + $airPressureStep): ?>
                                <option>
                                    <?php echo $x; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </li>
                    <?php
                    $fields = array(array("label" => "Nominal Volume", "name" => "nominalVolume"), array("label" => "Evaporation Loss", "name" => "evaporationLoss"));
                    $measures = 10;
                    ?>
                    <?php
                    foreach ($fields as $field): ?>
                        <li>
                            <label><?php echo $field['label']; ?></label><input type="text"
                                                                                name="<?php echo $field['name']; ?>"/>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col col-lg-4">
                <ul>
                    <li>Total mass in grams</li>
                    <ul>
                        <?php for ($x = 0;
                                   $x < $measures;
                                   $x++): ?>
                            <li><label>Measure #<?php echo $x; ?>: </label><input type="text"
                                                                                  name="mass[<?php echo $x; ?>]"/>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </ul>
            </div>
            <div class="col col-lg-4">
                <div id="output"></div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("#form input").on("change", function () {
                    jQuery("#output").load("?ajax", jQuery("#form").serialize());
                });
                jQuery("#form select").on("change", function () {
                    jQuery("#output").load("?ajax", jQuery("#form").serialize());
                });
            });
        </script>
    </form>
    </body>
    </html>
<?php else: ?>
    <?php

    $nominalVolume = $_REQUEST["nominalVolume"];
    $evaporationLoss = $_REQUEST["evaporationLoss"];

    $conversionRates = array("15" => array("80" => 1.0017, "85" => 1.0018, "90" => 1.0019, "95" => 1.0019, "100" => 1.0020, "101" => 1.0020, "105" => 1.0020
    ), "15.5" => array("80" => 1.0018, "85" => 1.0019, "90" => 1.0019, "95" => 1.0020, "100" => 1.0020, "101" => 1.0020, "105" => 1.0021
    ), "16" => array("80" => 1.0019, "85" => 1.0020, "90" => 1.0020, "95" => 1.0021, "100" => 1.0021, "101" => 1.0021, "105" => 1.0022
    ), "16.5" => array("80" => 1.0020, "85" => 1.0020, "90" => 1.0021, "95" => 1.0021, "100" => 1.0022, "101" => 1.0022, "105" => 1.0022
    ), "17" => array("80" => 1.0021, "85" => 1.0021, "90" => 1.0022, "95" => 1.0022, "100" => 1.0023, "101" => 1.0023, "105" => 1.0023
    ), "17.5" => array("80" => 1.0022, "85" => 1.0022, "90" => 1.0023, "95" => 1.0023, "100" => 1.0024, "101" => 1.0024, "105" => 1.0024
    ), "18" => array("80" => 1.0022, "85" => 1.0023, "90" => 1.0023, "95" => 1.0024, "100" => 1.0025, "101" => 1.0025, "105" => 1.0025
    ), "18.5" => array("80" => 1.0023, "85" => 1.0024, "90" => 1.0024, "95" => 1.0025, "100" => 1.0025, "101" => 1.0026, "105" => 1.0026
    ), "19" => array("80" => 1.0024, "85" => 1.0025, "90" => 1.0025, "95" => 1.0026, "100" => 1.0026, "101" => 1.0027, "105" => 1.0027
    ), "19.5" => array("80" => 1.0025, "85" => 1.0026, "90" => 1.0026, "95" => 1.0027, "100" => 1.0027, "101" => 1.0028, "105" => 1.0028
    ), "20" => array("80" => 1.0026, "85" => 1.0027, "90" => 1.0027, "95" => 1.0028, "100" => 1.0028, "101" => 1.0029, "105" => 1.0029
    ), "20.5" => array("80" => 1.0027, "85" => 1.0028, "90" => 1.0028, "95" => 1.0029, "100" => 1.0029, "101" => 1.0030, "105" => 1.0030
    ), "21" => array("80" => 1.0028, "85" => 1.0029, "90" => 1.0029, "95" => 1.0030, "100" => 1.0031, "101" => 1.0031, "105" => 1.0031
    ), "21.5" => array("80" => 1.0030, "85" => 1.0030, "90" => 1.0031, "95" => 1.0031, "100" => 1.0032, "101" => 1.0032, "105" => 1.0032
    ), "22" => array("80" => 1.0031, "85" => 1.0031, "90" => 1.0032, "95" => 1.0032, "100" => 1.0033, "101" => 1.0033, "105" => 1.0033
    ), "22.5" => array("80" => 1.0032, "85" => 1.0032, "90" => 1.0033, "95" => 1.0033, "100" => 1.0034, "101" => 1.0034, "105" => 1.0034
    ), "23" => array("80" => 1.0033, "85" => 1.0033, "90" => 1.0034, "95" => 1.0034, "100" => 1.0035, "101" => 1.0035, "105" => 1.0036
    ), "23.5" => array("80" => 1.0034, "85" => 1.0035, "90" => 1.0035, "95" => 1.0035, "100" => 1.0036, "101" => 1.0036, "105" => 1.0037
    ), "24" => array("80" => 1.0035, "85" => 1.0036, "90" => 1.0036, "95" => 1.0036, "100" => 1.0037, "101" => 1.0038, "105" => 1.0038
    ), "24.5" => array("80" => 1.0037, "85" => 1.0037, "90" => 1.0038, "95" => 1.0037, "100" => 1.0039, "101" => 1.0039, "105" => 1.0039
    ), "25" => array("80" => 1.0038, "85" => 1.0038, "90" => 1.0039, "95" => 1.0038, "100" => 1.0040, "101" => 1.0040, "105" => 1.0040
    ), "25.5" => array("80" => 1.0039, "85" => 1.0040, "90" => 1.0040, "95" => 1.0039, "100" => 1.0041, "101" => 1.0041, "105" => 1.0042
    ), "26" => array("80" => 1.0040, "85" => 1.0041, "90" => 1.0041, "95" => 1.0041, "100" => 1.0042, "101" => 1.0043, "105" => 1.0043
    ), "26.5" => array("80" => 1.0042, "85" => 1.0042, "90" => 1.0043, "95" => 1.0043, "100" => 1.0044, "101" => 1.0044, "105" => 1.0044
    ), "27" => array("80" => 1.0043, "85" => 1.0044, "90" => 1.0044, "95" => 1.0045, "100" => 1.0045, "101" => 1.0045, "105" => 1.0046
    ), "27.5" => array("80" => 1.0045, "85" => 1.0045, "90" => 1.0046, "95" => 1.0046, "100" => 1.0047, "101" => 1.0047, "105" => 1.0047
    ), "28" => array("80" => 1.0046, "85" => 1.0046, "90" => 1.0047, "95" => 1.0047, "100" => 1.0048, "101" => 1.0048, "105" => 1.0048
    ), "28.5" => array("80" => 1.0047, "85" => 1.0048, "90" => 1.0048, "95" => 1.0049, "100" => 1.0049, "101" => 1.0050, "105" => 1.0050
    ), "29" => array("80" => 1.0049, "85" => 1.0049, "90" => 1.0050, "95" => 1.0050, "100" => 1.0051, "101" => 1.0051, "105" => 1.0051
    ), "29.5" => array("80" => 1.0050, "85" => 1.0051, "90" => 1.0051, "95" => 1.0052, "100" => 1.0052, "101" => 1.0052, "105" => 1.0053
    ), "30" => array("80" => 1.0052, "85" => 1.0052, "90" => 1.0053, "95" => 1.0053, "100" => 1.0054, "101" => 1.0054, "105" => 1.0054
    )
    );

    $conversionRate = $conversionRates[$_REQUEST["temperature"]][$_REQUEST["airPressure"]];

    for ($i = 0; $i < count($_REQUEST["mass"]); $i++) {
        if (!isset($currentMass)) {
            $weights[] = ($_REQUEST["mass"][$i]) * 1000;
            $currentMass = $_REQUEST["mass"][$i];
        } else {
            $weights[] = ($_REQUEST["mass"][$i] - $currentMass) * 1000;
            $currentMass = $_REQUEST["mass"][$i];
        }
    }
    foreach ($weights as $weight) {
        $volumes[] = ($weight + $_REQUEST["evaporationLoss"]) * $conversionRate;
    }

    $meanVolume = array_sum($volumes) / count($volumes);

    $accuracy = $meanVolume - $_REQUEST["nominalVolume"];
    // $relativeAccuracy = 100 * ($accuracy / $_REQUEST["nominalVolume"]);
    ?>
    Weights:
    <?php var_dump($weights); ?>
    Volumes:
    <?php var_dump($volumes); ?>

    <ul>
        <li><label>Conversion Rate: </label><?php echo $conversionRate; ?></li>
        <li><label>Mean Volume /uL</label><?php echo $meanVolume; ?></li>
        <li><label>Accuracy /uL</label><?php echo $accuracy; ?></li>
        <!-- <li><label>Relative Accuracy %</label><?php echo $relativeAccuracy; ?></li> -->
        <li><label>Standard Deviation /uL</label></li>
        <li><label>Coefficient of Variation %</label></li>
    </ul>
<?php endif; ?>
