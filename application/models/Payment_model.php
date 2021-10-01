<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends AbstractModel
{
    var $_table = 'payment_history';
    
    public function totalAmountForSuper(){
        $query = "SELECT SUM(amount) total_amount FROM payment_history
        WHERE object_type = 'plan'";
        return $this->db->query($query)->row();
    }
}
?>
