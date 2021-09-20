<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/PHPExcel.php';
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
    public function __construct() {
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
        $this->isLoggedIn();
    }
    /**
     * This function used to load the first screen of the user
     */
    public function index() {
        $this->admin_view();
    }

    public function edit_view($row_id = 0) {
        $this->load->library('Sidebar');
        $lang_ar = $this->Translate_model->getLanguageList(array('active_flag' => 1, 'add_flag' => 1));
        $page_data['lang_ar'] = $lang_ar['data'];
        $side_params = array('selected_menu_id' => '2');
        $this->global['sidebar'] = $this->sidebar->generate($side_params, $this->role);
        if($this->isSuperAdmin()){
            $page_path = "superadmin/user/admin_edit";
            if ($row_id != 0) {
                $user_data = $this->User_model->getList(array('id' => $row_id)) [0];
                unset($user_data['password']);
				$user_data['country_list'] = $this->Countries_model->getList();
            } else {
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
                $user_data['plan_id'] = '';
				$user_data['country_list'] = $this->Countries_model->getList();
            }
            $user_data['company_data'] = $this->Company_model->getAll();
            $user_data['plans'] = $this->Plan_model->all();
            $this->loadViews($page_path, $this->global, $user_data, NULL);
        }else{
            $this->loadViews("access", $this->global, NULL, NULL); 
        }
    }

    public function admin_view() {
        $this->load->library('Sidebar');
        $side_params = array('selected_menu_id' => '2');
        $this->global['sidebar'] = $this->sidebar->generate($side_params, $this->role);
        if($this->isSuperAdmin()){
            $this->loadViews("superadmin/user/admin_list", $this->global, NULL, NULL);
        }else{
            $this->loadViews("access", $this->global, NULL, NULL); 
        }
    }
    /**
     * This function used to load All admin-user list
     */
    public function getData() {
        $table_data['data'] = $this->User_model->getList(array('user_type' => 'Admin'));
        foreach ($table_data['data'] as $key => $row) {
            $table_data['data'][$key]["no"] = $key + 1;
        }
        $this->response($table_data);
    }
    /**
     * This function used to load All admin-user list for select2
     */
    public function insert() {
        $insert_data = array();
        $upload_path = sprintf('%suser/photo/', PATH_UPLOAD);
        if (!file_exists($upload_path)) {
            $this->makeDirectory($upload_path);
        }
        $rslt = $this->doUpload('picture', $upload_path);
        if ($rslt['possible'] == 1) {
            $insert_data['picture'] = str_replace("./", "", $rslt['path']);
        } else $insert_data['picture'] = str_replace("./", "", $upload_path . 'default.png');
        foreach ($this->input->post() as $key => $value) {
            $insert_data[$key] = $value;
            if ($key == 'active') {
                $insert_data[$key] = $value == 'on' ? 1 : 0;
            }
        }
        $same_company_count = $this->User_model->count(array('user_type' => 'Admin', 'company_id' => $insert_data['company_id']));
        if ($same_company_count > 0) {
            $result['msg'] = 'The same administrator of company that you select is already existed!';
            $result['success'] = FALSE;
            $this->response($result);
        }
        $plan_id = $this->input->post('plan_id');
        if (!isset($plan_id) || $plan_id == 0) {
            unset($insert_data['plan_id']);
            $insert_data['is_trialed'] = null;
            $insert_data['expired'] = null;
        } else {
            $plan = $this->Plan_model->select($plan_id);
            if ($plan->price_type == 1) {
                $insert_data['is_trialed'] = 1;
                $expired = date('Y-m-d', strtotime($date . ' + 15 days'));
                $insert_data['expired'] = $expired;
            } else if ($plan->price_type == 0) {
                if ($plan->term_type == 0) {
                    $expired = date('Y-m-d', strtotime($date . ' + 30 days'));
                } else if ($plan->term_type == 1) {
                    $expired = date('Y-m-d', strtotime($date . ' + 365 days'));
                }
                $insert_data['expired'] = $expired;
            }
        }
        unset($insert_data['id']);
        $insert_data['password'] = md5($this->input->post('password'));
        $pool = '0123456789';
        $api_key = substr(str_shuffle(str_repeat($pool, ceil(10 / strlen($pool)))), 0, 10);
        $insert_data['api_key'] = $api_key;
        $user_id = $this->User_model->insert($insert_data);
        $result['msg'] = 'The same administrator of company that you select is already existed!';
        $result['success'] = TRUE;
        $this->response($result);
    }

    public function active() {
        $id = $this->input->post('id');
        $data[active] = 1;
        return $this->User_model->update($data, array('id' => $id));
    }

    public function inactive() {
        $id = $this->input->post('id');
        $data[active] = 0;
        return $this->User_model->update($data, array('id' => $id));
    }

    public function delete() {
        $id = $this->input->post("id");
        $res = $this->User_model->getList(array('id' => $id)) [0];
        $user_type = $res['user_type'];
        if ($this->User_model->delete(array('id' => $id, 'user_type' => $user_type))) $res['status'] = 'Success';
        else $res['status'] = 'Failed';
        return $res;
    }

    public function update() {
        $update_data = array();
        $id = $this->input->post("id");
        $upload_path = sprintf('%suser/photo/', PATH_UPLOAD);
        if (!file_exists($upload_path)) {
            $this->makeDirectory($upload_path);
        }
        $rslt = $this->doUpload('picture', $upload_path);
        if ($rslt['possible'] == 1) {
            $update_data['picture'] = str_replace("./", "", $rslt['path']);
        }
        foreach ($this->input->post() as $key => $value) {
            $update_data[$key] = $value;
            if ($key == 'active') {
                $update_data[$key] = $value == 'on' ? 1 : 0;
            }
        }
        $same_company_count = $this->User_model->count(array('id !=' => $id, 'user_type' => 'Admin', 'company_id' => $update_data['company_id']));
        if ($same_company_count > 0) {
            $result['msg'] = 'The same administrator of company that you select is already existed!';
            $result['success'] = FALSE;
            $this->response($result);
        }
        $plan_id = $this->input->post('plan_id');
        if (!isset($plan_id) || $plan_id == 0) {
            $update_data['plan_id'] = null;
            $update_data['is_trialed'] = null;
            $update_data['expired'] = null;
        } else {
            $plan = $this->Plan_model->select($plan_id);
            if ($plan->price_type == 1) {
                $update_data['is_trialed'] = 1;
                $expired = date('Y-m-d', strtotime($date . ' + 15 days'));
                $update_data['expired'] = $expired;
            } else if ($plan->price_type == 0) {
                if ($plan->term_type == 0) {
                    $expired = date('Y-m-d', strtotime($date . ' + 30 days'));
                } else if ($plan->term_type == 1) {
                    $expired = date('Y-m-d', strtotime($date . ' + 365 days'));
                }
                $update_data['expired'] = $expired;
            }
        }
        if ($this->input->post('password') == '') {
            unset($update_data['password']);
        } else {
            $update_data['password'] = md5($this->input->post('password'));
        }
        $this->User_model->update($update_data, array('id' => $id));
        $result['msg'] = 'Success!';
        $result['success'] = TRUE;
        $this->response($result);
    }

    function checkemailexist() {
        $id = $this->input->post(id);
        $email = $this->input->post('email');
        $exist = $this->User_model->getfrEmail($id, $email);
        $data[success] = $exist == 0;
        $this->response($data);
    }

}
?>