<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 10/28/2018
 * Time: 9:45 AM
 */
class Live extends BaseController {
    /**
     * This is default constructor of the class
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('Live_model');
        $this->load->model('User_model');
        $this->load->model('Category_model');
        $this->load->model('Course_model');
        $this->load->model('Certification_model');
        $this->load->model('Exam_model');
        $this->isLoggedIn();
    }
    /**
     * This function used to load the default screen of trainingassign menu
     */
    public function index(){
        $this->showLive();
    }
    
    public function detail_course($row_id = 0){
        $page_path = "instructor/live/detail_course";
        //$course = $this->Course_model->select($row_id);
        $course = $this->Live_model->getListById($row_id, $this->session->get_userdata() ['company_id']) [0];
        //$this->global['libraries'] = $this->Course_model->getLibrary($row_id);
        $this->global['libraries'] = $this->Live_model->getLibrary($row_id);
        $this->global['course_name'] = $course->title;
        $this->global['course_id'] = $row_id;
        $this->load->view($page_path, $this->global);
        //        $this->loadViews($page_path, $this->global, NULL , NULL);        
    }

    public function addLive(){
        $course_data['id'] = $this->input->post('id');
        $course_data['title'] = $this->input->post('title');
        $course_data['subtitle'] = $this->input->post('subtitle');
        $course_data['duration'] = $this->input->post('duration');
        $course_data['about'] = $this->input->post('about');
        $course_data['objective'] = $this->input->post('objective');
        $course_data['attend'] = $this->input->post('attend');
        $course_data['agenda'] = $this->input->post('agenda');
        $course_data['user_type'] = $this->input->post('user_type');
		$course_data['course_type'] = 1;
        $course_data['pay_type'] = $this->input->post('pay_type');
        $course_data['record_type'] = $this->input->post('record_type');
        $course_data['pay_price'] = $this->input->post('pay_price');
		//$course_data['startday'] = $this->input->post('startday');
		//$course_data['endday'] = $this->input->post('endday');
		if(!empty($this->input->post('number'))){
		$newstring = preg_replace('~[^A-Za-z0-9 ?.!]~','',$this->input->post('number'));
		$return = '';
		foreach(explode(' ', $newstring) as $word){
			$return .= strtoupper($word[0]);
		}
		$course_data['number'] = $return.'_'.$course_data['id'];
		}
        // $course_data['category_id'] = $this->input->post('category_id');
		$course_data['category'] = $this->input->post('category');
        $course_data['course_id'] = $this->input->post('category_id');
        $course_data['url'] = $this->input->post('vilt_url');
        if($course_data['pay_price'] == null){
            $course_data['pay_price'] = 0;
        }
        $course_data['create_id'] = $this->session->get_userdata() ['company_id'];
        $upload_path = sprintf('%slive/%d/', PATH_UPLOAD, $this->input->post('id'));
        if(!file_exists($upload_path)){
            $this->makeDirectory($upload_path);
        }
        $rslt = $this->doUpload('img_path', $upload_path);
        if($rslt['possible'] == 1){
            $course_data['img_path'] = str_replace("./", "", $rslt['path']);
        } else $course_data['img_path'] = str_replace("./", "", "assets/img/" . 'default.png');
		
		$course_data['objective_img'] = $this->input->post('objective_img_previous');
		if($_FILES['objective_img']['name'] != ''){
			$upload_path = sprintf('%slive/%d/', PATH_UPLOAD, $this->input->post('id'));
			if(!file_exists($upload_path)){
				$this->makeDirectory($upload_path);
			}
			$rslt = $this->doUpload('objective_img', $upload_path);		
			if($rslt['possible'] == 1){
				if(!empty($courseData->objective_img)){
					if(file_exists($courseData->objective_img)){
						unlink($courseData->objective_img);
					}
				}
				$course_data['objective_img'] = str_replace("./", "", $rslt['path']);
			}else $course_data['objective_img'] = str_replace("./", "", "assets/img/" . 'default.png');		
		}
		
		$courseData = $this->Course_model->select($course_data['id']);		
		$course_data['attend_img'] = $this->input->post('attend_img_previous');
		if($_FILES['attend_img']['name'] != ''){
			$upload_path = sprintf('%slive/%d/', PATH_UPLOAD, $this->input->post('id'));
			if(!file_exists($upload_path)){
				$this->makeDirectory($upload_path);
			}
			$rslt = $this->doUpload('attend_img', $upload_path);		
			if($rslt['possible'] == 1){
				if(!empty($courseData->attend_img)){
					if(file_exists($courseData->attend_img)){
						unlink($courseData->attend_img);
					}
				}
				$course_data['attend_img'] = str_replace("./", "", $rslt['path']);
			}else $course_data['attend_img'] = str_replace("./", "", "assets/img/" . 'default.png');		
		}
		$course_data['agenda_img'] = $this->input->post('agenda_img_previous');
		if($_FILES['agenda_img']['name'] != ''){
			$upload_path = sprintf('%slive/%d/', PATH_UPLOAD, $this->input->post('id'));
			if(!file_exists($upload_path)){
				$this->makeDirectory($upload_path);
			}
			$rslt = $this->doUpload('agenda_img', $upload_path);		
			if($rslt['possible'] == 1){
				if(!empty($courseData->agenda_img)){
					if(file_exists($courseData->agenda_img)){
						unlink($courseData->agenda_img);
					}
				}
				$course_data['agenda_img'] = str_replace("./", "", $rslt['path']);
			}else $course_data['agenda_img'] = str_replace("./", "", "assets/img/" . 'default.png');		
		}
		
        $startday = date('Y-m-d');
        $starttime = $this->input->post('starttime');
        $timestamp = strtotime($startday . ' ' . $starttime);
        $start_at = date('Y-m-d H:i:s', $timestamp);
        $course_data['instructors'] = json_encode($this->input->post('instructor[]'));
		$course_data['standard_id'] = json_encode($this->input->post('standard_id[]'));
        $course_data['enroll_users'] = json_encode($this->input->post('user[]'));
		$myHighlights = array_filter($this->input->post('highlights[]'));
		$highlights = json_encode($myHighlights);
        $course_data['highlights'] = $highlights;
        if($course_data['id'] == 0){
            $row_id = $this->Live_model->insert_course($course_data);
            $course_time['virtual_course_id'] = $row_id;
            $course_time['start_at'] = $start_at;
            $this->Live_model->insert_time($course_time);
			
			if(!empty($_REQUEST['number'])){
				$newstring = preg_replace('~[^A-Za-z0-9 ?.!]~','',$this->input->post('number'));
				$return = '';
				foreach(explode(' ', $newstring) as $word){
					$return .= strtoupper($word[0]);
				}
				$course_datas['number'] = $return.'_'.$row_id;
			}
			$this->Live_model->update_course($course_datas, $row_id);
        }else{
            unset($course_data['id']);
            $this->Live_model->update_course($course_data, $this->input->post('id'));
            $row_id = $course_data['id'];
        }
        $this->index();        
    }
    
    public function editLive($id = 0){
        $this->load->library('Sidebar');
        $side_params = array('selected_menu_id' => '6');
        $this->global['sidebar'] = $this->sidebar->generate($side_params, $this->role);
        if($this->isInstructor()){
            $page_path = "instructor/live/live_edit";
            if($id != 0){
                $live_data = $this->Live_model->getListById($id, $this->session->get_userdata() ['company_id']) [0];
                $live_data['id'] = $id;
                $live_data['category_id'] = $live_data['course_id'];
                $live_data['vilt_url'] = $live_data['url'];
            }else{
                $live_data['id'] = 0;
                $live_data['title'] = '';
                $live_data['subtitle'] = '';
                $live_data['duration'] = '';
                $live_data['about'] = '';
                $live_data['objective'] = '';
                $live_data['attend'] = '';
                $live_data['agenda'] = '';
                $live_data['user_type'] = '';
                $live_data['pay_type'] = '';
                $live_data['record_type'] = '';
                $live_data['pay_price'] = '';
                $live_data['instructors'] = '';
                $live_data['enroll_users'] = '';
                $live_data['create_id'] = '';
                $live_data['category_id'] = 1;
                $live_data['vilt_url'] = '';
            }
            // $live_data['category'] = $this->Category_model->getListByCompanyID($this->session->get_userdata()['company_id']);
			$live_data['category_ids'] = $this->Category_model->getListByCompanyID($this->session->get_userdata() ['company_id']);
            $live_data['categoryCourse'] = $this->Course_model->getAll(array('create_id' => $this->session->get_userdata() ['company_id'], 'course_type' => 1, 'active' => 1));
            $this->loadViews($page_path, $this->global, $live_data, NULL);
        }else{
            $this->loadViews("access", $this->global, null, null);
        }
    }
    
    public function getinstructor(){
        $company_id = $this->session->get_userdata() ['company_id'];
        $table_data = $this->User_model->getInstructor($company_id);
        foreach ($table_data["data"] as $key => $row){
            $table_data["data"][$key]["no"] = $key + 1;
        }
        $records["data"] = $table_data["data"];
        $records['recordsTotal'] = $table_data["total"];
        $records['recordsFiltered'] = $table_data['filtertotal'];
        $this->response($records);
    }
    
    public function getuser(){
        $company_id = $this->session->get_userdata() ['company_id'];
        $table_data = $this->User_model->getUser($company_id);
        foreach ($table_data["data"] as $key => $row){
            $table_data["data"][$key]["no"] = $key + 1;
        }
        $records["data"] = $table_data["data"];
        $records['recordsTotal'] = $table_data["total"];
        $records['recordsFiltered'] = $table_data['filtertotal'];
        $this->response($records);
    }
	
	public function showLiveFilter($course_id = NULL){
        $this->load->library('Sidebar');
        $side_params = array('selected_menu_id' => '6');
        $this->global["sidebar"] = $this->sidebar->generate($side_params, $this->role);
        if($this->isInstructor()){			
            $training_data = array();
            $result_list = $this->Live_model->getListByCompanyId($this->session->get_userdata() ['company_id']);            
			if($course_id != ''){
				$res_id_list = $this->Live_model->getListByCourseId($course_id);
			}else{
				$res_id_list = $this->Live_model->getListCourseId($this->session->get_userdata() ['company_id']);
			}
            foreach ($res_id_list as $key => $row){
                foreach ($result_list as $k => $r){
                    if($r['virtual_course_id'] == $row['id']){
                        $timestamp = strtotime($r['start_at']);
                        $month = date('m', $timestamp);
                        if(!array_key_exists($month, $time_list[$row['id']])) $time_list[$row['id']][$month] = array();
                        array_push($time_list[$row['id']][$month], $r);
                    }
                }
            }
            $res_course_list = array();
            foreach ($res_id_list as $key => $row){
                $instructor = json_decode($row['instructors']) [0];
                $row['instructor_email'] = $this->User_model->getList(array(id => $instructor)) [0]['email'];
                $res_course_list[$row['id']] = $row;
            }
			
            $training_data['course_list'] = $res_course_list;
            $training_data['training_list'] = $time_list;
            //$training_data['category'] = $this->Category_model->getListByCompanyID($this->session->get_userdata()['company_id']);
            $training_data['category'] = $this->Course_model->getAll(array('create_id' => $this->session->get_userdata() ['company_id'], 'course_type' => 1, 'active' => 1));
			$this->loadViews("instructor/live/live_list", $this->global, $training_data, NULL);
        }else{
            $this->loadViews("access", $this->global, NULL , NULL);
        }
    }
    
    public function showLive(){
        $this->load->library('Sidebar');
        $side_params = array('selected_menu_id' => '6');
        $this->global["sidebar"] = $this->sidebar->generate($side_params, $this->role);
        if($this->isInstructor()){
            $training_data = array();
            $result_list = $this->Live_model->getListByCompanyId($this->session->get_userdata() ['company_id']);
            $res_id_list = $this->Live_model->getListCourseId($this->session->get_userdata() ['company_id']);
            $time_list = array();
            foreach ($res_id_list as $key => $row){
                foreach ($result_list as $k => $r){
                    if($r['virtual_course_id'] == $row['id']){
                        $timestamp = strtotime($r['start_at']);
                        $month = date('m', $timestamp);
                        if(!array_key_exists($month, $time_list[$row['id']])) $time_list[$row['id']][$month] = array();
                        array_push($time_list[$row['id']][$month], $r);
                    }
                }
            }
            $res_course_list = array();
            foreach ($res_id_list as $key => $row){
                $instructor = json_decode($row['instructors']) [0];
                $row['instructor_email'] = $this->User_model->getList(array(id => $instructor)) [0]['email'];
                $res_course_list[$row['id']] = $row;
            }
            $training_data['course_list'] = $res_course_list;
            $training_data['training_list'] = $time_list;
            // $live_data['category'] = $this->Category_model->getListByCompanyID($this->session->get_userdata()['company_id']);
            $training_data['category'] = $this->Course_model->getAll(array('create_id' => $this->session->get_userdata() ['company_id'], 'course_type' => 1, 'active' => 1));
            $this->loadViews("instructor/live/live_list", $this->global, $training_data, NULL);
        }else{
            $this->loadViews("access", $this->global, NULL , NULL);
        }
    }
    
    public function deleteTime(){
        $id = $this->input->post('id');
        return $this->Live_model->delete_time($id);
    }
    
    public function add_time(){
        $time = $this->input->post('starttime');
        $day = $this->input->post('startday');
        $timestamp = strtotime($day . ' ' . $time);
        $start_at = date('Y-m-d H:i:s', $timestamp);
        //$location = $this->input->post('change_location');
        $id = $this->input->post('change_id');
        $data['start_at'] = $start_at;
        $data['virtual_course_id'] = $id;
        return $this->Live_model->insert_time($data);
    }
    
    public function update_time(){
        $time = $this->input->post('starttime');
        $day = $this->input->post('startday');
        $timestamp = strtotime($day . ' ' . $time);
        $start_at = date('Y-m-d H:i:s', $timestamp);
        //$location = $this->input->post('change_location');
        $id = $this->input->post('change_id');
        $time_id = $this->input->post('time_id');
        $data['start_at'] = $start_at;
        $data['virtual_course_id'] = $id;
        return $this->Live_model->update_time($data, array('id' => $time_id));
    }
    
    public function delete(){
        $out_data = array();
        $id = $this->input->post('id');
        if($this->Live_model->deleteCourse($id)){
            $out_data["status"] = "Success";
            $out_data["message"] = "";
        }else{
            $out_data["status"] = "Fail";
            $out_data["message"] = "Could not delete the row.";
        }
        $this->response($out_data);
    }
    
    public function insert_library(){
        $chapter_id = $this->input->post('chapter_id');
        $library_id = $this->input->post('library_id');
        $this->Course_model->update_chapter_library($library_id, $chapter_id);
        return;
    }
	
	public function deleteVirtualCourse(){
        $out_data = array();
        $id = $this->input->post('id');
        if($this->Live_model->deleteCourseVirtual($id)){
            $out_data["status"] = "Success";
            $out_data["message"] = "";
        }else{
            $out_data["status"] = "Fail";
            $out_data["message"] = "Could not delete the row.";
        }
        $this->response($out_data);
    }

}
