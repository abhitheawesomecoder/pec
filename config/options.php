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
 
return array(

    'paypalmode' => 'sandbox',   // sandbox or live
    'paypalapiusername' => 'paypalusername.gmail.com', //PayPal API Username
    'paypalapipassword' => '1363885439', //Paypal API password
    'paypalapisignature'=>'AuuWdB41aSeqUMYLoM29Evs51H57AK9OIxcAQqwMYVDyu7hk55ohtSIc',  //Paypal API Signature
    'paypalcurrencycode'=>'USD',    //Paypal Currency Code
    'paypalreturnurl'=>'http://yourwebsite.com/process',     //Point to process.php page
    'paypalcancelurl'=>'http://yourwebsite.com/cancel'   //Cancel URL if user clicks cancel
);