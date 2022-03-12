<?php namespace App\Services;

use Exception;
use function GuzzleHttp\Psr7\str;

class BillingUtils
{

    const LIVE_MODE = 'live';
    const TEST_MODE = 'test';
    const GATE_WAY_URL_THREE_STEP = 'https://secure.edataexecutivegateway.com/api/v2/three-step';

    private static $edata = [
        self::LIVE_MODE => [
            'username' => 'Collide1',
            'password' => 'Telx5727!!',
            'apiKey' => 'azJsGwf6RfSYz6NrPWzqPa86a87s838j',
        ],
        self::TEST_MODE => [
            'username' => 'Collide1',
            'password' => 'Telx5727!!',
            'apiKey' => 'azJsGwf6RfSYz6NrPWzqPa86a87s838j',
        ],

    ];

    //force test mode in production?
    const PROD_TEST_OVERRIDE = false;

    public static function get_mode()
    {
        if (ApiUtils::prod_db() && !self::PROD_TEST_OVERRIDE) {
            return self::LIVE_MODE;
        }
        return self::TEST_MODE;
    }

    public static function username()
    {
        return self::$edata[self::get_mode()]['username'];
    }

    public static function password()
    {
        return self::$edata[self::get_mode()]['password'];
    }

    public static function apiKey()
    {
        return self::$edata[self::get_mode()]['apiKey'];
    }

    public static function checkCustomerVault($user_id)
    {


        $customersArray = array();
        $customersArrayT = array();
        $ids = array();

        $constraints = "&report_type=customer_vault&customer_vault_id=" . $user_id . "&ver=2";
        $mycurl = curl_init();
        $postStr = 'username=' . self::username() . '&password=' . self::password() . $constraints;
        $url = "https://secure.edataexecutivegateway.com/api/query.php?" . $postStr;
        curl_setopt($mycurl, CURLOPT_URL, $url); // Set POST URL
        curl_setopt($mycurl, CURLOPT_FAILONERROR, 1); // Fail on errors
        curl_setopt($mycurl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
        curl_setopt($mycurl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
        curl_setopt($mycurl, CURLOPT_PORT, 443); // Set the port number
        curl_setopt($mycurl, CURLOPT_TIMEOUT, 30); // Times out after 30s
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYPEER, 0);

        if (!($data = curl_exec($mycurl))) {
            return count($customersArray);

        }

        curl_close($mycurl);
        $result = $data;

        $testXmlSimple = new \SimpleXMLElement($result);

        if (!isset($testXmlSimple->customer_vault)) {
            // throw new NmExUser('No transactions returned');
        }


        $transNum = 1;
        foreach ($testXmlSimple->customer_vault as $transaction) {
            foreach ($transaction->customer as $customer) {
                array_push($customersArray, $customer);
            }
        }


        return count($customersArray);

    }

    public static function getErrorMessageByCode($code, $avsCode,$from = false)
    {

        $responseMessage = 'Your payment method could not be added.';
        if($from){
            if($from == 'BUY_CREDITS'){
                $responseMessage = 'Card Declined. Please contact your bank for more information.';
            }
        }elseif($avsCode == "N" && $code == 300){
           $responseMessage = 'The Billing address ZIP code does not match the card details';
        }
        
        // N , Z, A , (C)    Your billing address and credit card information does not match
        // if ($avsCode == "N" || $avsCode == "Z" || $avsCode == "A" || $avsCode == "C") {

        //     if ($code == '225') {
        //         $responseMessage = "Your credit card security code is invalid.";
        //     } else {
        //         $responseMessage = "Your billing address and credit card information does not match. ";
        //     }

        // } else {
        //     switch ($code) {
        //         case '200':
        //             $responseMessage = "Your transaction has been declined. Please contact your card services.";
        //             break;
        //         case '220':
        //             $responseMessage = "Your billing address and credit card information does not match. ";
        //             break;
        //         case '225':
        //             $responseMessage = "Your credit card security code is invalid.";
        //             break;
               
        //         default:
        //             $responseMessage = "Card Declined. Please contact your bank for more information.";
        //             break;
        //     }
        // }


        return $responseMessage;
    }

    public static function get_user_cards($user_id, $card)
    {


        $customersArray = array();
        $customersArrayT = array();
        $ids = array();

        $constraints = "&report_type=customer_vault&customer_vault_id=" . $user_id . "&ver=2";
        $mycurl = curl_init();
        
        $postStr = 'username=' . self::username() . '&password=' . self::password() . $constraints;
        $url = "https://secure.edataexecutivegateway.com/api/query.php?" . $postStr;
        curl_setopt($mycurl, CURLOPT_URL, $url); // Set POST URL
        curl_setopt($mycurl, CURLOPT_FAILONERROR, 1); // Fail on errors
        curl_setopt($mycurl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
        curl_setopt($mycurl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
        curl_setopt($mycurl, CURLOPT_PORT, 443); // Set the port number
        curl_setopt($mycurl, CURLOPT_TIMEOUT, 30); // Times out after 30s
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYPEER, 0);

        if (!($data = curl_exec($mycurl))) {
            return $customersArray;

        }

        curl_close($mycurl);
        $result = $data;

        $testXmlSimple = new \SimpleXMLElement($result);

        if (!isset($testXmlSimple->customer_vault)) {
            // throw new NmExUser('No transactions returned');
        }


        $transNum = 1;

       
        foreach ($testXmlSimple->customer_vault as $transaction) {

            foreach ($transaction->customer as $customer) {


                foreach ($customer->billing as $cust) {

                    //array_push($customersArrayT, $customerArray);
                    //array_push($ids, $id);

                    switch ($card) {
                        case 'CREDIT':
                            $cc_number = (string)$cust->cc_number;
                            $cc_exp = (string)$cust->cc_exp;
                            $priority = (string)$cust->priority;
                            $id = (string)$cust['id'];
                            if ($cc_number != "" && strpos($id, '-D') == false) {
                                $customerArray = array($cc_number, $cc_exp, $priority, $id);
                                array_push($customersArray, $customerArray);
                            }
                            break;
                        case 'DEBIT':
                            $cc_number = (string)$cust->cc_number;
                            $cc_exp = (string)$cust->cc_exp;
                            $priority = (string)$cust->priority;
                            $id = (string)$cust['id'];
                            if ($cc_number != "" && strpos($id, '-D') !== false) {
                                $customerArray = array($cc_number, $cc_exp, $priority, $id);
                                array_push($customersArray, $customerArray);
                            }
                            break;
                        case 'DEPOSIT':

                        
                      
                            $check_account = (string)$cust->check_account;
                            $check_name = (string)$cust->check_name;
                            $check_aba = (string)$cust->check_aba;
                            $priority = (string)$cust->priority;
                            $account_type = (string)$cust->account_type;
                            $country = (string)$cust->country;
                            $id = (string)$cust['id'];
                             

                            $account =substr_replace($check_account,'XXXXXXXXXX',0,strlen($check_account)-4);
                            $routing =substr_replace($check_aba,'XXXXXXXXXX',0,strlen($check_aba)-4);
                            $customerArray = ['account'=>$account, 'account_type'=>$account_type, 
                            'id'=>$id,'routing'=>$routing,'account_name'=> $check_name, 'payment'=>'DEPOSIT','country'=>$country];
                           /* array_push($customersArrayT, $customerArray);
                            array_push($ids, $id);*/
                            if ($check_account != "" && $check_aba != "") {

                                $customersArray = $customerArray;
                            }
                            break;
                        case 'BUY_CREDIT':
                            $cc_number = (string)$cust->cc_number;
                            $cc_exp = (string)$cust->cc_exp;
                            $priority = (string)$cust->priority;
                            $id = (string)$cust['id'];
                                if ($cc_number != "") {
                                    $customerArray = array(
                                        'last_four'=>substr($cc_number, -4), 
                                        'cc_exp'=>$cc_exp,
                                        'priority' =>$priority,
                                        'id'=> $id, 
                                        'image_selected'=>'/images/icons/Card_added_selected.svg',
                                        'image_unselected'=>'/images/icons/Card_added.svg');
                                    array_push($customersArray, $customerArray);
                                }
                        
                        break;
                        default:
                        $cc_number = (string)$cust->cc_number;
                        $cc_exp = (string)$cust->cc_exp;
                        $priority = (string)$cust->priority;
                        $id = (string)$cust['id'];
                            if ($cc_number != "") {
                                $customerArray = array($cc_number, $cc_exp, $priority, $id);
                                array_push($customersArray, $customerArray);
                            }
                            break;

                    }

                }
            } 

        }
        return $customersArray;
    }

    public static function get_user_cards_and_info($user_id, $card)
    {


        $customersArray = array();
        $customersArrayT = array();
        $ids = array();

        $constraints = "&report_type=customer_vault&customer_vault_id=" . $user_id . "&ver=2";
        $mycurl = curl_init();

        $postStr = 'username=' . self::username() . '&password=' . self::password() . $constraints;
        $url = "https://secure.edataexecutivegateway.com/api/query.php?" . $postStr;
        curl_setopt($mycurl, CURLOPT_URL, $url); // Set POST URL
        curl_setopt($mycurl, CURLOPT_FAILONERROR, 1); // Fail on errors
        curl_setopt($mycurl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
        curl_setopt($mycurl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
        curl_setopt($mycurl, CURLOPT_PORT, 443); // Set the port number
        curl_setopt($mycurl, CURLOPT_TIMEOUT, 30); // Times out after 30s
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYPEER, 0);

        if (!($data = curl_exec($mycurl))) {
            return $customersArray;

        }

        curl_close($mycurl);
        $result = $data;

        $testXmlSimple = new \SimpleXMLElement($result);

        if (!isset($testXmlSimple->customer_vault)) {
            // throw new NmExUser('No transactions returned');
        }


        $transNum = 1;
        foreach ($testXmlSimple->customer_vault as $transaction) {

            foreach ($transaction->customer as $customer) {


                foreach ($customer->billing as $cust) {

                    //array_push($customersArrayT, $customerArray);
                    //array_push($ids, $id);

                    switch ($card) {
                        case 'DEPOSIT':

                            $check_account = (string)$cust->check_account;
                            $check_name = (string)$cust->check_name;
                            $check_aba = (string)$cust->check_aba;
                            $priority = (string)$cust->priority;
                            $account_type = (string)$cust->account_type;
                            $country = (string)$cust->country;
                            $id = (string)$cust['id'];


                            $account =substr_replace($check_account,'XXXXXXXXXX',0,strlen($check_account)-4);
                            $routing =substr_replace($check_aba,'XXXXXXXXXX',0,strlen($check_aba)-4);
                            $customerArray = ['account'=>$account, 'account_type'=>$account_type,
                                'id'=>$id,'routing'=>$routing,'account_name'=> $check_name, 'payment'=>'DEPOSIT','country'=>$country];
                            /* array_push($customersArrayT, $customerArray);
                             array_push($ids, $id);*/
                            if ($check_account != "" && $check_aba != "") {

                                $customersArray = $customerArray;
                            }
                            break;

                        default:
                            $cc_number = (string)$cust->cc_number;
                            $cc_exp = (string)$cust->cc_exp;
                            $priority = (string)$cust->priority;
                            $id = (string)$cust['id'];
                            if ($cc_number != "") {
                                $customerArray = array($cc_number, $cc_exp, $priority, $id);
                                array_push($customersArray, $customerArray);
                            }
                            break;

                    }

                }
                //$perchant_fields = ['merchant' => $customer->merchant_defined_field];
                $customersArray['merchant'] = $customer->merchant_defined_field;
                $customersArray['type'] = $card;

            }


            return $customersArray;


        }
    }

    public static function manage_card($transactionType,$user_id, $billing_id)
    {


        try {


            $xmlRequest = new \DOMDocument('1.0', 'UTF-8');
            $xmlRequest->formatOutput = true;
            $xmlSale = $xmlRequest->createElement($transactionType);
            self::appendXmlNode($xmlRequest, $xmlSale, 'api-key', self::apiKey());
            self::appendXmlNode($xmlRequest, $xmlSale, 'customer-vault-id', $user_id);


            switch ($transactionType){
                case 'delete-billing':
                    $xmlBillingAddress = $xmlRequest->createElement('billing');
                    self::appendXmlNode($xmlRequest, $xmlBillingAddress, 'billing-id', $billing_id);
                    $xmlSale->appendChild($xmlBillingAddress);
                    break;
                case 'update-billing':
                    $xmlBillingAddress = $xmlRequest->createElement('billing');
                    self::appendXmlNode($xmlRequest, $xmlBillingAddress, 'billing-id', $billing_id);
                    self::appendXmlNode($xmlRequest, $xmlBillingAddress, 'priority', 1);
                    $xmlSale->appendChild($xmlBillingAddress);
                    break;

            }
            $xmlRequest->appendChild($xmlSale);

            // Process Step One: Submit all customer details to the Payment Gateway except the customer's sensitive payment information.
            // The Payment Gateway will return a variable form-url.
            $data = self::sendXMLviaCurl($xmlRequest, self::GATE_WAY_URL_THREE_STEP);

                // Parse Step One's XML response
            $gwResponse = @new \SimpleXMLElement($data);

            return $gwResponse;



        } catch (Exception $exc) {
            throw new  $exc;

        }
    }

    public static function checkDepositAccount($user)
    {


        $customersArray = array();
        $customersArrayT = array();
        $ids = array();
        $constraints = "&report_type=customer_vault&customer_vault_id=" . $user->getId() . "&ver=2";

        $mycurl = curl_init();
        $postStr = 'username='.self::username().'&password='. self::password() .$constraints;
        $url = "https://secure.edataexecutivegateway.com/api/query.php?" . $postStr;
        curl_setopt($mycurl, CURLOPT_URL, $url); // Set POST URL
        curl_setopt($mycurl, CURLOPT_FAILONERROR, 1); // Fail on errors
        curl_setopt($mycurl, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
        curl_setopt($mycurl, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
        curl_setopt($mycurl, CURLOPT_PORT, 443); // Set the port number
        curl_setopt($mycurl, CURLOPT_TIMEOUT, 30); // Times out after 30s
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($mycurl, CURLOPT_SSL_VERIFYPEER, 0);

        if (!($data = curl_exec($mycurl))) {
            return $customersArray;

        }

        curl_close($mycurl);
        $result = $data;

        $testXmlSimple = new \SimpleXMLElement($result);

        if (!isset($testXmlSimple->customer_vault)) {
            // throw new NmExUser('No transactions returned');
        }



        foreach ($testXmlSimple->customer_vault as $transaction) {

            foreach ($transaction->customer as $customer) {

                foreach ($customer->billing as $cust) {
                    $check_account = (string)$cust->check_account;
                    $check_aba = (string)$cust->check_aba;
                    $priority = (string)$cust->priority;
                    $id = (string)$cust['id'];
                    $customerArray = array($check_account, $priority, $id);
                    array_push($customersArrayT, $customerArray);
                    array_push($ids, $id);
                    if ($check_account != "" && $check_aba != "") {
                        array_push($customersArray, $customerArray);
                    }
                }
            }
        }

        return $customersArray;

    }

    // Helper function to make building xml dom easier
    private static function appendXmlNode($domDocument, $parentNode, $name, $value)
    {
        $childNode = $domDocument->createElement($name);
        $childNodeValue = $domDocument->createTextNode($value);
        $childNode->appendChild($childNodeValue);
        $parentNode->appendChild($childNode);
    }

    private static function sendXMLviaCurl($xmlRequest, $gatewayURL)
    {
        // helper function demonstrating how to send the xml with curl


        $ch = curl_init(); // Initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $gatewayURL); // Set POST URL

        $headers = array();
        $headers[] = "Content-type: text/xml";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Add http headers to let it know we're sending XML
        $xmlString = $xmlRequest->saveXML();
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); // Fail on errors
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return into a variable
        curl_setopt($ch, CURLOPT_PORT, 443); // Set the port number
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Times out after 30s
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString); // Add XML directly in POST


        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);


        // This should be unset in production use. With it on, it forces the ssl cert to be valid
        // before sending info.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if (!($data = curl_exec($ch))) {
            print  "curl error =>" . curl_error($ch) . "\n";
            throw New Exception(" CURL ERROR :" . curl_error($ch));

        }
        curl_close($ch);

        return $data;
    }

}
