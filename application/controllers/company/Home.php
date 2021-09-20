<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 2018-10-24
 * Time: PM 3:02
 */
require APPPATH . '/libraries/BaseController.php';
class Home extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('User_model');
        $this->load->model('Settings_model');
        $this->load->model('Translate_model');
        $this->load->model('Company_model');
        $this->load->model('Course_model');
        $this->load->model('Trainingcourse_model');
        $this->load->model('Training_model');
        $this->load->model('Virtualcourse_model');
        $this->load->helper(array('cookie', 'string', 'language', 'url'));
        $this->load->helper('lms_email');
    }

    public function index($url)
    {
        $this->showCompanyByUrl($url);
    }
    public function showCompanyByUrl($url){
        $toReturn['menu_name'] = 'home';
        $headerInfo[term] = $this->term;
        $result = $this->company;
        $toReturn['company'] = $result;
        $toReturn['demandCourses'] = $this->Course_model->getRecent(3,$result['id']);
        $toReturn['trainCourses'] = $this->Trainingcourse_model->getRecent(3,$result['id']);
        for ($i = 0 ; $i < sizeof($toReturn['trainCourses']) ; $i++){
            $item = $toReturn['trainCourses'][$i];
            $course_item = $this->Course_model->getCourseById($item['course_id']);
           
            $item['img_path'] = $course_item['img_path'];
            $course_time = $this->Training_model->get_course_time_id($item['id']);
            
            $item['course_time_id'] = $course_time->id; 
			$item['date_str'] = $course_time->date_str; 
			$item['start_day'] = $course_time->start_day; 
			$item['start_time'] = $course_time->start_time; 
            $toReturn['trainCourses'][$i] = $item;
        }
        
        $toReturn['virtualCourses'] = $this->Virtualcourse_model->getRecent(3,$result['id']);
        $this->loadViews_front('company_page/companyhome', $toReturn);
    }
}