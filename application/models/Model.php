<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Model extends CI_Model
{
    // BY AJAY KUMAR
    /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }
   /*
     * Count No Rows in Table
     */
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }

    public function mobile_exist($mobile)
    {
        //echo $mobile;die();
        $this->db->select("*")
            ->from('customers')
            ->where(['mobile'=>$mobile, 'active'=>'1']);
    
        return $this->db->get()->num_rows();
        
    }
    function updateRow($mobile,$data ){
        if($this->db->insert('user_otp',$data)){
            return $this->db->insert_id();
        }
        return false; 
    }

    
    public function otp_exist($otp)
    {
        $this->db->select("*")
            ->from('user_otp')
            ->where(['otp'=>$otp]);
    
        return $this->db->get()->num_rows();
        
    }

    function Save($tb,$data){
        if($this->db->insert($tb,$data)){
            return $this->db->insert_id();
        }
        return false; 
    }
    function Update($tb,$data,$cond) {
        $this->db->where($cond);
        if($this->db->update($tb,$data)) {
            return true;
        }
        return false;
    }

    function getRow($tb,$data=0) {
        if ($data==0) {
            if($data=$this->db->get($tb)->row()){
                return $data;
            }
            else {
                return false;
            }
        }
        elseif(is_array($data)) {
            if($data=$this->db->get_where($tb, $data)){
                return $data->row();
            }
            else {
                return false;
            }
        }
        else {
            if($data=$this->db->get_where($tb,array('id'=>$data))){
                return $data->row();
            }
            else {
                return false;
            }
        }
    }
}

?>
