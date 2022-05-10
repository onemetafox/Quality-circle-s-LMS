<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH . '/libraries/BaseController.php';
class Classes  extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('User_model');
        $this->load->model('Settings_model');
        $this->load->model('Translate_model');
        $this->load->model('Virtualcourse_model');
		$this->load->model('Enrollments_model');
		
        $this->load->helper(array('cookie', 'string', 'language', 'url'));
        $this->load->helper('lms_email');
		$this->load->helper('common');
    }

    public function index()
    {
        $this->showAll();
    }

    public function showAll(){
        $params['menu_name'] = 'catalog';
        $params["term"] = $this->term;
        $params['company'] = $this->company;
        if($this->session->userdata ( 'isLoggedIn' ) != NULL ){
            $filter['create_id'] = $this->session->userdata('company_id');
        }else{
            $filter['create_id'] = $this->company['id'];
        }
        /*pagenation*/
        $displayLength = 3;
        $search = $this->input->get('sSearch');
        $start = $this->input->get('per_page');
        $sort = $this->input->get('sort');
        if (!isset($start)) {
            $start = 0;
        }
        if (!isset($sort)) {
            $sort = 'upcoming';
        } 
        $params['check_value'] = $sort;
        
        $filter['start'] = $start;
        $filter['limit'] = $displayLength;
        $filter['search'] = $search;
        $filter['sort'] = $sort;
        
        $filter['is_deleted'] = 0;
        $params['courses'] = $this->Virtualcourse_model->all($filter);
        unset($filter['start']);
        unset($filter['limit']);
        // unset($filter['sort']);
        
        $params['iTotalRecords'] = $this->Virtualcourse_model->count($filter);
        $params['sEcho'] = $search;

        $this->load->library('pagination');
        $config['base_url'] = site_url($this->company['company_url'].'/classes/?sSearch='.$search.'&sort='.$sort);
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $params['iTotalRecords'];
        $config['per_page'] = $displayLength;
        $config['num_links'] = 2;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $params['links'] = $this->pagination->create_links();
        /*end*/
        $this->loadViews_front('company_page/open-live-classes', $params);
    }

    public function view($url = NULL, $id = NULL){
        $params['menu_name'] = 'catalog';
        $params["term"] = $this->term;
        $params['company'] = $this->company;
        $course = $this->Virtualcourse_model->select($id);
		$totalCourseEnrollments = $this->Enrollments_model->totalCourseEnrollments($course->course_id,$id);
		$course->enroll_user_count = $totalCourseEnrollments;
		$course->course_time_id = $id;
        $params['upcoming_courses'] = $this->Virtualcourse_model->upcoming_three_course($course->id);
        $params['course'] = $course;
        $params['user_api_key'] =  $this->session->get_userdata()['api_key'];	

        $this->loadViews_front('company_page/view-live-course', $params);
    }

    public function detail($url = NULL, $id = NULL){
        $params['menu_name'] = 'catalog';
        /**/
    }

}