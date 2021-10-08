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
        if($type == 'plan'){

        }else if($type == 'course'){

        }else{
            
        }
        $this->loadViews_front('payment');
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