<?php

namespace App\Billing;

use App\Http\Trails\PayoutTrail;

class gwapi
{
    use PayoutTrail;
    private $login = array('username'=> '', 'password'=> '');
    private $order = array('orderid'=> '', 'orderdescription'=> '', 'tax'=> 0, 'shipping'=> 0, 'ponumber'=> '', 'ipaddress'=> '');
    private $billing = array('firstname'=> '', 'lastname'=> '', 'company'=> '', 'address1'=> '', 'address2'=> '', 'city'=> '', 'state'=> '', 'zip'=> '', 'country'=> '', 'phone'=> '', 'fax'=> '', 'email'=> '', 'website'=> '');
    private $shipping = array('firstname'=> '', 'lastname'=> '', 'company'=> '', 'address1'=> '', 'address2'=> '', 'city'=> '', 'state'=> '', 'zip'=> '', 'country'=> '', 'email'=> '');





    // Initial Setting Functions

    function setLogin($username, $password) {
        $this->login['username'] = $username;
        $this->login['password'] = $password;
    }

    function setOrder($orderid,
                      $orderdescription,
                      $tax,
                      $shipping,
                      $ponumber,
                      $ipaddress) {
        $this->order['orderid']          = $orderid;
        $this->order['orderdescription'] = $orderdescription;
        $this->order['tax']              = $tax;
        $this->order['shipping']         = $shipping;
        $this->order['ponumber']         = $ponumber;
        $this->order['ipaddress']        = $ipaddress;
    }

    function setBilling($billing_id,$firstname,
                        $lastname,
                        $company,
                        $address1,
                        $address2,
                        $city,
                        $state,
                        $zip,
                        $country,
                        $phone,
                        $fax,
                        $email,
                        $website) {
        $this->billing['billing_id'] = $billing_id;
        $this->billing['firstname'] = $firstname;
        $this->billing['lastname']  = $lastname;
        $this->billing['company']   = $company;
        $this->billing['address1']  = $address1;
        $this->billing['address2']  = $address2;
        $this->billing['city']      = $city;
        $this->billing['state']     = $state;
        $this->billing['zip']       = $zip;
        $this->billing['country']   = $country;
        $this->billing['phone']     = $phone;
        $this->billing['fax']       = $fax;
        $this->billing['email']     = $email;
        $this->billing['website']   = $website;
    }

    function setShipping($firstname,
                         $lastname,
                         $company,
                         $address1,
                         $address2,
                         $city,
                         $state,
                         $zip,
                         $country,
                         $email) {
        $this->shipping['firstname'] = $firstname;
        $this->shipping['lastname']  = $lastname;
        $this->shipping['company']   = $company;
        $this->shipping['address1']  = $address1;
        $this->shipping['address2']  = $address2;
        $this->shipping['city']      = $city;
        $this->shipping['state']     = $state;
        $this->shipping['zip']       = $zip;
        $this->shipping['country']   = $country;
        $this->shipping['email']     = $email;
    }

    // Transaction Functions

    function doSaleAux($amount, $vault_id, $billing_id, $order_id, $ip_addr) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        //$query .= "dup_seconds=5&";
        $query .= "merchant_defined_field_1=" . urlencode($order_id) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        // Order Information
        $query .= "type=sale";
        return $this->_doPost($query);
    }


    function addSubscriptionToPlan($vault_id, $billing_id, $plan_id, $ip_addr) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "recurring=add_subscription&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        $query .= "plan_id=" . urlencode($plan_id);
        //$query .= "merchant_defined_field_1=" . urlencode($reservation_serie) . "&";
        // Order Information
        //$query .= "type=auth";
        return $this->_doPost($query);
    }


    function addSubscriptionToPlanHybrid($vault_id, $ccnumber, $ccexp, $cvv, $billing_id, $plan_id, $amount, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $country, $phone,$transactionType,$priority,$ip_addr) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "customer_vault=" . urlencode($transactionType) . "&";
        $query .= "recurring=add_subscription&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "amount=" . urlencode($amount) . "&";
        $query .= "plan_id=" . urlencode($plan_id) . "&";
        $query .= "firstname=" . urlencode($firstname) . "&";
        $query .= "lastname=" . urlencode($lastname) . "&";
        $query .= "address1=" . urlencode($address1) . "&";
        $query .= "address2=" . urlencode($address2) . "&";
        $query .= "city=" . urlencode($city) . "&";
        $query .= "state=" . urlencode($state) . "&";
        $query .= "zip=" . urlencode($zip) . "&";
        $query .= "country=" . urlencode($country) . "&";
        $query .= "phone=" . urlencode($phone) . "&";
        $query .= "priority=" . urlencode($priority) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        $query .= "type=auth";
        return $this->_doPost($query);
    }


    function updateSubscriptionPlan($subscription_id, $vault_id,  $billing_id,  $plan_id, $amount, $ip_addr) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information

        $query .= "recurring=update_subscription&";
        $query .= "subscription_id=" . urlencode($subscription_id) . "&";
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        //$query .= "amount=" . urlencode($amount) . "&";
        $query .= "plan_id=" . urlencode($plan_id);
        //$query .= "merchant_defined_field_1=" . urlencode($reservation_serie) . "&";
        // Order Information
        //$query .= "type=auth";
        return $this->_doPost($query);
    }


    function deleteSubscriptionPlan($subscription_id) {
        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "recurring=delete_subscription&";
        $query .= "subscription_id=" . urlencode($subscription_id) . "&";
        return $this->_doPost($query);
    }

    function addCard($amount,$vault_id, $ccnumber, $ccexp, $cvv, $billing_id,   $firstname, $lastname, $address1, $address2, $city, $state, $zip, $country, $phone,$transactionType,$priority,$ip_addr,$status=null, $xid=null,$eci=null,$cavv=null) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "amount=" . $amount . "&";
        $query .= "checkname=" . urlencode($firstname) . "&";
        $query .= "customer_vault=" . urlencode($transactionType) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "firstname=" . urlencode($firstname) . "&";
        $query .= "lastname=" . urlencode($lastname) . "&";
        //$query .= "address1=" . urlencode($address1) . "&";
        //$query .= "address2=" . urlencode($address2) . "&";
       // $query .= "city=" . urlencode($city) . "&";
        //$query .= "state=" . urlencode($state) . "&";
        $query .= "zip=" . urlencode($zip) . "&";
        // $query .= "country=" . urlencode($country) . "&";
        //$query .= "phone=" . urlencode($phone) . "&";
        $query .= "priority=" . urlencode($priority) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";


        // if (!empty($status)) {
        //     switch ($status)
        //     {
        //         case 'Y':
        //             $query .= "cardholder_auth=" . urlencode('verified') . "&";
        //             break;
        //         case 'A':
        //             $query .= "cardholder_auth=" . urlencode('attempted') . "&";
        //             break;
        //     }

        // }

        // if (!empty($xid)) {
        //     $query .= "xid=" . urlencode($xid) . "&";
        // }
        // if (!empty($eci)) {
        //     $query .= "eci=" . urlencode($eci) . "&";
        // }
        // if (!empty($cavv)) {
        //     $query .= "cavv=" . urlencode($cavv) . "&";
        // }

        $query .= "type=auth";
      
        return $this->_doPost($query);
    }



    function addDepositAccount($customerId, $name, $accountType, $entityType, $routing, $account, $country, $billing_id, $transactionType,  $ip_addr, $bankName) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($customerId) . "&";
        $query .= "customer_vault=" . urlencode($transactionType) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "checkname=" . urlencode($name) . "&";
        $query .= "account_type=" . urlencode($accountType) . "&";
        /*$query .= "account_holder_type=" . urlencode($entityType) . "&";*/
        $query .= "checkaccount=" . urlencode($account) . "&";
        $query .= "checkaba=" . urlencode($routing) . "&";
        $query .= "merchant_defined_field_4=" . urlencode($account) . "&";
        $query .= "merchant_defined_field_5=" . urlencode($routing) . "&";
        $query .= "company=" . urlencode($bankName) . "&";
        
        $query .= "country=" . urlencode($country) . "&";

        $query .= "ipaddress=" . urlencode($ip_addr);
        return $this->_doPost($query);
    }


    function validateCard($amount, $ccnumber, $ccexp, $cvv,  $firstname, $lastname, $address1, $address2, $city, $state, $zip, $country, $phone, $ip_addr, $user_id = null) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        $query .= "amount=" . urlencode($amount) . "&";
        // Sales Information
        $query .= "firstname=" . urlencode($firstname) . "&";
        $query .= "lastname=" . urlencode($lastname) . "&";
        $query .= "address1=" . urlencode($address1) . "&";
        $query .= "address2=" . urlencode($address2) . "&";
        $query .= "city=" . urlencode($city) . "&";
        $query .= "state=" . urlencode($state) . "&";
        $query .= "zip=" . urlencode($zip) . "&";
        $query .= "country=" . urlencode($country) . "&";
        $query .= "phone=" . urlencode($phone) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
	    $query .= "merchant_defined_field_3=" . urlencode($user_id) . "&";
        $query .= "type=auth";
        return $this->_doPost($query);
    }


    function doSaleHybrid($vault_id, $ccnumber, $ccexp, $cvv, $billing_id,   $firstname, $lastname, $address1, $address2, $city, $state, $zip, $country, $phone,$transactionType,$priority,$ip_addr, $amount, $order_id = null, $subscription_id = null, $status=null, $xid=null,$eci=null,$cavv=null) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "customer_vault=" . urlencode($transactionType) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "firstname=" . urlencode($firstname) . "&";
        $query .= "lastname=" . urlencode($lastname) . "&";
        $query .= "address1=" . urlencode($address1) . "&";
        $query .= "address2=" . urlencode($address2) . "&";
        $query .= "city=" . urlencode($city) . "&";
        $query .= "state=" . urlencode($state) . "&";
        $query .= "zip=" . urlencode($zip) . "&";
        $query .= "country=" . urlencode($country) . "&";
        $query .= "phone=" . urlencode($phone) . "&";
        $query .= "priority=" . urlencode($priority) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        //$query .= "dup_seconds=0&";
        $query .= "merchant_defined_field_1=" . urlencode($order_id) . "&";
        $query .= "merchant_defined_field_2=" . urlencode($subscription_id) . "&";



        if (!empty($status)) {
            switch ($status)
            {
                case 'Y':
                    $query .= "cardholder_auth=" . urlencode('verified') . "&";
                    break;
                case 'A':
                    $query .= "cardholder_auth=" . urlencode('attempted') . "&";
                    break;
            }

        }

        if (!empty($xid)) {
            $query .= "xid=" . urlencode($xid) . "&";
        }
        if (!empty($eci)) {
            $query .= "eci=" . urlencode($eci) . "&";
        }
        if (!empty($cavv)) {
            $query .= "cavv=" . urlencode($cavv) . "&";
        }

        $query .= "type=sale";
        return $this->_doPost($query);
    }


    function doSale($amount, $ccnumber, $ccexp, $cvv="") {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Order Information
        $query .= "ipaddress=" . urlencode($this->order['ipaddress']) . "&";
        $query .= "orderid=" . urlencode($this->order['orderid']) . "&";
        $query .= "orderdescription=" . urlencode($this->order['orderdescription']) . "&";
        $query .= "tax=" . urlencode(number_format($this->order['tax'],2,".","")) . "&";
        $query .= "shipping=" . urlencode(number_format($this->order['shipping'],2,".","")) . "&";
        $query .= "ponumber=" . urlencode($this->order['ponumber']) . "&";
        // Billing Information
        $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
        $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
        $query .= "company=" . urlencode($this->billing['company']) . "&";
        $query .= "address1=" . urlencode($this->billing['address1']) . "&";
        $query .= "address2=" . urlencode($this->billing['address2']) . "&";
        $query .= "city=" . urlencode($this->billing['city']) . "&";
        $query .= "state=" . urlencode($this->billing['state']) . "&";
        $query .= "zip=" . urlencode($this->billing['zip']) . "&";
        $query .= "country=" . urlencode($this->billing['country']) . "&";
        $query .= "phone=" . urlencode($this->billing['phone']) . "&";
        $query .= "fax=" . urlencode($this->billing['fax']) . "&";
        $query .= "email=" . urlencode($this->billing['email']) . "&";
        $query .= "website=" . urlencode($this->billing['website']) . "&";
        // Shipping Information
        $query .= "shipping_firstname=" . urlencode($this->shipping['firstname']) . "&";
        $query .= "shipping_lastname=" . urlencode($this->shipping['lastname']) . "&";
        $query .= "shipping_company=" . urlencode($this->shipping['company']) . "&";
        $query .= "shipping_address1=" . urlencode($this->shipping['address1']) . "&";
        $query .= "shipping_address2=" . urlencode($this->shipping['address2']) . "&";
        $query .= "shipping_city=" . urlencode($this->shipping['city']) . "&";
        $query .= "shipping_state=" . urlencode($this->shipping['state']) . "&";
        $query .= "shipping_zip=" . urlencode($this->shipping['zip']) . "&";
        $query .= "shipping_country=" . urlencode($this->shipping['country']) . "&";
        $query .= "shipping_email=" . urlencode($this->shipping['email']) . "&";
        $query .= "type=sale";
        return $this->_doPost($query);
    }

    function doAuth($amount, $ccnumber, $ccexp, $cvv="") {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Order Information
        $query .= "ipaddress=" . urlencode($this->order['ipaddress']) . "&";
        $query .= "orderid=" . urlencode($this->order['orderid']) . "&";
        $query .= "orderdescription=" . urlencode($this->order['orderdescription']) . "&";
        $query .= "tax=" . urlencode(number_format($this->order['tax'],2,".","")) . "&";
        $query .= "shipping=" . urlencode(number_format($this->order['shipping'],2,".","")) . "&";
        $query .= "ponumber=" . urlencode($this->order['ponumber']) . "&";
        // Billing Information
        $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
        $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
        $query .= "company=" . urlencode($this->billing['company']) . "&";
        $query .= "address1=" . urlencode($this->billing['address1']) . "&";
        $query .= "address2=" . urlencode($this->billing['address2']) . "&";
        $query .= "city=" . urlencode($this->billing['city']) . "&";
        $query .= "state=" . urlencode($this->billing['state']) . "&";
        $query .= "zip=" . urlencode($this->billing['zip']) . "&";
        $query .= "country=" . urlencode($this->billing['country']) . "&";
        $query .= "phone=" . urlencode($this->billing['phone']) . "&";
        $query .= "fax=" . urlencode($this->billing['fax']) . "&";
        $query .= "email=" . urlencode($this->billing['email']) . "&";
        $query .= "website=" . urlencode($this->billing['website']) . "&";
        // Shipping Information
        $query .= "shipping_firstname=" . urlencode($this->shipping['firstname']) . "&";
        $query .= "shipping_lastname=" . urlencode($this->shipping['lastname']) . "&";
        $query .= "shipping_company=" . urlencode($this->shipping['company']) . "&";
        $query .= "shipping_address1=" . urlencode($this->shipping['address1']) . "&";
        $query .= "shipping_address2=" . urlencode($this->shipping['address2']) . "&";
        $query .= "shipping_city=" . urlencode($this->shipping['city']) . "&";
        $query .= "shipping_state=" . urlencode($this->shipping['state']) . "&";
        $query .= "shipping_zip=" . urlencode($this->shipping['zip']) . "&";
        $query .= "shipping_country=" . urlencode($this->shipping['country']) . "&";
        $query .= "shipping_email=" . urlencode($this->shipping['email']) . "&";
        $query .= "type=auth";
        return $this->_doPost($query);
    }

    function doCredit($amount, $ccnumber, $ccexp) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        // Order Information
        $query .= "ipaddress=" . urlencode($this->order['ipaddress']) . "&";
        $query .= "orderid=" . urlencode($this->order['orderid']) . "&";
        $query .= "orderdescription=" . urlencode($this->order['orderdescription']) . "&";
        $query .= "tax=" . urlencode(number_format($this->order['tax'],2,".","")) . "&";
        $query .= "shipping=" . urlencode(number_format($this->order['shipping'],2,".","")) . "&";
        $query .= "ponumber=" . urlencode($this->order['ponumber']) . "&";
        // Billing Information
        $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
        $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
        $query .= "company=" . urlencode($this->billing['company']) . "&";
        $query .= "address1=" . urlencode($this->billing['address1']) . "&";
        $query .= "address2=" . urlencode($this->billing['address2']) . "&";
        $query .= "city=" . urlencode($this->billing['city']) . "&";
        $query .= "state=" . urlencode($this->billing['state']) . "&";
        $query .= "zip=" . urlencode($this->billing['zip']) . "&";
        $query .= "country=" . urlencode($this->billing['country']) . "&";
        $query .= "phone=" . urlencode($this->billing['phone']) . "&";
        $query .= "fax=" . urlencode($this->billing['fax']) . "&";
        $query .= "email=" . urlencode($this->billing['email']) . "&";
        $query .= "website=" . urlencode($this->billing['website']) . "&";
        $query .= "type=credit";
        return $this->_doPost($query);
    }

    function doOffline($authorizationcode, $amount, $ccnumber, $ccexp) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
        // Order Information
        $query .= "ipaddress=" . urlencode($this->order['ipaddress']) . "&";
        $query .= "orderid=" . urlencode($this->order['orderid']) . "&";
        $query .= "orderdescription=" . urlencode($this->order['orderdescription']) . "&";
        $query .= "tax=" . urlencode(number_format($this->order['tax'],2,".","")) . "&";
        $query .= "shipping=" . urlencode(number_format($this->order['shipping'],2,".","")) . "&";
        $query .= "ponumber=" . urlencode($this->order['ponumber']) . "&";
        // Billing Information
        $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
        $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
        $query .= "company=" . urlencode($this->billing['company']) . "&";
        $query .= "address1=" . urlencode($this->billing['address1']) . "&";
        $query .= "address2=" . urlencode($this->billing['address2']) . "&";
        $query .= "city=" . urlencode($this->billing['city']) . "&";
        $query .= "state=" . urlencode($this->billing['state']) . "&";
        $query .= "zip=" . urlencode($this->billing['zip']) . "&";
        $query .= "country=" . urlencode($this->billing['country']) . "&";
        $query .= "phone=" . urlencode($this->billing['phone']) . "&";
        $query .= "fax=" . urlencode($this->billing['fax']) . "&";
        $query .= "email=" . urlencode($this->billing['email']) . "&";
        $query .= "website=" . urlencode($this->billing['website']) . "&";
        // Shipping Information
        $query .= "shipping_firstname=" . urlencode($this->shipping['firstname']) . "&";
        $query .= "shipping_lastname=" . urlencode($this->shipping['lastname']) . "&";
        $query .= "shipping_company=" . urlencode($this->shipping['company']) . "&";
        $query .= "shipping_address1=" . urlencode($this->shipping['address1']) . "&";
        $query .= "shipping_address2=" . urlencode($this->shipping['address2']) . "&";
        $query .= "shipping_city=" . urlencode($this->shipping['city']) . "&";
        $query .= "shipping_state=" . urlencode($this->shipping['state']) . "&";
        $query .= "shipping_zip=" . urlencode($this->shipping['zip']) . "&";
        $query .= "shipping_country=" . urlencode($this->shipping['country']) . "&";
        $query .= "shipping_email=" . urlencode($this->shipping['email']) . "&";
        $query .= "type=offline";
        return $this->_doPost($query);
    }

    function doCapture($transactionid, $amount =0) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Transaction Information
        $query .= "transactionid=" . urlencode($transactionid) . "&";
        if ($amount>0) {
            $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        }
        $query .= "type=capture";
        return $this->_doPost($query);
    }

    function doVoid($transactionid) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Transaction Information
        $query .= "transactionid=" . urlencode($transactionid) . "&";
        $query .= "type=void";
        return $this->_doPost($query);
    }

    function doRefund($transactionid, $amount = 0) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Transaction Information
        $query .= "transactionid=" . urlencode($transactionid) . "&";
        if ($amount>0) {
            $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        }
        $query .= "type=refund";
        return $this->_doPost($query);
    }

    function _doPost($query) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.edataexecutivegateway.com/api/transact.php");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_POST, 1);

        if (!($data = curl_exec($ch))) {
            return ERROR;
        }
        curl_close($ch);
        unset($ch);
        //print "\n$data\n";
        $data = explode("&",$data);
        for($i=0;$i<count($data);$i++) {
            $rdata = explode("=",$data[$i]);
            $this->responses[$rdata[0]] = $rdata[1];
        }       
        return $this->responses['response'];
    }

 function doSaleSubscription($amount, $vault_id, $billing_id, $subscription, $ip_addr) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        //$query .= "dup_seconds=5&";
        $query .= "merchant_defined_field_2=" . urlencode($subscription) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        // Order Information
        $query .= "type=sale";
        return $this->_doPost($query);
    }


    function doSaleHybridSubscription($vault_id, $ccnumber, $ccexp, $cvv, $billing_id,   $firstname, $lastname, $address1, $address2, $city, $state, $zip, $country, $phone,$transactionType,$priority,$ip_addr, $amount, $subscription,$status=null, $xid=null,$eci=null,$cavv=null) {


        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "cvv=" . urlencode($cvv) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "customer_vault=" . urlencode($transactionType) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "firstname=" . urlencode($firstname) . "&";
        $query .= "lastname=" . urlencode($lastname) . "&";
        $query .= "address1=" . urlencode($address1) . "&";
        $query .= "address2=" . urlencode($address2) . "&";
        $query .= "city=" . urlencode($city) . "&";
        $query .= "state=" . urlencode($state) . "&";
        $query .= "zip=" . urlencode($zip) . "&";
        $query .= "country=" . urlencode($country) . "&";
        $query .= "phone=" . urlencode($phone) . "&";
        $query .= "priority=" . urlencode($priority) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        //$query .= "dup_seconds=0&";
        $query .= "merchant_defined_field_2=" . urlencode($subscription) . "&";



        if (!empty($status)) {
            switch ($status)
            {
                case 'Y':
                    $query .= "cardholder_auth=" . urlencode('verified') . "&";
                    break;
                case 'A':
                    $query .= "cardholder_auth=" . urlencode('attempted') . "&";
                    break;
            }

        }

        if (!empty($xid)) {
            $query .= "xid=" . urlencode($xid) . "&";
        }
        if (!empty($eci)) {
            $query .= "eci=" . urlencode($eci) . "&";
        }
        if (!empty($cavv)) {
            $query .= "cavv=" . urlencode($cavv) . "&";
        }

        $query .= "type=sale";
        return $this->_doPost($query);
    }

 	
    function doDeposit($amount, $vault_id, $billing_id, $ip_addr , $processor) {

        $query  = "";
        $amount_to_pay = $this->getAmount($amount);
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        // Sales Information
        $query .= "customer_vault_id=" . urlencode($vault_id) . "&";
        $query .= "amount=" . number_format($amount_to_pay,2) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        //$query .= "dup_seconds=5&";
        //$query .= "processor_id=".$processor."&";
        //$query .= "merchant_defined_field_1=" . urlencode($reservation_serie) . "&";
        $query .= "ipaddress=" . urlencode($ip_addr) . "&";
        // Order Information
        $query .= "type=credit";
        return $this->_doPost($query);
    }


    function updateDepositAccount($billing_id, $deposit_account) {

        $query  = "";
        // Login Information
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";


        $query .= "customer_vault=". urlencode('update_customer') . "&";
        $query .= "customer_vault_id=" .urlencode(1) . "&";
        $query .= "billing_id=" . urlencode($billing_id) . "&";
        $query .= "checkname=" . urlencode($deposit_account['account_name']) . "&";

        if($deposit_account['account_routing']){
            $query .= "checkaba=" . urlencode($deposit_account['account_routing']) . "&";
        }

        if($deposit_account['account_number']){
            $query .= "checkaccount=" . urlencode($deposit_account['account_number']) . "&";
        }
        
       
        $query .= "account_type=" . urlencode($deposit_account['account_type']) . "&";  
       
        return $this->_doPost($query);
    }
    function buy_credits_apple_pay($data,$amount,$billingDetails,$more_data){


        $query = "username=Psychics1on1GET1&";
        $query .= "password=Telx5727!!&";
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
        $query .= "zip=".$billingDetails['postalCode']."&";
        $query .= "firstname=".$billingDetails['givenName']."&";
        $query .= "lastname=".$billingDetails['familyName']."&"; 
        $query .= "cvv=111&";
        $query .=  "applepay_payment_data=".bin2hex(json_encode($data)). "&";



        $query .= "address1=" . urlencode($billingDetails['addressLines'][0]) . "&";
        $query .= "city=" . urlencode($billingDetails['locality']) . "&";
        $query .= "state=" . urlencode($billingDetails['administrativeArea']) . "&";
        $query .= "country=" . urlencode($billingDetails['country']) . "&"; 
        //$query .= "customer_vault_id=" . urlencode($more_data['vault_id']) . "&";
        //$query .= "customer_vault=" . urlencode($more_data['transaction_type']) . "&";
        $query .= "billing_id=" . urlencode($more_data['billing_id']) . "&";
        $query .= "ipaddress=" . urlencode($more_data['ip']) . "&";       
        $query .= "merchant_defined_field_1=" . urlencode($more_data['order_id']) . "&";
        $query .= "type=sale";

        return $this->_doPost($query);


    }





}