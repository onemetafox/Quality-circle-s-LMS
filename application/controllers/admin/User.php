<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
// require APPPATH . '/third_party/PHPExcel.php';

/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 6/27/2018
 * Time: 6:07 PM
 */
class User extends BaseController {
    /**
     * This is default constructor of the class
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Certification_model');
        $this->load->model('Notification_model');
        $this->load->model('Company_model');
        $this->load->model('Examassignemployee_model');
        $this->load->model('Exam_model');
        $this->load->model('Translate_model');
        $this->load->model('Plan_model');
		$this->load->model('Countries_model');	
        $this->load->model('Location_model');		
        $this->isLoggedIn();
    }
    /**
     * This function used to load the first screen of the user
     */
    public function index(){
        $this->admin_view();
    }
    
    public function check_add_view(){
        $plan_id = $this->session->userdata('plan_id');
        $company_id = $this->session->userdata('company_id');
        $plan = $this->Plan_model->select($plan_id);
        if(empty($plan)){
            $result['msg'] = "You could not add users! Select a subscription!";
            $result['success'] = false;
        }else{
            if($plan->price_type == 2){
                $result['msg'] = "";
                $result['success'] = true;
            }else{
                $filter = array("company_id" => $company_id, "user_type !=" => "Admin", "is_deleted" => 0);
                $user_count = $this->User_model->count($filter);
                $user_limit = $plan->user_limit;
                if($user_count >= $user_limit){
                    if($user_limit == 1) $view_msg = 'user';
                    else $view_msg = 'users';
                    $result['msg'] = "You could not add more than " . $user_limit . " " . $view_msg . "! Select a subscription!";
                    $result['success'] = false;
                }else{
                    $result['msg'] = "";
                    $result['success'] = true;
                }
            }
        }
        $this->response($result);
    }

    public function edit_view($row_id = 0){
        $this->load->library('Sidebar');
        if($this->isMasterAdmin()){
            $lang_ar = $this->Translate_model->getLanguageList(array('active_flag' => 1, 'add_flag' => 1));
            $page_data['lang_ar'] = $lang_ar['data'];
            $side_params = array('selected_menu_id' => '2');
            $this->global['sidebar'] = $this->sidebar->generate($side_params, $this->role);
            $page_path = "admin/user/admin_edit";
            $this->global['countries'] = $this->Location_model->getAllCounties();
            if($row_id != 0){
                $user_data = $this->User_model->getList(array('id' => $row_id)) [0];
                unset($user_data['password']);
				$user_data['country_list'] = $this->Countries_model->getList();
                $this->global['states'] = $this->Location_model->getStateByCountryId($user_data["country"]);
                $this->global['cities'] = $this->Location_model->getCityByStateId($user_data["state"]);
            }else{
                $user_data['id'] = 0;
                $user_data['first_name'] = '';
                $user_data['last_name'] = '';
                $user_data['password'] = '';
                $user_data['email'] = '';
                $user_data['reg_date'] = '';
                $user_data['organization'] = '';
                $user_data['manager'] = '';
                $user_data['about_me'] = '';
                $user_data['address1'] = '';
                $user_data['address2'] = '';
                $user_data['phone'] = '';
                $user_data['city'] = '';
                $user_data['state'] = '';
                $user_data['zip_code'] = '';
                $user_data['country'] = '';
                $user_data['picture'] = '';
                $user_data['user_type'] = '';
                $user_data['active'] = 1;
                $user_data['company_id'] = '';
				$user_data['country_list'] = $this->Countries_model->getList();
               
            }
            $this->loadViews($page_path, $this->global, $user_data, NULL);
        }else {
            $this->global['sidebar'] = $this->sidebar->generate();
            $this->loadViews("access", $this->global, NULL , NULL);   
        }
    }
    
    public function admin_view(){
        $this->load->library('Sidebar');
        if($this->isMasterAdmin()){
            $side_params = array('selected_menu_id' => '2');
            $this->global['sidebar'] = $this->sidebar->generate($side_params, $this->role);
            $this->loadViews("admin/user/admin_list", $this->global, NULL, NULL);
        }else {
            $this->global['sidebar'] = $this->sidebar->generate();
            $this->loadViews("access", $this->global, NULL , NULL);   
        }
    }
    /**
     * This function used to load All admin-user list
     */
    public function getData(){
        //$type = $this->input->post("type");
        $table_data['data'] = $this->User_model->getList(array('company_id' => $this->session->get_userdata() ['company_id'], 'user_type !=' => 'Admin'));
        foreach ($table_data['data'] as $key => $row){
            $table_data['data'][$key]["no"] = $key + 1;
			$table_data['data'][$key]["picture"] = NULL;
			$imgName = end(explode('/', $row['picture']));
			if($imgName != '' && file_exists(getcwd().'/assets/uploads/user/photo/'.$imgName)){
				$table_data['data'][$key]["picture"] = $row['picture'];		
			}			
        }
        $this->response($table_data);
    }
    /**
     * This function used to load All admin-user list for select2
     */
    public function insert(){
        $insert_data = array();
        $upload_path = sprintf('%suser/photo/', PATH_UPLOAD);
        if(!file_exists($upload_path)){
            $this->makeDirectory($upload_path);
        }
        $rslt = $this->doUpload('picture', $upload_path);
        if($rslt['possible'] == 1){
            $insert_data['picture'] = str_replace("./", "", $rslt['path']);
        } else $insert_data['picture'] = str_replace("./", "", $upload_path . 'default.png');
        foreach ($this->input->post() as $key => $value){
            $insert_data[$key] = $value;
            if($key == 'active'){
                $insert_data[$key] = $value == 'on' ? 1 : 0;
            }
        }
        if(!isset($insert_data['active'])) $insert_data['active'] = 0;
        unset($insert_data['id']);
        $insert_data['password'] = md5($this->input->post('password'));
        $insert_data['company_id'] = $this->session->get_userdata() ['company_id'];
		if($insert_data['user_type'] == 'Instructor'){
			$insert_data['plan_id'] = $this->session->get_userdata() ['plan_id'];
		}
        $pool = '0123456789';
        $api_key = substr(str_shuffle(str_repeat($pool, ceil(10 / strlen($pool)))), 0, 10);
        $insert_data['api_key'] = $api_key;
        $user_id = $this->User_model->insert($insert_data);
        return $user_id;
    }
    
    public function active(){
        $id = $this->input->post('id');
        $data[active] = 1;
        return $this->User_model->update($data, array('id' => $id));
    }
    
    public function inactive(){
        $id = $this->input->post('id');
        $data[active] = 0;
        return $this->User_model->update($data, array('id' => $id));
    }
    
    public function delete(){
        $id = $this->input->post("id");
        $res = $this->User_model->getList(array('id' => $id)) [0];
        $user_type = $res['user_type'];
        if($this->User_model->delete(array('id' => $id, 'user_type' => $user_type))) $res['status'] = 'Success';
        else $res['status'] = 'Failed';
        return $res;
    }
    
    public function update(){
		$this->load->library('form_validation');
        $this->form_validation->set_rules('country_code', 'Country Code', 'required|numeric');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric');
		
		if($this->form_validation->run() == FALSE){
            $data['errors'] = $this->form_validation->error_array();
			$this->session->set_userdata([
				'email' => $this->input->post('password'),
				'role' => $this->input->post('role'),
				'phone' => $this->input->post('phone'),
				'company_name' => $this->input->post('company_name'),
				'country_code' => $this->input->post('country_code'),				
			]);
			$this->loadViews("admin_edit", $this->global, NULL, NULL);
						
		}else{			
			
			$update_data = array();
			$id = $this->input->post("id");
			$upload_path = sprintf('%suser/photo/', PATH_UPLOAD);
			$user_profile = "profile" == $this->input->post('type_update');
			if(!file_exists($upload_path)){
				$this->makeDirectory($upload_path);
			}
			$rslt = $this->doUpload('picture', $upload_path);
			if($rslt['possible'] == 1){
				$update_data['picture'] = str_replace("./", "", $rslt['path']);
			}
			foreach ($this->input->post() as $key => $value){
				//if($key == 'type_update') continue;
				$update_data[$key] = $value;
				if($key == 'active'){
					$update_data[$key] = $value == 'on' ? 1 : 0;
				}
			}
			if($this->input->post('password') == ''){
				unset($update_data['password']);
			}else{
				$update_data['password'] = md5($this->input->post('password'));
			}			
			$update_data['role'] = $this->input->post('role');
			$update_data['country_code'] = $this->input->post('country_code');
			$update_data['phone'] = $this->input->post('phone');
            $update_data['country'] = $this->input->post('country');
			$update_data['state'] = $this->input->post('state');
			$update_data['city'] = $this->input->post('city');
			unset($update_data['company_name']);
			$company_name = $this->input->post('company_name');
			$update_data['sign'] = $this->input->post('sign');			
			$this->session->set_userdata('country_code', $update_data['country_code']);
			$this->session->set_userdata('phone', $update_data['phone']);
			$this->session->set_userdata('email', $update_data['email']);
			if($user_profile && isset($update_data[picture])) $this->session->set_userdata('user_photo', base_url() . $update_data[picture]);			
			$this->session->set_userdata('role', $update_data['role']);
			$this->Company_model->update(array('name' => $company_name), array('id' => $this->session->userdata('company_id')));
			return $this->User_model->update($update_data, array('id' => $id));
		}
    }

    function checkemailexist(){
        $id = $this->input->post(id);
        $email = $this->input->post('email');
        $exist = $this->User_model->getfrEmail($id, $email);
        $data[success] = $exist == 0;
        $this->response($data);
    }
	
}
?>