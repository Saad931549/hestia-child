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
<?php 

function getImageNames() {
	try
	{
		//$cDirName = realpath('.');
		//$cDirName = str_replace('\\', '/', $cDirName);
		$cDirName = '/home/customer/www/wildlifedatascience.org/public_html';
		$trgImgDir = $cDirName . '/NestImgs';
		
		
		$imgNames = []; 

		$dit = new directoryIterator($trgImgDir);
		while( $dit->valid()) {
			if( !$dit->isDot() && !$dit->isDir() ) {
				$flname = $dit->getFilename();
				$flpath = $dit->getPathName();
				$ext = pathinfo($flpath, PATHINFO_EXTENSION);
				if(!empty($ext) && $ext == 'jpg') {
					$tmpNameParts = explode('_', $flname);
					if(!empty($tmpNameParts) && count($tmpNameParts) == 3 && strlen($tmpNameParts[1]) == 12) {
						$dtkey = substr($tmpNameParts[1], 0, 12);
						if(!isset($imgNames[$dtkey])) {
							$imgNames[$dtkey] = $flname;
						}
					}
				}
			}
			$dit->next();
		}
	}
	catch(Exception $e)
	{
	}
	
	return $imgNames;
}


$nestImgNames = getImageNames();
if(empty($nestImgNames)) {
	$nestImgNames = [];
}

$nestImgKeys = array_keys($nestImgNames);
if(empty($nestImgKeys)) {
	$nestImgKeys = [];
}

//print_r($nestImgNames);

?>
<!-- FusionCharts Library -->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/fusioncharts.js"></script>
<script language="javascript">
var nestImgNms = <?php echo json_encode($nestImgNames); ?>;
var nestImgKeys = <?php echo json_encode($nestImgKeys); ?>;

var lded = false;
function appendLeadingZeroes(n){
	if(n <= 9){
		return "0" + n;
	}
	return n;
}

function formatDate(dt){
	let formatted_date = dt.getFullYear() + "-" + appendLeadingZeroes(dt.getMonth() + 1) + "-" + appendLeadingZeroes(dt.getDate()) + " " + appendLeadingZeroes(dt.getHours()) + ":" + appendLeadingZeroes(dt.getMinutes()) + ":" + appendLeadingZeroes(dt.getSeconds());
	return formatted_date;
}

function formatDateFile(dt){
	let formatted_date = dt.getFullYear().toString().substr(-2) + appendLeadingZeroes(dt.getMonth() + 1) + appendLeadingZeroes(dt.getDate()) + appendLeadingZeroes(dt.getHours()) + appendLeadingZeroes(dt.getMinutes()) + appendLeadingZeroes(dt.getSeconds());
	return formatted_date;
}

function formatDateAlt(str){
	if(str == '') {
		return '';
	}
	str = str + "";
	let ststr = '20' + str.substring(0, 2) + '-' + str.substring(2, 4) + '-' + str.substring(4, 6) + ' ' + str.substring(6, 8) + ':' + str.substring(8, 10) + ':' + str.substring(10, 12) ; 
	let dt = new Date(ststr);
	let formatted_date = dt.toLocaleString();
	return formatted_date;
}

var dataCrosslineRollOver = function(sDate, eDate) {
	if(lded) {
		showNestThumbImg(sDate, eDate);
	}
};
</script>

<style type="text/css">
html body {
	font-family:Arial, Helvetica, sans-serif;
}

.chartDiv {
	display:inline-block;
	width:59%;
	float:left;
}
.nestImageDiv {
	display:inline-block;
	width:40%;
	float:right;
	text-align:center;
	background-color:#fff;
	padding:8px;
}

#nestImg {
	width:100%;
	height:auto;
}
#nestThumb {
	width:100%;
	height:auto;
}

#chartinfo {
	font-size: 14px;
	padding: 4px 4px 0 4px;
}

@media only screen and (max-width: 768px) {
  .chartDiv {
	  width:100%;
	  display:block;
	  float:none;
  }
  .nestImageDiv {
	  width:50%;
	  display:block;
	  float:none;
	  margin: 0 auto;
  }
}
</style>

<?php

      $data = file_get_contents('NestData/JSON_00000000_00214.JSON');
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
					$Chart = new FusionCharts("timeseries", "MyFirstChart" , "98%", "900", "chart-container", "json", $timeSeries);

			// Render the chart
			$Chart->render();

?>


<div class="nestImageDiv">
	<img src="<?php echo get_site_url(); ?>/NestImgs/placeholder.jpg" alt="" id="nestImg">
	<img src="" alt="" id="nestThumb">
    <label id="chartinfo" data-date="">...</label>
</div>

<div class="chartDiv">
    <div id="chart-container">Chart will render here!</div>
</div>

<div style="clear:both"></div>


<br/>
<br/>
<a href="../index.php">Go Back</a>
    


<script type="text/javascript">

function showNestImg(dt) {
	var pthPrefix = '<?php echo get_site_url(); ?>/NestImgs/';
	if(dt == '') {
		return false;
	}
	
	var formatted_date = formatDate(dt);
	var dtm = formatDateFile(dt);
	
	if((nestImgNms) && (nestImgNms[dtm])) {
		jQuery('#chartinfo').html(formatted_date);
		jQuery('#nestImg').attr('src', pthPrefix + nestImgNms[dtm]);
	}
	
	//console.log(dtm);
	return false;	
	
}

function showNestThumbImg(sdt, edt) {
	var pthPrefix = '<?php echo get_site_url(); ?>/NestImgs/';
	if(sdt == '' || edt == '') {
		return false;
	}
	
	var formatted_date_sdt = formatDate(sdt);
	var sdtm = formatDateFile(sdt);
	var edtm = formatDateFile(edt);
	
	if(formatted_date_sdt != jQuery('#chartinfo').attr('data-date')) {
		let imgKeys = nestImgKeys.filter(val => (val >= sdtm && val < edtm) );
		if(imgKeys.length > 0) {
			jQuery('#nestThumb').attr('src', pthPrefix + 'thumbs/' + imgKeys[0] + '.jpg');
			jQuery('#nestThumb').show();
			jQuery('#nestImg').hide();
			formatted_date = formatDateAlt(imgKeys[0]);
			jQuery('#chartinfo').attr('data-date', formatted_date_sdt);
			jQuery('#chartinfo').html(formatted_date);
			var mainImg = (pthPrefix + nestImgNms[imgKeys[0]]);
			//console.log(mainImg);
			jQuery('#nestImg').attr("src", "");
			jQuery('#nestImg')
				.on('load', function() { 
					jQuery(this).show();
					jQuery('#nestThumb').hide();
				})
				.on('error', function() { console.log("error loading image"); })
				.attr("src", mainImg)
			;
			
		}
	}
	
	return false;	
	
}


lded = true;



</script>


    
<?php /*?><div class="one-nest-chart">
</div><?php */?><!--  -->
