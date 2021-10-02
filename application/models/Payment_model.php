<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends AbstractModel
{
    var $_table = 'payment_history';
    
    public function totalAmountForSuper(){
        $query = "SELECT SUM(amount) total_amount FROM payment_history
        WHERE object_type = 'plan'";
        return $this->db->query($query)->row();
    }

    public function getInvoices($filter = NULL){
        $this->db->select("$this->_table.*, user.first_name, user.last_name, company.name company_name");
        $this->db->join('user', "user.id = $this->_table.user_id", 'left');
        $this->db->join('company', "company.id = user.company_id", 'left');
        if($filter['object_type'] == 'plan'){
            $this->db->join('plan', "plan.id = payment_history.object_id", 'left');
            $this->db->select('plan.name payment_title');
        }
        return parent::all($filter);
    }

    public function getInoviceDetail($filter){
        $this->db->select("$this->_table.*, user.first_name, user.email, user.phone, user.last_name, company.url, company.name company_name");
        $this->db->join('user', "user.id = $this->_table.user_id", 'left');
        $this->db->join('company', "company.id = user.company_id", 'left');
        if($filter['object_type'] == 'plan'){
            $this->db->join('plan', "plan.id = payment_history.object_id", 'left');
            $this->db->select('plan.name payment_title');
        }
        return parent::all($filter);
    }
}
?>
