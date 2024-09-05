<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#[\AllowDynamicProperties]
class ManageOrderOtpModel extends CI_Model{
    function __construct() {
        $this->userTbl = 'users';
        $this->userTb2 = 'sms_master';

    }
    
    function getSmsRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->userTb2);
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)) {
			foreach ($params['conditions'] as $key => $value) {
				$value= str_replace("+"," ",$value);
				$this->db->where($key,$value);
			}
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
			$query = $this->db->get();
			$result = $query->row_array();
        } else {
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            } else if(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$result = $query->num_rows();
			} else if(array_key_exists("returnType",$params) && $params['returnType'] == 'single') {
				$result = ($query->num_rows() > 0) ? $query->row_array(): 0;
			} else {
                $result = ($query->num_rows() > 0) ? $query->result_array(): 0;
            }
        }
        //return fetched data
        return $result;
    }

    public function send_sms($smsData = array()) {
     
        $senderId=$smsData["senderId"];
        $serverUrl=$smsData["url"];
        $authKey=$smsData["authKey"];
        $routeId=$smsData["routeId"];
        $mobile=$smsData["mobileNos"];
        $message=$smsData["message"];
        $country=91;
        //$DLT_TE_ID=$smsData["dlt_te_id"];
        $getData='mobileNos='.$mobile.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId;
        
        $endpoints = $serverUrl.$authKey."&".$getData;
        
        //print_r($endpoints);die;

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $endpoints,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0

        ));


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        $flag = 0;
        if(!$output) {
            trigger_error(curl_error($ch));
            //$flag=0;
        } else {
            $flag=1;
        }

        curl_close($ch);

        return $flag;
    }

    
}
?>