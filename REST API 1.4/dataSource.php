<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Source API 1.4</title>
</head>
<body>

<?php
	include_once("SimpleRestClient.class.php");
	$error = false; 
	$done = false;
	
	function GetAPIData($method, $data) {
		/*$username = '[WEB SERVICES USERNAME]'; 
		$secret = '[WEB SERVICES PASSWORD]';
		Both can be found under ADMIN >> COMPANY SETTINGS >> WEB SERVICES (only users with web services right will be listed in the table)
		
		*/
		
		$username = '[WEB SERVICES USERNAME]';
		$secret = '[WEB SERVICES PASSWORD]';
		$nonce = md5(uniqid(php_uname('n'), true));
		$nonce_ts = date('c');
		$digest = base64_encode(sha1($nonce.$nonce_ts.$secret));
		/*$server possible values :
			api.omniture.com - San Jose
			api2.omniture.com - Dallas
			api3.omniture.com - London
			api4.omniture.com - Singapore
			api5.omniture.com - Pacific Northwest
		*/
		$server = "https://api.omniture.com";
		$path = "/admin/1.4/rest/";

		$rc=new SimpleRestClient();
		$rc->setOption(CURLOPT_HTTPHEADER, array("X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$digest\", Nonce=\"$nonce\", Created=\"$nonce_ts\""));

		$rc->postWebRequest($server.$path.'?method='.$method, $data);

		return $rc;
	}
	
	
	
	/*Build you REST requests. For example of requests go to API explorer : https://marketing.adobe.com/developer/api-explorer*/
	
	/*Check documentation*/
	/***********************************************************************************/
	/*Get List of existing Data source implementation created for specific report suite*/
	/***********************************************************************************/
	
	$method="DataSources.Get";
	
	/*EXAMPLE request*/
	/*
		$data='{
			"reportSuiteID":"edirocks"
			}';
	*/
	$data='{
			"reportSuiteID":"[REPORT SUITE ID]"
			}';

	$rc=GetAPIData($method, $data);

	if ($rc->getStatusCode()==200) {
		$response=$rc->getWebResponse();
		$json=json_decode($response);
		if (strpos($response, "Bad Request") !== true) {
			echo "List of all Data Source: <br/>";
			echo $response. "<br/>";
		}
		else {
			$error=true;
			echo "not queued - <br />";
		}
	} else {
		$error=true;
		echo "something went really wrong <br />";
		var_dump($rc->getInfo());
		echo "\n".$rc->getWebResponse();
	}
	
	echo "------------------------------------------------------------- <br/>";
	echo "------------------------------------------------------------- <br/>";
	
	/*******************************************************************/
	/*Get List of existing Data source jobs for specific Data source ID*/
	/*******************************************************************/
	
	$method="DataSources.GetJobs";
	
	/*EXAMPLE request*/
	/*
		$data='{
			"dataSourceID":"3",
			"reportSuiteID":"edirocks"
			}';
	*/
	$data='{
			"dataSourceID":"[DATA SOURCE ID]",
			"reportSuiteID":"[REPORT SUITE ID]"
			}';

	$rc=GetAPIData($method, $data);

	if ($rc->getStatusCode()==200) {
		$response=$rc->getWebResponse();
		$json=json_decode($response);
		if (strpos($response, "Bad Request") !== true) {
			echo "List of all Data Source jobs: <br/>";
			echo $response. "<br/>";
		}
		else {
			$error=true;
			echo "not queued - <br />";
		}
	} else {
		$error=true;
		echo "something went really wrong <br />";
		var_dump($rc->getInfo());
		echo "\n".$rc->getWebResponse();
	}
	
	echo "------------------------------------------------------------- <br/>";
	echo "------------------------------------------------------------- <br/>";
	
	/******************************************/
	/*Import Data for Offline Data Source Data*/
	/******************************************/
	
	$method="DataSources.UploadData";
	
	/*EXAMPLE request*/
	/*
		$data='{
			"columns":[
				"Date",
				"Marketing Channel",
				"Marketing Channel Detail",
				"Checkouts"
			],
			"dataSourceID":"10",
			"finished":"true",
			"jobName":"Test new 3",
			"reportSuiteID":"edirocks",
			"rows":[
				[
					"02/08/2015",
					"Display",
					"TEST7-Value1",
					"20"
				],
				[
					"02/08/2015",
					"Display",
					"TEST7-Value2",
					"20"
				],
				[
					"02/08/2015",
					"Display",
					"TEST7-Value3",
					"20"
				]
			]
	}';
	*/
	/*The example below if for a data source : OFFLINE CHANNEL
	https://marketing.adobe.com/resources/help/en_US/mchannel/c_overview_online_offline.html
	https://marketing.adobe.com/resources/help/en_US/mchannel/t_offline_data.html
	*/
	$data='{
			"columns":[
				"Date",
				"Marketing Channel",
				"Marketing Channel Detail",
				"Checkouts"
			],
			"dataSourceID":"10",
			"finished":"true",
			"jobName":"Test new 3",
			"reportSuiteID":"edirocks",
			"rows":[
				[
					"02/08/2015",
					"Display",
					"TEST7-Value1",
					"20"
				],
				[
					"02/08/2015",
					"Display",
					"TEST7-Value2",
					"20"
				],
				[
					"02/08/2015",
					"Display",
					"TEST7-Value3",
					"20"
				]
			]
	}';

	$rc=GetAPIData($method, $data);

	if ($rc->getStatusCode()==200) {
		$response=$rc->getWebResponse();
		$json=json_decode($response);
		if ($response == true) {
			echo "Data source data upload successful <br/>";
			echo $response. "<br/>";
		}
		else {
			$error=true;
			echo "not queued - <br />";
		}
	} else {
		$error=true;
		echo "something went really wrong <br />";
		var_dump($rc->getInfo());
		echo "\n".$rc->getWebResponse();
	}

?>



</body>
</html>