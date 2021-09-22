<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 6/27/2018
 * Time: 6:24 PM
 */

class Live_model extends CI_Model
{
    /**
     * This function used to manage categories
     */
    protected $live_table;
    protected $course_user_table;
    protected $course_time_table;
    protected $user_table;
    protected $table;

    var $_table = 'training_course';

    function __construct()
    {
        parent::__construct();
        $this->course_table = 'virtual_course';
        $this->course_time_table = 'virtual_course_time';
        $this->course_user_table = 'virtual_course_user';
        $this->user_table = 'user';
    }
    function getFreeCourses($filter){
        $user = $this->session->userdata();
        $query = "SELECT b.*, e.*  FROM invite_user a
            LEFT JOIN `user` d ON d.email = a.email
            LEFT JOIN virtual_course b ON b.id = a.course_id
            LEFT JOIN virtual_course_time e ON e.virtual_course_id = b.id
            LEFT JOIN course c ON c.id = b.course_id
            WHERE a.course_type = 1 AND d.email = '".$user['email']."' AND b.create_id = '".$user['company_id']."' AND c.pay_type = 0 ";
        if($filter['location']){
            $query = $query . " And e.location = '".$filter['location']."'";
        }
        if($filter['course']){
            $query = $query . " And b.id = '".$filter['course']."'";
        }
        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;
    }

    function getPaidCourses($filter){
        $user = $this->session->userdata();
        $query = "SELECT * FROM virtual_course a
        LEFT JOIN course b ON a.course_id = b.id
        JOIN virtual_course_time c ON a.id = c.virtual_course_id
        WHERE b.pay_type = 1 AND a.create_id = '".$user['company_id']."'";
        if($filter['location']){
            $query = $query . " And c.location = '".$filter['location']."'";
        }
        if($filter['course']){
            $query = $query . " And a.id = '".$filter['course']."'";
        }

        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;
    }

    function getListByCompanyId($company_id = 0)
    {
        $query = 'Select * from virtual_course as c left join virtual_course_time as ct on ct.virtual_course_id = c.id where c.create_id='.$company_id;
        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;

    }

    function deleteCourse($row_id)
    {
        $this->db->where("id", $row_id);
        $this->db->delete("virtual_course");
    }

    function getCourseById($id = NULL) {
        $this->db->select('a.*');
        $this->db->from('virtual_course'." a");
        $this->db->where('a.id', $id);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    function update_chapter_library($library_id, $row_id)
    {
        $this->db->where('id', $row_id);
        $result = $this->db->update("chapter_live", array("library_id"=>$library_id));
        return $result;
    }

    function getLibrary($id = NULL){
        $this->db->select('a.*,b.name,b.file_path');
        $this->db->from("chapter_live"." a");
        $this->db->join("library".' b', 'a.library_id = b.id', 'left');
        $this->db->where('a.course_id',$id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function getListById($id = 0, $company_id = 0){
        $query = 'Select * from virtual_course as c left join virtual_course_time as ct on ct.virtual_course_id = c.id where c.create_id='.$company_id.' and c.id='.$id;
        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;
    }

    function delete_time($id)
    {
        $res = $this->db->delete($this->course_time_table, array('id'=>$id));
        return $res;

    }

    function getListCourseId($company_id = 0){
        $query = 'Select * from virtual_course where create_id='.$company_id;
        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;
    }
	
	function getListByCourseId($courseid = 0){
        $query = 'Select * from virtual_course where course_id='.$courseid;
        $result = $this->db->query($query);
        $res=$result->result_array();

        return $res;
    }

    function getListCourse($where = null)
    {
        if ($where == null) {
            $result = $this->db->get($this->course_table);
        } else {
            $result = $this->db->get_where($this->course_table, $where);
        }
        return $result->result_array();
    }
	
	function getListByVirtualCourseId($course_id){
		$query = 'Select * from virtual_course as c left join virtual_course_time as ct on ct.virtual_course_id = c.id where ct.id='.$course_id;		
        $result = $this->db->query($query);
        $res=$result->result_array();
		return $res;
	}

    function insert_course($data)
    {
        $data['reg_date'] = date("Y-m-d H:i:s");
        $data['is_deleted'] = 0;

        $this->db->insert($this->course_table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function update_course($data, $row_id)
    {
        $this->db->where('id', $row_id);
        $result = $this->db->update($this->course_table, $data);
        return $result;
    }

    function insert_time($data)
    {
        $data['reg_date'] = date("Y-m-d H:i:s");

        $this->db->insert($this->course_time_table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function update_time($data, $where = null){
        $this->db->where($where);
        $result = $this->db->update($this->course_time_table, $data);
        return $result;
    }
	
	function deleteCourseVirtual($row_id){
		$res = '';
        $this->db->where("id", $row_id);
        if($this->db->delete("virtual_course")){
			$this->db->delete($this->course_time_table, array('virtual_course_id'=>$row_id));	
			$res = 1;
		}
		return $res;
    }


}
