<?php
    /**
    * GoCardless WHMCS module HOOKS - aka GoCardless Direct Debit Helper
    *
    * This file needs to be moved to the /includes/hooks directory within
    * the WHMCS install. This file works around the limitation in WHMCS
    * to request Direct Debit payments in time and stop sending payment
    * failure emails.
    *
    * @author: York UK Hosting <github@yorkukhosting.com>
    * @version: 1.1.0-YUH
    * @github: http://github.com/yorkukhosting/gocardless-whmcs/
    *
    */

  # User Account to log API actions against
  $gc_whmcs_api_user = 'admin';

  # The numbers of days before the payment is due we shoud request the 
  # payment. Payments normally take 5 - 7 days but 10 days ensures 
  # payments are received in time, for example Christmas bank holidays
  # can delay payments. (specified as string)
  $gc_bill_days_before_due = '10';

function GoCardlessCaptureCron() {
 /*
  * Triggers the capture of the Debit Card payment X days before the
  * due to date.
  */
  $duedate = date('Y-m-d', strtotime("+$gc_bill_days_before_due days"));
  $result = full_query("Select id,duedate,paymentmethod,status FROM tblinvoices WHERE duedate <= '". $duedate . "' AND status='Unpaid' and paymentmethod='gocardless'");

  while ($data = mysql_fetch_array($result)) {

    $invoiceid = $data['id'];
    $result_gocardless = select_query("mod_gocardless","invoiceid",array("invoiceid"=>$invoiceid));
    $result_data = mysql_fetch_array($result_gocardless);
    
    if ($result_data['invoiceid'] != $invoiceid) {
    
      $command = "capturepayment";
      $adminuser = "$gc_whmcs_api_user";
      $values["invoiceid"] = $invoiceid;
  
      $capture_results = localAPI($command,$values,$adminuser);

  
    }
  }
}

function SupressPaymentReminders($vars) {
 /*
  * Prevents incorrect payment reminder emails from being
  * sent whilst the payment request is inflight. If the
  * payment fails we send the reminders.
  */
 
   $email_template_name = $vars['messagename']; # Email template name being sent

   if ($email_template_name=='Credit Card Payment Failed' ||
       $email_template_name=='Invoice Payment Reminder' ||
       $email_template_name=='First Invoice Overdue Notice' || 
       $email_template_name=='Second Invoice Overdue Notice' || 
       $email_template_name=='Third Invoice Overdue Notice')
   {

	   $invoiceid = $vars['relid'];

	   $result = select_query("mod_gocardless","payment_failed",array("invoiceid"=>$invoiceid));
	   $data = mysql_fetch_array($result);

           if (empty($data)) {
	       $merge_fields = array();
	       $merge_fields['abortsend'] = false;
           }
           else
           {
 	     if ($data['payment_failed']==0) 
	      {
	       $merge_fields = array();
	       $merge_fields['abortsend'] = true; # You can use this return to stop email sending
	       return $merge_fields;
	     } 
           }
   }

}

add_hook("DailyCronJob",1,"GoCardlessCaptureCron"); 
add_hook("EmailPreSend",1,"SupressPaymentReminders");
?>

