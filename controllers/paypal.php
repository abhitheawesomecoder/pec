<?php
/**
 * --------------------------------------------------------------------------
 * Paypal-express-checkout
 * --------------------------------------------------------------------------
 *
 * Paypal express chekout, a paypal express checkout bundle for use with the Laravel Framework.
 *
 * @package  Paypal-express-checkout
 * @version  1.1.1
 * @author   Abhishek Kumar <abhitheawesomecoder@gmail.com>
 * @link     https://github.com/abhi/pec
 */

class Pec_Paypal_Controller extends Controller{
    
    public $restful = true;
    
    public function get_index()
    {
       
	$token = Input::get('token');
	$playerid = Input::get('PayerID'); 
	
        if(isset($token)&&isset($playerid))
        {
	//get session variables
	$ItemPrice 		= $_SESSION['itemprice'];
	$ItemTotalPrice = $_SESSION['totalamount'];
	$ItemName 		= $_SESSION['itemName'];
	$ItemNumber 	= $_SESSION['itemNo'];
	$ItemQTY 		=$_SESSION['itemQTY'];
        $PayPalCurrencyCode = Config::get('cartify::options.paypalcurrencycode');
        $PayPalReturnURL = Config::get('cartify::options.paypalreturnurl');
        $PayPalCancelURL = Config::get('cartify::options.paypalcancelurl');
        $PayPalApiUsername = Config::get('cartify::options.paypalapiusername');
        $PayPalApiPassword = Config::get('cartify::options.paypalapipassword');
        $PayPalApiSignature = Config::get('cartify::options.paypalapisignature');
        $PayPalMode = Config::get('cartify::options.paypalmode');
	
	$padata = 	'&TOKEN='.urlencode($token).
						'&PAYERID='.urlencode($playerid).
						'&PAYMENTACTION='.urlencode("SALE").
						'&AMT='.urlencode($ItemTotalPrice).
						'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	
	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{
			echo '<h2>Success</h2>';
			echo 'Your Transaction ID :'.urldecode($httpParsedResponseAr["TRANSACTIONID"]);
			
				/*
				//Sometimes Payment are kept pending even when transaction is complete. 
				//May be because of Currency change, or user choose to review each payment etc.
				//hence we need to notify user about it and ask him manually approve the transiction
				*/
				
				if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"])
				{
					echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
				}
				elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"])
				{
					echo '<div style="color:red">Transaction Complete, but payment is still pending! You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
				}
			

			echo '<br /><b>Stuff to store in database :</b><br /><pre>';

				$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
				$nvpStr = "&TRANSACTIONID=".$transactionID;
				$paypal= new MyPayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
					
					
					
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';
				} else  {
					echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';

				}
	
	}else{
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
	}
        
        }
        else        
          return View::make('pec::paypal');
    }
    public function post_index()
    {
        
	$ItemName = Input::get('itemname'); //Item Name
	$ItemPrice = Input::get('itemprice');  //Item Price
	$ItemNumber = Input::get('itemnumber');  //Item Number
	$ItemQty = Input::get('itemQty');  // Item Quantity
	$ItemTotalPrice = ($ItemPrice*$ItemQty); //(Item Price x Quantity = Total) Get total amount of product; 
        $PayPalCurrencyCode = Config::get('cartify::options.paypalcurrencycode');
        $PayPalReturnURL = Config::get('cartify::options.paypalreturnurl');
        $PayPalCancelURL = Config::get('cartify::options.paypalcancelurl');
        $PayPalApiUsername = Config::get('cartify::options.paypalapiusername');
        $PayPalApiPassword = Config::get('cartify::options.paypalapipassword');
        $PayPalApiSignature = Config::get('cartify::options.paypalapisignature');
        $PayPalMode = Config::get('cartify::options.paypalmode');
	//Data to be sent to paypal
	$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				'&PAYMENTACTION=Sale'.
				'&ALLOWNOTE=1'.
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				'&PAYMENTREQUEST_0_AMT='.urlencode($ItemTotalPrice).
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice). 
				'&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
				'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
				'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
				'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
				'&AMT='.urlencode($ItemTotalPrice).				
				'&RETURNURL='.urlencode($PayPalReturnURL ).
				'&CANCELURL='.urlencode($PayPalCancelURL);	
		
		//We need to execute the "SetExpressCheckOut" method to obtain paypal token
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
		//Respond according to message we receive from Paypal
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
				
				// If successful set some session variable we need later when user is redirected back to page from paypal. 
				$_SESSION['itemprice'] =  $ItemPrice;
				$_SESSION['totalamount'] = $ItemTotalPrice;
				$_SESSION['itemName'] =  $ItemName;
				$_SESSION['itemNo'] =  $ItemNumber;
				$_SESSION['itemQTY'] =  $ItemQty;
				
				if($PayPalMode=='sandbox')
				{	
					$paypalmode 	=	'.sandbox';
				}
				else
				{
					$paypalmode 	=	'';
				}
				//Redirect user to PayPal store with Token received.
			 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				//header('Location: '.$paypalurl);
                                return Redirect::to($paypalurl);
                                var_dump($paypalurl);
			
		}else{
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
		}
        
    }
    
    
    
    
}