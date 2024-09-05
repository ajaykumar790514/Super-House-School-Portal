<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct(){ 
        parent::__construct();
    }

public function index(){
 if($this->session->userdata('logged_in') || get_cookie("logged_in"))
 {    
    redirect(base_url('dashboard'));
 }else{  
$data['school'] = $query = $this->db->where(['active'=>'1','is_deleted'=>'NOT_DELETED'])->get('school_master')->result();
$data['group'] = $query = $this->db->where(['active'=>'1','is_deleted'=>'NOT_DELETED'])->get('group_master')->result();
$this->load->view('login',$data);
 }
}

public function user_login(){
    
    $this->form_validation->set_rules('mobile', 'Mobile', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

    if ($this->form_validation->run() == FALSE)
    {
        $datAjax = array('status'=>false, 'error'=>validation_errors());
        echo json_encode($datAjax);
    }
    else
    {
        $mobile = $this->input->post('mobile');
        $pwd = md5($this->input->post('password'));
        $signed = $this->input->post('signed_in');
        $query = $this->db->where(['mobile'=>$mobile, 'password'=>$pwd])->get('customers')->result();
        if ($query == TRUE) {
            $check['mobile'] = $mobile;
            $check_existing_record = $this->model->getRow('customers',$check);
            if($signed == '1')
            {
                $cookie_array = array(
                    'user_table'=>'customers',
                    'user_data'=>$check_existing_record,
                    'logged_in'=>TRUE
                );
                set_cookie('logged_in',TRUE,2147483647);
                set_cookie('user_id',$check_existing_record->id,2147483647);
                set_cookie('user_mobile',$check_existing_record->mobile,2147483647);
                set_cookie('user_name',$check_existing_record->name,2147483647);
                 if (!empty($check_existing_record->photo)) {
                    set_cookie('user_photo', $check_existing_record->photo, 2147483647);
                }
                set_cookie('group_id',$check_existing_record->group_id,2147483647);
                set_cookie('school_id',$check_existing_record->school_id,2147483647);
                set_cookie('class_id',$check_existing_record->class_id,2147483647);
                set_cookie('user_email',$check_existing_record->email,2147483647);
            }else{
                $session_array = array(
                    'user_id'=>$check_existing_record->id,
                    'user_name'=>$check_existing_record->name,
                    'user_mobile'=>$check_existing_record->mobile,
                    'user_photo'=>$check_existing_record->photo,
                    'group_id'=>$check_existing_record->group_id,
                    'class_id'=>$check_existing_record->class_id,
                    'school_id'=>$check_existing_record->school_id,
                    'user_email'=>$check_existing_record->email,
                    'logged_in'=>TRUE
                );
                $this->session->set_userdata($session_array);
            }

            //add cookie cart data to cart database with user_id
            if(!empty(get_cookie('shopping_cart')))
            {
                $cart_data = json_decode(get_cookie('shopping_cart'));

                $db_cart_data = $this->model->get_data1('cart','user_id',$check_existing_record->id);
                foreach($cart_data as $cart)
                {
                    $item_array2  = array(
                        'product_id' => $cart->product_id,
                        'qty' => $cart->qty,
                        'user_id' => $check_existing_record->id,
                    );

                    $product_existence = $this->home_model->check_cart_product_existence($check_existing_record->id, $cart->product_id);
                    //print_r($product_existence[0]->qty);
                    if(!$product_existence)
                    {
                        if($this->model->Save('cart',$item_array2))
                        {
                            delete_cookie("shopping_cart");
                        }
                    }else{
                        $item_array3  = array(
                            'qty' => $cart->qty + $product_existence[0]->qty,
                        );
                        if($this->db->where(['user_id'=>$check_existing_record->id, 'product_id'=>$cart->product_id])->update('cart', $item_array3))
                        {
                            delete_cookie("shopping_cart");
                        }
                    }
                }
            }
            //die;
            //end add cookie cart data to cart database with user_id

            if (isset($_COOKIE["wishlist_cart"])) {
                $cookie_data = stripslashes($_COOKIE['wishlist_cart']);
                foreach (json_decode($cookie_data) as $row) {
                    $data = array(
                        'user_id' => $check_existing_record->id,
                        'product_id' => $row->product_id,
                    );

                    $this->user_model->add_data('wishlist',$data);              
                } 
                delete_cookie("wishlist_cart");                                       
            }

            $datAjax = array('status'=>true);
            echo json_encode($datAjax);
        }
        else{
            $datAjax = array('status'=>false, 'error'=>'Password is invalid.');
            echo json_encode($datAjax);
        }
        
    }
}
public function check_admission()
{
    $admission = $this->input->post('admission');
    $school_id = $this->input->post('school_id');
    
    $admissionExists = $this->home_model->check_admission_exists($admission,$school_id);

    $response = ['exists' => $admissionExists];
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
}


    public function mobile_otp()
	{  
		$mobile=$_POST['mobile'];
		$this->db->delete('user_otp', array('mobile' => $mobile));
		if(isset($_POST['mobile']) && $_POST['mobile']!==''){
			$check_existing_record = $this->model->mobile_exist($_POST['mobile']);
			if($check_existing_record){
                $return['res'] = 'error';
			    $return['msg'] =  "Mobile number  already exist.";
			}
			else
			{
                $otp=mt_rand(100000, 999999);
				$_SESSION['otp']  = $otp;
				$data =array(
				      'otp'=>$otp,
					  'mobile'=>$_POST['mobile'],
				);

				if($this->model->updateRow($mobile,$data))
				{
					//code to send the otp to the mobile number will be placed here
					if(TRUE)
					{
						$return['res'] = 'success';
						$return['msg'] = 'Otp Send Your Mobile Number';
                       // $this->db->delete('user_otp', array('mobile' => $mobile));
                        $msg =$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
                        $conditions = array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'id'=>'1'
                                )
                        );
                        $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
                        $smsData['mobileNos'] = $mobile;
                        $smsData["message"] = $msg;
                        $this->ManageOrderOtpModel->send_sms($smsData);
					}
					else
					{
						$return['res'] = 'error';
						$return['msg'] = "Message could not be sent.";	
					}
				}
				else
				{
					$return['res'] = 'error';
						$return['msg'] = "Otp could not be generated.";	
				}
			}
		}
		else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
	}
    public function check_otp()
	{
		$otp=$_POST['otp'];
		if(isset($_POST['otp']) && $_POST['otp']!==''){
			
			  $check_existing_otp = $this->model->otp_exist($_POST['otp']); 
			  if($check_existing_otp)
			  {
				$return= 1;
			  }else{
				$return= 0;
			  }

		}else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
		
}

public function select_new_account()
{
	$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
                    $data = array(
                      'group_id'=>$_POST['group_id'],
                      'school_id'=>$_POST['school_id'],
                      'class_id'=>$_POST['class_id'],
                      'mobile'=>$_POST['mobile'],
                    );
                    $count= $this->model->Counter('customers', array('mobile'=> $_POST['mobile'] ));
                    if($count==0){
				     if($this->model->Save('customers',$data)){
							$saved = 1;
						}
                    }else
                    {
                        $this->model->Update('customers',$data,['mobile'=>$_POST['mobile']]);
                        $saved = 1;
                    }
                
				}
					
					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Successfully Select Group , School and Class.';
					}
					echo json_encode($return);
					return TRUE;
}
public function new_account()
{
	$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
                if(isset($_POST['password']) == isset($_POST['cpassword']))
				  {
                    $data = array(
                      'name'=>$_POST['name'],
                      'email'=>$_POST['email'],
                      'admission_no'=>$_POST['admission_no'],
                      'mobile'=>$_POST['mobile'],
                      'password'=>md5($_POST['password']),
                      'active'=>'1',
                    );
                    $count= $this->model->Counter('customers', array('mobile'=> $_POST['mobile'] ));
                    if($count==0){
				     if($this->model->Save('customers',$data)){
							$saved = 1;
                            $this->db->delete('user_otp', array('mobile' => $_POST['mobile']));
						}
                    }else
                    {
                        $this->model->Update('customers',$data,['mobile'=>$_POST['mobile']]);
                        $this->db->delete('user_otp', array('mobile' => $_POST['mobile']));
                        $saved = 1;
                    }
                }else
                {
                    $return['res'] = 'error';
                    $return['msg'] = 'Password and Comfirm Password does not matched.';
                }

				}
					
					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Your Account has been created  successfully.';
					}
					echo json_encode($return);
					return TRUE;
}
public function logout(){
    if($this->session->userdata('logged_in'))
    {
        $this->session->unset_userdata(array('user_table','user_data','logged_in','user_id'));
    }
    else
    {
        delete_cookie('logged_in');	
        delete_cookie('user_id');	
        delete_cookie('user_name');	
        delete_cookie('user_mobile');	
        delete_cookie('user_photo');	
    }
    redirect(base_url());
} 
public function header_and_footer($page, $data)
{
        $this->load->view('includes/header',$data);
        $this->load->view($page);
        $this->load->view('includes/footer');
}

public function dashboard(){

    $data['title'] = 'Shopzone';
    $page = 'index';
    $this->header_and_footer($page, $data);
    
    }
 //Fetch School and Class
 public function fetch_school()
 {
     if($this->input->post('group'))
     {
         $group= $this->input->post('group');
        //  $this->master_model->fetch_school_class($group);
         $data = $this->db->get_where('school_master',['group_id' => $group , 'is_deleted' => 'NOT_DELETED'])->result();
         echo "<option value=''>Select School</option>";
         foreach($data as $val)
         {
             echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
         }
     }
 }
 public function fetch_class()
 {
     if($this->input->post('group'))
     {
         $group= $this->input->post('group');
        //  $this->master_model->fetch_school_class($group);
         $data = $this->db->get_where('class_master',[ 'is_deleted' => 'NOT_DELETED'])->result();
         echo "<option value=''>Select Class</option>";
         foreach($data as $val)
         {
             echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
         }
     }
 }
 public function mobile_otp_recover()
 {  
     $mobile=$_POST['mobile'];
     $this->db->delete('user_otp', array('mobile' => $mobile));
     if(isset($_POST['mobile']) && $_POST['mobile']!==''){
         $check_existing_record = $this->model->mobile_exist($_POST['mobile']);
         if($check_existing_record){
            $otp=mt_rand(100000, 999999);
            $_SESSION['otp']  = $otp;
            $data =array(
                  'otp'=>$otp,
                  'mobile'=>$_POST['mobile'],
            );

            if($this->model->updateRow($mobile,$data))
            {
                if(TRUE)
                {
                    $return['res'] = 'success';
                    $return['msg'] = 'Otp Send Your Mobile Number';
                    $msg =$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
                    $conditions = array(
                        'returnType' => 'single',
                        'conditions' => array(
                            'id'=>'1'
                            )
                    );
                    $smsData = $this->ManageOrderOtpModel->getSmsRows($conditions);
                    $smsData['mobileNos'] = $mobile;
                    $smsData["message"] = $msg;
                    $this->ManageOrderOtpModel->send_sms($smsData);
                }
                else
                {
                    $return['res'] = 'error';
                    $return['msg'] = "Message could not be sent.";	
                }
            }
            else
            {
                $return['res'] = 'error';
                    $return['msg'] = "Otp could not be generated.";	
            }
            
         }
         else
         {
            $return['res'] = 'error';
            $return['msg'] =  "Mobile number  does not  exist.";
         }
     }
     else
     {
         $return['res'] = 'error';
         $return['msg'] =  "Mobile number not received.";
     }
     echo json_encode($return);
     return TRUE;
 }
 
 
 
 public function new_password()
 {
     $return['res'] = 'error';
                 $return['msg'] = 'Not Saved!';
                 $saved = 0;
                 if ($this->input->server('REQUEST_METHOD')=='POST') {
                 if(isset($_POST['password']) == isset($_POST['cpassword']))
                   {
                     $data = array(
                       'password'=>md5($_POST['password']),
                     );
                         $this->model->Update('customers',$data,['mobile'=>$_POST['mobile']]);
                         $this->db->delete('user_otp', array('mobile' => $_POST['mobile']));
                         $saved = 1;
                     
                 }else
                 {
                     $return['res'] = 'error';
                     $return['msg'] = 'Password and Comfirm Password does not matched.';
                 }
 
                 }
                     
                     if ($saved == 1 ) {
                         $return['res'] = 'success';
                         $return['msg'] = 'Your password has been recovered successfully.';
                     }
                     echo json_encode($return);
                     return TRUE;
               }

}
?>