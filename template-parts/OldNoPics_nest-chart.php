<?php
/**
 * The template for displaying a nest chart
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
?>
<?php

    /* Include the `../src/fusioncharts.php` file that contains functions to embed the charts.*/
    include("integrations/php/samples/includes/fusioncharts.php");
?>
  <html>

    <head>
      <title>FusionCharts | Simple FusionTime Chart</title>
        <!-- FusionCharts Library -->
        <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    </head>

    <body>

<?php

/*echo getcwd();  returns: public_html*/
       $data = file_get_contents("NestData/JSON_00000000_00214.JSON");
      $schema =
      '[{
            "name": "Time",
            "type": "date",
            "format": "%m/%d/%Y %H:%M"
        }, {
            "name": "Barometer",
            "type": "number"
        }, {
            "name": "Humidity (%)",
            "type": "number"
        }, {
            "name": "Temperature (degC)",
            "type": "number"
        }, {
            "name": "Light",
            "type": "number"
        }, {
            "name": "Motion (secs per min of motion)",
            "type": "number"
        }]';

			$fusionTable = new FusionTable($schema, $data);
			$timeSeries = new TimeSeries($fusionTable);

			$timeSeries->AddAttribute("caption", "{
								text: 'Black-Capped Chickadee'
							  }");

			$timeSeries->AddAttribute("subcaption", "{
											text: 'Bellevue, WA USA 2020'
										  }");

       $timeSeries->AddAttribute("yAxis", '[
             	{plot: {
            		value: "Barometer",
            		type: "line"
            		},
            		min: 5050,
            		max: 5150
            	},
            	{plot: {
            		value: "Humidity (%)",
            		type: "line"
            		}
            	},
            	{plot: {
            		value: "Temperature (degC)",
            		type: "line"
            		}
            	},
            	{plot: {
            		value: "Light",
            		type: "line"
            		}
            	},
            	{plot: {
            		value: "Motion (secs per min of motion)",
            		type: "column"
            		}
            	}
           ]');

			// chart object
			$Chart = new FusionCharts("timeseries", "MyFirstChart" , "95%", "900", "chart-container", "json", $timeSeries);

			// Render the chart
			$Chart->render();

?>

<!--        <h3>Plotting two variables (measures)</h3>-->
        <div id="chart-container">Chart will render here!</div>
        <br/>
        <br/>
        <a href="../index.php">Go Back</a>
    </body>

    </html>
<div class="one-nest-chart">
</div><!--  -->
