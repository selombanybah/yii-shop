<?php
/**
 *
 * For all your programming needs contact:
 *
 *               http://www.geniegate.com/es_contact.php
 *
 *            Friendly -/- Decent Rates -/- Decent Quality  
 *
 *        Java -/- Perl -/- PHP -/- XML -/- Databases -/- UNIX  
 *
 * This is a base-class IPN handler for PayPal. It does nothing on it's own
 * except provide a skeleton class to be derived from. It's not GenieGate
 * specific in any way. It provides a more "object oriented" approach to
 * paypal IPN using handlers. This generic approach makes it usable 
 * by GenieGate, but can be also used anywhere someone requires paypal 
 * support. (Shopping carts, download areas, etc..)
 *
 * The general idea is to inherit from this class, provide the methods
 * you are interested in. (such as check_txn_id, check_email, check_amount)
 *
 * Populate your class with configuration, database connections, or other
 * resources/initialization as required in your unique situation.
 *
 * In general, you shouldn't modify this file. Create your own class file 
 * and *inherit* from this one, (using extends) 
 *
 * Call processIPN() to actually process a paypal IPN. This will invoke
 * your custom, application specific methods. The return value from 
 * proceessIPN() will < 0 on failure. If it is <0 use the errstr() to
 * report the cause. (and/or override logit() to store the logs)
 *
 *         -/- Testing and debugging -/-
 * 
 * It provides debugging support in which to test your "handler class" by
 * way of a generic form.
 *
 * The debug support also allows one to use a file in place of the response 
 * from paypal's web site. This is useful for running lots of tests that 
 * aren't really paypal centric, or testing on an intranet without a public 
 * IP number prior to hammering paypals web site. (although you should use 
 * paypals web site to do your final testing)
 *
 * Call the log_file() method with a filename to log diagnostic information. 
 * Nothing is logged unless you do this. (and/or override logit() to send
 * this information in email, etc..)
 * 
 *
 *        -/- Legal dogma and fine print. -/-
 *
 * Copyright (C) Jamie Hoglund 2004. All rights reserved.
 *
 *
 * Feel free to use this file. An advertisement link in the form of 
 * <A HREF="http://www.geniegate.com/">User Management</A> is
 * always appreciated, but not required for using this paypal IPN class. (Note
 * that the ad link *IS* required for using free versions of GenieGate, this 
 * class is not GeniGate and does not fall under that restriction)
 *
 * This class may not be used as part of another product which is offered for
 * resale. It is for personal (or single business) use only. Please use 
 * the contact form at http://www.geniegate.com/contact.php if there are
 * any questions or comments. (Hint: my main concern is that I don't want
 * a competitor to use it against me.)
 * 
 *
 *                         ** Use at your own risk **
 *
 * I neither claim nor do I accept any responsibility for any hardships it may 
 * cause anyone. There is no warranty expressed or implied. Use at your 
 * own risk. 
 *
* If it should happen to cause hardships or problems, or if you are having
* difficulty with it, I would appreciate hearing from you. Any contact we may
* have does NOT constitute, imply or otherwise indicate any acceptance of 
* liability. 
*
* -------------------------------------------------------------------
*
*/
class PayPal {
	var $log_file = FALSE;

	var $host = "www.paypal.com";
	var $port = 80;
	var $timeout = 45;

	var $debug_response = FALSE;

	// This is a dispatch array for the payment_status.
	var $STATUS = array(    Completed             => 'status_completed',
			Canceled_Reversal    => 'status_cancel_reverse',
			Denied                => 'status_denied',
			Failed                => 'status_failed',
			Pending                => 'status_pending',
			Refunded            => 'status_refunded',
			Reversed            => 'status_reversed'                            
			);

	// Table lookup of codes for their meanings.
	var $RC_CODES = array( "Success",
			"Socket or network problem",
			"Email verification failed",
			"txn_id is invalid or a duplicate",
			"Payment amount or currency incorrect",
			"Payment status not recognized",
			"INVALID transaction (possible attempted forgery?)",
			"Problem dealing with transaction status",
			"Neither VERIFIED nor INVALID was recieved from paypal"
			);
	/**
	 * Basic no-arg constructor.
	 */
	function PayPal(){
	}

	/**
	 * Set the log file for output, if you set this, information
	 * will be sent to the log file. 
	 */
	function log_file($filename = FALSE){
		if($filename){
			$this->log_file = $filename;
		}
		return($this->log_file);
	}

	/**
	 * Logs a message.
	 *
	 * Override this method to be notified of Errors,Info or Debug messages. 
	 * (Can also use log_file() to simply store them in a file some place)
	 *
	 * @param $level - One of I,D,E
	 * @param $message - Text of message to be logged.
	 */
	function logit($level,$message){
		if(! $this->log_file){
			return;
		}
		if(substr($message, -1) != "\n"){
			$message .= "\n";
		}
		error_log($level . "\t" . $message,3,$this->log_file);
		if($level == "E"){
			error_log($message);
		}
	}
	/**
	 * Transaction/Payment completed.
	 *
	 * This is typically the only method you'll need to override to perform
	 * some sort of action when a successful transaction has been completed.
	 *
	 * You could override the other status's (such as reverse or denied) to 
	 * reverse whatever was done, but that could interfere if you're denying a 
	 * payment or refunding someone for a good reason. In those cases, it's
	 * probably best to simply do whatever steps are required manually.
	 *
	 * @return TRUE - All went OK. 
	 */
	function status_completed(){
		$this->logit("D","Not doing anything about status_completed");
		return(TRUE);
	}
	/**
	 * Pending. Need to do something else?
	 * Look at $_POST[pending_reason].
	 *
	 * @return TRUE - All went OK.
	 */
	function status_pending(){
		$this->logit("D","Not doing anything about status_pending: " . $_POST[pending_reason]);
		return(TRUE);
	}
	/**
	 * Won a dispute.
	 * return TRUE - All went OK.
	 */
	function status_cancel_reverse(){
		$this->logit("D","Not doing anything about status_cancel_reverse");
		return(TRUE);
	}
	/**
	 * Merchant denied payment.
	 * @return TRUE - All went OK.
	 */
	function status_denied(){
		$this->logit("D","Not doing anything about status_denied");
		return(TRUE);
	}
	/**
	 * Transaction failed.
	 * return TRUE - All went OK.
	 */
	function status_failed(){
		$this->logit("D","Not doing anything about status_failed");
		return(TRUE);
	}
	/**
	 * Merchant refunded payment.
	 * @return TRUE - All went OK.
	 */
	function status_refunded(){
		$this->logit("D","Not doing anything about status_refunded");
		return(TRUE);
	}
	/**
	 * Charges reversed.
	 * @return TRUE - All went OK.
	 */
	function status_reversed(){
		$this->logit("D","Not doing anything about status_reversed " . $_POST[reason_code]);
		return(TRUE);
	}
	/**
	 * Use this to "fake" a VALID/INVALID response from paypal, for debugging
	 * purposes.
	 *
	 * Set the filename to be used for debugging, if set, it should be
	 * a filename that contains the headers and such that would be returned
	 * by paypal's web site. 
	 *
	 * Obvious Note: Don't use this on a production system..
	 */
	function debug_response($filename){
		$this->debug_response = $filename;
	}
	/**
	 * Set the host that will be contacted for payment corroboration. Normally,
	 * this is 45,www.paypal.com,80
	 */
	function paypal_host($timeout = 45,$host = "www.paypal.com",$port = 80){
		$this->host = $host;
		$this->port = $port;
		$this->timeout = $timeout;
	}

	/**
	 * Perform a connection to paypals website. Must return a resource
	 * pointer to a socket or handle. See debug_response() for a technique to
	 * debug using a fake response from paypal, see paypal_host() to set the 
	 * timeout,host,port details.
	 */
	function connect_paypal(){
		// Using a debug response file.
		if($this->debug_response){
			$fp = fopen($this->debug_response,"r");
			if(! $fp){
				$this->logit("E","Error opening debug response file: $this->debug_response");
			}
			$this->logit("D","Using debug file $this->debug_response");
			return($fp);
		}
		$this->logit("D","Connecting to: $this->host $this->port");
		$fp = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
		if(! $fp){
			$this->logit("E","Socket error: [" . $errno . "] " . $errstr);
		}
		return($fp);
	}
	/**
	 * Generate a testing form. The form is useful for debugging your handler 
	 * class.
	 * 
	 * Use test_form(FALSE) to create just the input variables. 
	 * (this is useful if you are using more than the basics presented here)
	 */
	function test_form($form_tags = TRUE){
		if($form_tags){
			echo "<FORM ACTION=\"$_SERVER[PHP_SELF]\" METHOD=\"POST\">";
		}
		?>
			<LI>DEBUG (for internal debug flags):<INPUT NAME="DEBUG">
			<LI>receiver_email:<INPUT NAME="receiver_email">
			<LI>item_number:<INPUT NAME="item_number">
			<LI>mc_gross:<INPUT NAME="mc_gross">
			<LI>mc_currency:<SELECT NAME="mc_currency">
			<OPTION VALUE="USD">USD</OPTION>
			<OPTION VALUE="CAD">CAD</OPTION>
			<OPTION VALUE="GBP">GBP</OPTION>
			<OPTION VALUE="EUR">EUR</OPTION>
			<OPTION VALUE="JPY">JPY</OPTION>
			</SELECT>
			<LI>txn_id<INPUT NAME="txn_id" VALUE="">
			<LI>parent_txn_id:<INPUT NAME="parent_txn_id">
			<LI>invoice:<INPUT NAME="invoice">
			<LI>custom:<INPUT NAME="custom">
			<LI>first_name:<INPUT NAME="first_name">
			<LI>last_name:<INPUT NAME="last_name">
			<LI>payer_business_name:<INPUT NAME="payer_business_name">
			<LI>address_street:<INPUT NAME="address_street">
			<LI>address_city:<INPUT NAME="address_city">
			<LI>address_state:<INPUT NAME="address_state">
			<LI>address_zip:<INPUT NAME="address_zip">
			<LI>address_country:<INPUT NAME="address_country">
			<LI>payer_email:<INPUT NAME="payer_email">
			<LI>payment_status:<SELECT NAME="payment_status">
			<OPTION VALUE="Canceled_Reversal">Canceled_Reversal</OPTION>
			<OPTION VALUE="Completed">Completed</OPTION>
			<OPTION VALUE="Denied">Denied</OPTION>
			<OPTION VALUE="Failed">Failed</OPTION>
			<OPTION VALUE="Pending">Pending</OPTION>
			<OPTION VALUE="Refunded">Refunded</OPTION>
			<OPTION VALUE="Reversed">Reversed</OPTION>
			</SELECT>
			<LI><B>This variable is only set if payment_status=&quot;Pending&quot;</B>
			<LI>pending_reason:<SELECT NAME="pending_reason">
			<OPTION VALUE="">(None)</OPTION>
			<OPTION VALUE="address">address</OPTION>
			<OPTION VALUE="echeck">echeck</OPTION>
			<OPTION VALUE="intl">intl</OPTION>
			<OPTION VALUE="multi_currency">multi_currency</OPTION>
			<OPTION VALUE="unilateral">unilateral</OPTION>
			<OPTION VALUE="upgrade">upgrade</OPTION>
			<OPTION VALUE="verify">verify</OPTION>
			<OPTION VALUE="other">other</OPTION>
			</SELECT>
			<LI><B>This variable is only set if payment_status=&quot;Reversed&quot;</B>
			<LI>reason_code:<SELECT NAME="reason_code">
			<OPTION VALUE="">(None)</OPTION>
			<OPTION VALUE="buyer_complaint">buyer_complaint</OPTION>
			<OPTION VALUE="chargeback">chargeback</OPTION>
			<OPTION VALUE="guarantee">guarantee</OPTION>
			<OPTION VALUE="refund">refund</OPTION>
			<OPTION VALUE="other">other</OPTION>
			</SELECT>        

			<?php
			if($form_tags){
				echo "<INPUT TYPE=\"SUBMIT\" VALUE=\"Run Test\">";
				echo "</FORM>";
			}
	}

	/**
	 * The Grand-Daddy method, this is the actor..
	 * returns > -1 on success, or one of the following codes for an error
	 * 
	 * -1 - Socket problem.
	 * -2 - check_email() failed.
	 * -3 - txn_id is a duplicate.
	 * -4 - check_amount() failed.
	 * -5 - payment_status not recognized.
	 * -6 - INVALID response.
	 * -7 - The status_* method. didn't return TRUE.
	 * -8 - Neither VERIFIED nor INVALID were found in paypal response.
	 * 
	 * Use errstr() for a brief sentance explaining the error.
	 *
	 * @return error code or zero if no error.
	 */
	function processIPN(){
		$this->logit("D","Processing paypal IPN");
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$this->logit("D","Variable: $key=[$value]");
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		// Connect with paypal.
		$fp = $this->connect_paypal();
		if(! $fp){
			return(-1);
		}
		// If in debug mode, don't post anything.
		if(! $this->debug_response){
			// post back to corroborate with PayPal 
			$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			fputs ($fp, $header . $req);
		}
		$return_code = -8;
		$payment_status = $_POST[payment_status];
		$in_hdr = TRUE;
		while (!feof($fp)) {
			$res = trim(fgets ($fp, 1024));

			// Don't process the header.
			if(strlen($res) == 0){
				$in_hdr = FALSE;
				continue;
			}
			if($in_hdr){
				continue;
			}

			$this->logit("D","Response: [" . $res . "]");
			if (strcmp ($res, "VERIFIED") == 0) {
				$return_code = 0;
				$this->logit("D","Verified");
				// Make sure credit wasn't toward someone else.
				if(! $this->check_email($_POST[receiver_email])){
					$return_code = -2;
					break;
				}
				// Check txn_id is OK. (not been re-used)
				if(! $this->check_txn_id($_POST[txn_id])){
					$return_code = -3;
					break;
				}
				// Check that the ammount was correct for this item.
				if(! $this->check_amount($_POST[item_number],$_POST[mc_gross],$_POST[mc_currency])){
					$return_code = -4;
					break;
				}
				// Determine disposition of payment_status
				if($return_code == 0){
					// payment_status is Completed, Pending
					$method = $this->STATUS[$payment_status];
					if($method){
						$this->logit("D","Running: $method (from $payment_status)");
						$meth_code = $this->$method();
						if(! $meth_code){
							$this->logit("E","Method [$method] did not return TRUE");
							$return_code = -7;
						}
					}else{
						$this->logit("E","Payment Status: $payment_status not recognized");
						$return_code = -5;
					}
					break;
				}
				break;
			}else if (strcmp ($res, "INVALID") == 0) {
				$this->logit("I","Invalid response: " . $res);
				$return_code = -6;
				break;
			}
		}
		fclose ($fp);
		return($return_code);
	}

	/**
	 * Fetch a string that tells what the returned error code from
	 * processIPN means. (Use for logging or error reporting)
	 *
	 * @param $code - Numeric code that represents an error. (Must be negative)
	 */
	function errstr($code){
		$code = abs($code);
		return($this->RC_CODES[$code]);
	}
	/**
	 * Check that the amount/currency is correct for item_id
	 * 
	 * You should override this method to ensure the amount is correct.
	 *
	 * @param $item_no - The item number.
	 * @param $amount  - Same as mc_gross, the amount being paid.
	 * @param $currency - Currency code that amount is in.
	 *
	 * @return TRUE / FALSE.
	 */
	function check_amount($item_no,$amount,$currency){
		$this->logit("D","Not doing check_amount($item_no,$amount,$currency)");
		return(TRUE);
	}
	/**
	 * Check txn_id has not already been used.
	 * Override this method to ensure txn_id is not a duplicate.
	 * 
	 * @param $id - The transaction ID from paypal.
	 *
	 * @return TRUE/FALSE.
	 */
	function check_txn_id($id){
		$this->logit("D","Not doing check_txn_id($id)");
		return(TRUE);
	}
	/**
	 * Check email address for validity.
	 * Override this method to make sure you are the one being paid.
	 *
	 * @param $email - The email who is about to recieve payment.
	 *
	 * @return TRUE/FALSE
	 */
	function check_email($email){
		$this->logit("D","Not doing check_email($email)");
		return(TRUE);
	}
}
?>
