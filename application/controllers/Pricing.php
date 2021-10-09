<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 2018-10-24
 * Time: past 3:02
 */

require APPPATH . '/libraries/BaseController.php';

class Pricing  extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('User_model');
        $this->load->model('Settings_model');
        $this->load->model('Translate_model');
        $this->load->helper(array('cookie', 'string', 'language', 'url'));
        $this->load->helper('lms_email');
        $this->load->model('Plan_model');
        $this->load->library("paypal");
        $this->load->model('Company_model');
        $this->load->model('Payment_model');
      
    	$this->config->load('paypal');
    }

    public function index()
    {
        $this->showPricing();
/*        if($this->session->userdata('user_type') === 'Admin'){
            
        }else{
            redirect('/');
        }*/
    }

    public function showPricing(){

        $headerInfo['menu_name'] = 'pricing';
        $headerInfo['plans_month'] = $this->Plan_model->all(array("term_type"=>0,"price_type"=>0));
        $headerInfo['plans_year'] = $this->Plan_model->all(array("term_type"=>1,"price_type"=>0));
        $headerInfo['plans_trial'] = $this->Plan_model->one(array("price_type"=>1));
        $headerInfo['plans_unlimit'] = $this->Plan_model->one(array("price_type"=>2));
        $headerInfo['limit_types'] = array('user_limit'=>'Users',
                                           'library_limit'=>'Library',
                                           'demand_limit'=>'On Demand',
                                           'vilt_user_limit'=>'VILT Room User',
                                           'vilt_room_limit'=>'VILT Room'
                                            );

       // adding product  id to monthly plans 
        foreach($headerInfo['plans_month'] as $key => $val) {
            if($val->name === "Begining") {
                $val->productId = 624;
            }
            if($val->name === "Silver") {
                $val->productId = 626;
            }
            if($val->name === "Gold") {
                $val->productId = 627;
            }
        }

        // adding product  id to yearly plans 
        foreach($headerInfo['plans_year'] as $key => $val) {
            if($val->name === "Begining") {
                $val->productId = 632;
            }
            if($val->name === "Silver") {
                $val->productId = 632;
            }
            if($val->name === "Gold") {
                $val->productId = 633;
            }
        }

        //print_r($headerInfo['plans_month']);
        $headerInfo[term] = $this->term;
        $this->loadViews_front('pricing', $headerInfo);
    }
    public function payment($id, $type){
        
        $this->isLoggedIn();
        $user = $this->session->userdata();
        
        if($type == 'plan'){

            $plan = $this->Plan_model->select($id);
            $data['title'] = $plan->name;
            $data['description'] = "";
            $data['tax'] = $this->Settings_model->getTaxRate()->value;
            $data['discount'] = $this->Company_model->getRow($user['company_id'])->discount;
            
            $data['price'] = $plan->price;
            $data['sub_total'] = $plan->price * (100 - $data['discount'])/100;
            $data['discount_amount'] = $data['price'] * ($data['discount'])/100;
            $data['tax_amount'] = $data['sub_total'] * ($data['tax'])/100;
            $data['total'] = $data['sub_total'] * (100 + $data['tax'])/100;
            $data['tax_type'] = "%";
           
        }else if($type == 'course'){
            $this->load->model('Course_model');

            $course = $this->Course_model->select($id);
            $data['title'] = $course->title;
            $data['description'] = $course->desciption;
            
            $data['discount'] = $course->discount;
            
            $data['price'] = $course->price;
            $data['sub_total'] = $course->price * (100 - $data['discount'])/100;
            $data['discount_amount'] = $data['price'] * ($data['discount'])/100;
            $data['tax'] = $course->tax_rate;
            if($course->tax_type == 0){
                $data['tax_amount'] = $data['sub_total'] * ($data['tax'])/100;
                $data['tax_type'] = "%";
            }else{
                $data['tax_type'] = "$";
                $data['tax_amount'] = $data['sub_total'] + $data['tax'];
            }
            
            $data['total'] = $course->amount;
        }else{

        }
        $data['type'] = $type;
        $data['id'] = $id;
        $this->loadViews_front('payment', $data);
    }
    public function paypalPayment(){
        $filter = $this->input->post();
        if($filter['type'] == "plan"){
            $clientId = $this->Settings_model->getPaypalClientId()->value;
            $secretId = $this->Settings_model->getPaypalSecretId()->value;
            $this->config->set_item('client_id', $clientId);
            $this->config->set_item('client_secret', $secretId);
            $plan = $this->Plan_model->select($filter['id']);
            $data['title'] = $plan->name;
            $data['tax'] = $this->Settings_model->getTaxRate()->value;
            $data['discount'] = $this->Company_model->getRow($user['company_id'])->discount;
            
            $data['sub_total'] = $plan->price * (100 - $data['discount'])/100;
            $data['total'] = $data['sub_total'] * (100 + $data['tax'])/100;
        }else if($filter['type'] == "course"){

        }else{

        }
        $this->paypal->set_api_context();
        $payment_method = "paypal";
		$return_url     = base_url()."pricing/success_payment/".$filter['id']."/".$filter['type']."/paypal";
		$cancel_url     = base_url()."pricing/cancel";
		$total          = $data['total'];
		$description    = $data['title'];
		$intent         = 'sale';

		$this->paypal->create_payment( $payment_method, $return_url, $cancel_url, 
        $total, $description, $intent );
    }
    function success_payment($id, $type, $payment_method){
        $user = $this->session->userdata();
        $data['user_id'] = $user['user_id'];
        $data['pay_date'] = date("Y-m-d H:s:i");
        $data['company_id'] = $user['company_id'];
        $data['payment_method'] = $payment_method;
        $data['object_type'] = $type;
        $data['object_id'] = $id;
        if($type == "plan"){
            $plan = $this->Plan_model->select($id);
            $data['description'] = $plan->name;
            $data['tax_rate'] = $this->Settings_model->getTaxRate()->value;
            $data['tax_type'] = "0";

            $data['discount'] = $this->Company_model->getRow($user['company_id'])->discount;
            
            $data['price'] = $plan->price;
            
            $sub_total = $plan->price * (100 - $data['discount'])/100;
            $data['amount'] = $sub_total * (100 + $data['tax_rate'])/100;
            
        }else if($type == "course"){

        }else{
            
        }
        if($payment_method == "paypal"){
            if ( !empty( $_GET['paymentId'] ) && !empty( $_GET['PayerID'] ) ) {
                // $this->paypal->execute_payment( $_GET['paymentId'], $_GET['PayerID'] );
                $insert = $this->Payment_model->save($data);
                $this->loadViews_front('payment_success', $data);
            }
        }
    }
    public function cancel(){

    }
    public function stripePayment(){
        if($data['type'] == "plan"){

        }else if($data['type'] == "course"){

        }else{
            
        }
    }
    public function add_purchase($plan_id = 0){
        if($this->session->userdata('user_type') === 'Admin'){
            $plan = $this->Plan_model->select($plan_id);
            $is_trialed = $this->session->userdata('is_trialed');
            if($plan->price_type == 1 && $is_trialed == 1){
                $result['success'] = false;
                $result['msg'] = "You have already selected a trial subscription!";
                $this->response($result);
            }
            if($plan->term_type == 0){
                $expired = date('Y-m-d', strtotime($date . ' + 30 days'));  
            }
            if($plan->term_type == 1){
                $expired = date('Y-m-d', strtotime($date . ' + 365 days')); 
            }

            if($plan->price_type == 1){
                $expired = date('Y-m-d', strtotime($date . ' + 15 days'));  
                $this->User_model->update(array('plan_id'=>$plan_id,'is_trialed'=>1,'expired'=>$expired),array('id'=>$this->session->userdata('userId')));
                $this->session->set_userdata(array('plan_id'=>$plan_id,'is_trialed'=>1,'expired'=>$expired));
            }else{
                //payment action

                //After payment action
                $this->User_model->update(array('plan_id'=>$plan_id,'expired'=>$expired),array('id'=>$this->session->userdata('userId')));
                $this->session->set_userdata(array('plan_id'=>$plan_id,'expired'=>$expired));
            }
            $result['success'] = true;
            $this->response($result);
        }else{
            $result['success'] = false;
            $this->response($result);
        }
    }
}