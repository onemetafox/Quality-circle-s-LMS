<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 6/27/2018
 * Time: 6:24 PM
 */
//require APPPATH . '/libraries/AbstractModel.php';
class Virtualcourse_model extends AbstractModel
{
    /**
     * This function used to manage categories
     */
    protected $table;
    var $_table = 'virtual_course';

    function __construct()
    {
        parent::__construct();
        $this->table = 'virtual_course';
        $this->user_table = 'user';
		$this->course_table = 'course';
    }

    function update_course($data, $row_id)
    {
        $this->db->where('id', $row_id);
        $result = $this->db->update($this->table, $data);
        return $result;
    }


    /*start front function*/
    function all($filter = NULL, $order = NULL, $direction = 'asc', $fields = "*"){
        // if(!empty($filter['search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('virtual_course.title', $filter['search'], 'both'); 
        //     $this->db->group_end();
        // }

        $this->db->select("a.start_at, a.id as time_id,b.*,DATE_FORMAT(b.reg_date,'%b %d,%Y')")->from("virtual_course_time a");
        $this->db->join('virtual_course b', 'a.virtual_course_id = b.id', 'left');
        if($filter['sort'] == 'upcoming'){
            $this->db->where('a.start_at >=', date('y-m-d'));
            $direction = 'asc';
        }else if($filter['sort'] == 'past'){
            $this->db->where('a.start_at <', date('y-m-d'));
            $direction = 'desc';
        }
        unset($filter['sort']);
        // $result = parent::all($filter,'reg_date',$direction);
        $this->db->order_by('a.start_at', $direction);
        if(isset($filter['limit']) && isset($filter['start']))
        {
            $this->db->limit($filter['limit'], $filter['start']);
        }
        else if(isset($filter['limit']))
        {
            $this->db->limit($filter['limit']);
        }

        $query = $this->db->get();
        $result = $query->result();

        /*while (list($key, $val) = each($result)) {*/
        foreach($result as $key => $val) {
			
			$this->db->select(['course_self_time','img_path']);
			$this->db->from($this->course_table);
			$this->db->where('id', $val->course_id);
	
			$queryss = $this->db->get();
			$result[$key]->virtual_course_path = $queryss->row_array()['img_path']; 
			
			$result[$key]->course_self_time = $queryss->row_array()['course_self_time']; 

            $result[$key]->enrolls = count(json_decode($val->enroll_users));

            $instructors = json_decode($val->instructors);

            if(!empty($instructors)){

                $result[$key]->first_instructor = $this->db->where('id',$instructors[0])
                                                             ->where('user_type','instructor')
                                                             ->select('id,email')
                                                             ->get($this->user_table)->row_array();
            }
            $result[$key]->is_pay = $this->db->where('user_id',$this->session->userdata('user_id'))
                    ->where('object_type','live')
                    ->where('object_id',$val->id)
                    ->select('id')
                    ->get('payment_history')
                    ->row_array();
            $start_date = date_format(date_create($val->start_at),"Y-m-d"); 
            $end_date = date("Y-m-d",strtotime("+".($val->duration-1)." day", strtotime($start_date)));
            $today = strtotime(date('Y-m-d'));

            if(strtotime($start_date) <= $today && strtotime($end_date) >= $today)
                $result[$key]->expired = 'no';
            else $result[$key]->expired = 'yes';
			
			$result[$key]->enroll_users_course = $this->db->where('id',$result[$key]->course_id)
                                                             ->select('enroll_users')
                                                             ->get($this->course_table)->row_array()['enroll_users'];
        }
        return $result;
    }
    function upcoming_three_course($id){
       
        $this->db->select("a.start_at, a.id as time_id, b.title,b.id")->from("virtual_course_time a");
        $this->db->join('virtual_course b', 'a.virtual_course_id = b.id', 'left');
        $this->db->where('b.id', $id);
        $this->db->where('a.start_at >=', date('y-m-d'));
        $this->db->order_by('a.start_at', 'asc');
        $this->db->limit('3');
        
        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    function count($filter = NULL) {
        if(!empty($filter['search'])) {
            $this->db->group_start();
            $this->db->or_like('virtual_course.title', $filter['search'], 'both'); 
            $this->db->group_end();
        }
        $this->db->select("a.start_at, b.*")->from("virtual_course_time a");
        $this->db->join('virtual_course b', 'a.virtual_course_id = b.id', 'left');
        if($filter['sort'] == 'upcoming'){
            $this->db->where('a.start_at >', date('y-m-d'));
            $direction = 'asc';
        }else if($filter['sort'] == 'past'){
            $this->db->where('a.start_at <', date('y-m-d'));
            $direction = 'desc';
        }
        $query = $this->db->get();
        $result = $query->result();
        return count($result);

    }

    function getCourseById($id = NULL) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }


    function select($id = null){
        $this->db->select("a.start_at, b.*,DATE_FORMAT(b.reg_date,'%b %d,%Y') as freg_date")->from("virtual_course_time a");
        $this->db->join('virtual_course b', 'a.virtual_course_id = b.id', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        // $this->db->select("*,DATE_FORMAT(reg_date,'%b %d,%Y') as freg_date");
        // $result = parent::select($id);
        $result->enrolls = count(json_decode($result->enroll_users));
        $instructors = json_decode($result->instructors);
        if(!empty($instructors)){
            $result->first_instructor = $this->db->where('id',$instructors[0])
                                                         ->where('user_type','instructor')
                                                         ->select('id,email,picture')
                                                         ->get($this->user_table)->row();
        }
        $result->is_pay = $this->db->where('user_id',$this->session->userdata('user_id'))
                    ->where('object_type','live')
                    ->where('object_id',$result->id)
                    ->select('id')
                    ->get('payment_history')
                    ->row_array();

        $start_date = date_format(date_create($result->start_at),"Y-m-d"); 
        $end_date = date("Y-m-d",strtotime("+".($result->duration-1)." day", strtotime($start_date)));
        $today = strtotime(date('Y-m-d'));
        $result->end_date = date_format(date_create($end_date),'M d,Y');

        if(strtotime($start_date) <= $today && strtotime($end_date) >= $today)
            $result->expired = 'no';
        else $result->expired = 'yes';
		
		$this->db->select(['course_self_time','img_path']);
		$this->db->from($this->course_table);
		$this->db->where('id', $result->course_id);

		$queryss = $this->db->get();
		$result->course_self_time = $queryss->row_array()['course_self_time']; 
		$result->virtual_course_path = $queryss->row_array()['img_path']; 
		  
		$result->enroll_users_course = $this->db->where('id',$result->course_id)
                                                             ->select('enroll_users')
                                                             ->get($this->course_table)->row_array()['enroll_users'];
        
        return $result;
    }
    function getRecent($count = null,$company_id = null){
        // if(!isset($count)){
        //     $count = 3;
        // }
        // if(isset($company_id)){
        //     $this->db->where('create_id',$company_id);
        // }
        // $this->db->order_by('reg_date','desc');
        // $this->db->limit(3,0);
        $this->db->select("*,DATE_FORMAT(reg_date,'%b %d,%Y') as freg_date");
        $virtual_course = $this->db->get($this->table)->result_array();
        $this->db->select('b.*,a.start_at,a.id as virtual_course_time_id, a.virtual_course_id');
        $this->db->join($this->table.' b' ,'b.id = a.virtual_course_id','left');
        $this->db->where('a.start_at >=',date('Y-m-d'));
        $this->db->order_by('a.start_at','asc');
        $virtual_course_time = $this->db->get('virtual_course_time a')->result_array();
        $result = array();
        foreach ($virtual_course_time as $key1 => $value1) {
            foreach($virtual_course as $key2 => $value2) {
                if($value1['virtual_course_id'] == $value2['id']){
                    array_push($result, $value1);
                    //array_splice($virtual_course,$key2,1);
                }

            }
        }
        /*if(count($result)>$count){
            array_splice($result,$count,count($result));
        }*/
        /*while (list($key, $val) = each($result)) {*/
        foreach($result as $key => $val) {
			##############################get course####################
			
			$this->db->select(['course_self_time','img_path']);
			$this->db->from($this->course_table);
			$this->db->where('id', $val['course_id']);
	
			$queryss = $this->db->get();
			$result[$key]['course_self_time'] = $queryss->row_array()['course_self_time']; 
			$result[$key]['virtual_course_path'] = $queryss->row_array()['img_path']; 
			##########################################################  
            $result[$key]['enrolls'] = count(json_decode($val['enroll_users']));
            $instructors = json_decode($val['instructors']);
            if(!empty($instructors)){
                $result[$key]['first_instructor'] = $this->db->where('id',$instructors[0])
                                                             ->where('user_type','instructor')
                                                             ->select('id,email')
                                                             ->get($this->user_table)->row_array();
            }
        }
        return $result;
    }
    /*end front function*/

}