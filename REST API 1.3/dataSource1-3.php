<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Source API 1.3</title>
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
		$path = "/admin/1.3/rest/";

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
	
	$method="DataSource.GetInfo";
	
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
			echo "List of all Data Source details: <br/>";
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
	
	/*********************************/
	/*Get List of all Data source IDS*/
	/*********************************/
	
	$method="DataSource.GetIDs";
	
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
			echo "List of all Data Source IDs: <br/>";
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
	
	$method="DataSource.GetFileInfo";
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
	
	/***********************************************************************/
	/*Get List of existing Data source jobs IDs for specific Data source ID*/
	/***********************************************************************/
	
	$method="DataSource.GetFileIDs";
	
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
			echo "List of all Data Source jobs IDs: <br/>";
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
	
	$method="DataSource.BeginDataBlock";
	
	/*EXAMPLE request*/
	/*
	$data='{
		"blockName":"Test",
		"columnNames":[
			"Date",
			"Marketing Channel",
			"Marketing Channel Detail",
			"Checkouts"
		],
		"dataSourceID":"10",
		"endOfBlock":"endOfBlock",
		"reportSuiteID":"edirocks",
		"rows":[
				[
				"02/08/2015",
				"Display",
				"TEST2-Value1",
				"20"
				],
				[
				"02/08/2015",
				"Natural Search",
				"TEST2-Value2",
				"100"
				]
		]
	}';
	*/
	/*The example below if for a data source : OFFLINE CHANNEL
	https://marketing.adobe.com/resources/help/en_US/mchannel/c_overview_online_offline.html
	https://marketing.adobe.com/resources/help/en_US/mchannel/t_offline_data.html
	*/
	$data='{
		"blockName":"Test",
		"columnNames":[
			"Date",
			"Marketing Channel",
			"Marketing Channel Detail",
			"Checkouts"
		],
		"dataSourceID":"10",
		"endOfBlock":"endOfBlock",
		"reportSuiteID":"edirocks",
		"rows":[
				[
				"02/08/2015",
				"Display",
				"TEST2-Value1",
				"20"
				],
				[
				"02/08/2015",
				"Natural Search",
				"TEST2-Value2",
				"100"
				]
		]
	}';

	$rc=GetAPIData($method, $data);

	if ($rc->getStatusCode()==200) {
		$response=$rc->getWebResponse();
		$json=json_decode($response);
		if (strpos($response, "errors") !== true && strpos($json->status, "successfully") !== false) {
			echo "The data source file ID: is ".$json->fileID." <br/>";
			echo $response. "<br/>";
			$dataSourceFileID=$json->fileID;
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

	/*while (!$done && !$error) {
		sleep(30);
		echo "Checking <br/>";
		$method="DataSource.GetFileStatus";
		$data='{"dataSourceFileID":"'.$dataSourceFileID.'","reportSuiteID":"edirocks"}';

		$rc=GetAPIData($method, $data);

		if ($rc->getStatusCode()==200) {
			$response=$rc->getWebResponse();
			$json=json_decode($response);
			//If report is ready the data will be displayed
			if ($json->fileStatus->status == "Success") {
				$done=true;
				echo "<p>Your file has been uploaded and processed successfully</p>";
			}
			//if data not ready error message
			else if ($json->fileStatus->status !== "Success") {
				$error=false;
				echo "<p>You file is not ready</p>";
				echo "<p>" .$json->fileStatus->status. "</p>";
			}
		} else {
			$done=true;
			$error=true;
			echo "something went really wrong <br />";
			var_dump($rc->getInfo());
			echo "\n".$rc->getWebResponse();
		}
	}

	if ($error) {
		echo "report failed:<br />";
		echo $response;
	}*/

?>



</body>
</html>