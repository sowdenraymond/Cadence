<?php
//This Script was written for JD Edwards Tools 9.2.5.2
// Server Manager URL - to check if Server Manager is reachable
//Instance Name
$instanceName = 'JDEENT01';
$urlMain = 'http://jdedep01:8999/manage/';
// Server Manager REST-API URL
$urlREST = 'http://jdedep01:8999/manage/mgmtrestservice/entserverprocessmetric?instanceName=' . $instanceName;
// Instance to collect status from
//$data = '{"instanceName": "' . $instanceName . '"}';
//Authentication Information
$authentication = 'Authorization: Basic amRlX2FkbWluOkYzJCFTTkd4OVBAY19wU0c=';
//Set Content Type
$contType = 'Content-Type: application/json';



//Security Kernel (Type 4)
//Call Object Kernel (Type 6)
$COB_count = 14;
//$COB_Count = 14;
//SAW Kernel (Type 9)
//Scheduler Kernel (Type 10)
//Package Build Kernel (Type 11)
//UBE Subsystem Kernel (Type 12)
//Workflow Kernel (Type 13)
//Queue Kernel (Type 14)
//XML Trans Kernel (Type 15)
//XML List Kernel (Type 16)
//XML Dispatch Kernel (Type 22)
//XTS Kernel (Type 23)
//XML Service Kernel (Type 24)
//Metadata Kernel (Type 30)
//XML Publisher Kernel (Type 31)
//Server Manager Kernel (Type 32)
//Textsearch Kernel (Type 34)



// Server Manager URL - to check if Server Manager is reachable
$CallUrlMain = $urlMain;

//Check if Server Manager URL is reachable
$ch = curl_init($CallUrlMain);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $MainResponse = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode>=200 && $httpcode<300){

                        // Server Manager REST-API URL
                        $CallUrlREST = $urlREST;
                        // Initializes a new cURL session
                        $curl = curl_init($CallUrlREST);
                        // Set the CURLOPT_RETURNTRANSFER option to true
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        // Set the CURLOPT_POST option to true for POST request
                        //curl_setopt($curl, CURLOPT_POST, true);
                        // Set the request data as JSON using json_encode function
                        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        // Set custom headers for RapidAPI Auth and Content-Type header
                        curl_setopt($curl, CURLOPT_HTTPHEADER, [
                          $authentication,
                          $contType
                        ]);
                        // Execute cURL request with all previous settings
                        $RestResponse = curl_exec($curl);
                        // Close cURL session
                        curl_close($curl);
                        //echo $response . PHP_EOL;


                        // Decode JSON data into PHP associative array format
                        $arr = json_decode($RestResponse, true);
                        //echo var_dump($arr);
                        // Call the function and print all the values
                        //$result = printValues($arr);


                        $count = 1;
						foreach ($arr['entServerProcessMetricDetail'] as $detail) {
						  if($detail["generalInformation"]["processName"] == "CALL OBJECT KERNEL"){
							  //0 myservice count1=42|count2=21;23;27|count3=73 OK - This is my custom output
							   echo "0 TCI_Call_Object_Kernel_" . $count . " total_requests=" . $detail["generalInformation"]["messagesReceived"] . "|outstanding_requests="  . $detail["generalInformation"]["outstandingRequests"] . "|memory="  . $detail["generalInformation"]["memory"] . "|cpu="  . $detail["generalInformation"]["cpu"] . "|threads="  . $detail["generalInformation"]["threads"] . " OK - This is my custom output\n"; 
							    $count++;
						  }
						}
						while($count <= $COB_count) {
								echo "0 TCI_Call_Object_Kernel_$count - Not yet spawned\n";
								$count++;
							}



                }else {
                        //echo "Server Manager - Not In Running State";
                        echo "2 TCI_Server_Manager JASSM=0 " . $instanceName . " - CRITICAL - Server Manager - Not In Running State";
                }

dvdsvvdsDVVDv


?>

