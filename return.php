<?php
/*==================================================================
 PayPal Express Checkout Call
 ===================================================================
*/
// Check to see if the Request object contains a variable named 'token'
$token = "";

if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];

}

// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.
if ( $token != "" )
{

	require_once ("web-inf/lib/core/paypal/paypalfunctions.php");

	/*
	'------------------------------------
	' Calls the GetExpressCheckoutDetails API call
	'
	' The GetShippingDetails function is defined in PayPalFunctions.jsp
	' included at the top of this file.
	'-------------------------------------------------
	*/


	$resArray = GetShippingDetails( $token );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING")
	{
		/*
		' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review
		' page
		*/
		$email 				= $resArray["EMAIL"]; // ' Email address of payer.
		$payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
		$payerStatus		= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
		$salutation			= $resArray["SALUTATION"]; // ' Payer's salutation.
		$firstName			= $resArray["FIRSTNAME"]; // ' Payer's first name.
		$middleName			= $resArray["MIDDLENAME"]; // ' Payer's middle name.
		$lastName			= $resArray["LASTNAME"]; // ' Payer's last name.
		$suffix				= $resArray["SUFFIX"]; // ' Payer's suffix.
		$cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
		$business			= $resArray["BUSINESS"]; // ' Payer's business name.
		$shipToName			= $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
		$shipToStreet		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
		$shipToStreet2		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET2"]; // ' Second street address.
		$shipToCity			= $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
		$shipToState		= $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
		$shipToCntryCode	= $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code.
		$shipToZip			= $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
		$addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal
		$invoiceNumber		= $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
		$phonNumber			= $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one.
	//	print_r($resArray); // After review
		echo "<br>";


		$resConfirmArray = ConfirmPayment ( $resArray["AMT"] );
		if($resConfirmArray["PAYMENTINFO_0_PAYMENTSTATUS"]=="Completed"){


		}
		echo "<br>";
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}

function  getglobalsetting(){

	require_once('web-inf/lib/coreconfig/public_dbconfig.php');

		$db_config = $GLOBALS['currentApp']['dbconfig'];

		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db("a0222211743", $con);

		$email = $_GET["email"];

		$sql = "select * from cms_website_global_setting";

		$result = mysql_query($sql);

		$setting = array();

		while($row = mysql_fetch_array($result)){

			$setting[0]["API_UserName"] = $row["API_UserName"];
			$setting[0]["API_Password"] = $row["API_Password"];
			$setting[0]["API_Signature"] = $row["API_Signature"];
			$setting[0]["SandboxFlag"] = $row["SandboxFlag"];
		}

		mysql_close($con);

		return $setting;



}

?>
