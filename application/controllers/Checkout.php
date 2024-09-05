<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH .'third_party/hdfc/PaymentHandler.php');
use PaymentHandler\APIException;
use PaymentHandler\PaymentHandler;
require_once(APPPATH . 'third_party/tcpdf/TCPDF/tcpdf.php');

class Checkout extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
//        if( !is_logged_in() ):
//            redirect(base_url());
//            exit;
//        endif;
    }
    
    public function testing()
    {
        
 
                // $html=file_get_contents('https://www.30minutesvape.co.uk/bill-invoice-open/49');
              
                //  $pdf = new TCPDF();
                //  //$pdf->SetAutoPageBreak(FALSE, 0);
                // // // Add a page
                //  $pdf->AddPage();
                // // // Write HTML content
                //  $pdf->writeHTML($html);
                // // // Output PDF
                // $pdf->Output('/home/rootvape/public_html/30minutesvape.co.uk/portal/portal/assets/attatchments/test.pdf', 'I');
        //echo "application/third_party/hdfc/resources/config.json";
    }

    public function check_stock($pids,$qty)
    {
        $out_of_stock_data = array();
        $check_product_stock = $this->user_model->check_product_stock($pids,$qty);
        if(!empty($check_product_stock))
        {
            foreach($check_product_stock as $stock)
            {
                $output_array  = array(
                    'product_id' => $stock->product_id,
                    'product_name' => $stock->product_name,
                    'qty' => $stock->qty,
                );
                array_push($out_of_stock_data,$output_array);
            }
            return $out_of_stock_data;
        }
        else
        {
            return false;
        }
    }
    
    // public function thanksworldpay()
    // {
    //     $viewData['transStatus']='N';
    //     $this->load->view('thanksworldpay', $viewData);

    // }

    //uk gateway reponse handler
    public function worldpay_response()
    {
        //imp parameters return by gateway
        //transId
        //cartId
        //ipAddress
        //transStatus
        //rawAuthCode
        //authMode
        $viewData['title'] = 'Gateway Response';
        $shop_id = '6';
        $viewData['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        
        // $str="";
        // foreach($this->input->post() as $key => $val)
        //     {
        //      $str=$str."<p>Key: ".$key. " Value:" . $val . "</p>\n";
        //     }
        // $data=array(
        // "data"=>$str
        // );
      
        // $this->db->insert('testgateway',$data);
        $viewData['transStatus']=$this->input->post('transStatus');
        if($this->input->post('transStatus')=='Y')
        {
            //update transaction parameters on db
            $data=array(
            'payment_transaction_code'=>$this->input->post('transId'),
            'ip'=>$this->input->post('ipAddress'),
            'status'=>'17'    
            );
            $this->db->where('id',$this->input->post('cartId'));
            $this->db->update('orders',$data);
            //$this->load->view('thanksworldpay', $viewData);
            $rs = $this->user_model->get_user_id($this->input->post('cartId'));
            $usermail =  $rs->email;
            //$link ="https://30minutesvape.co.uk/order-details/".$this->input->post('cartId');
            $phoneNumber = '+447414110414'; // Replace with the target phone number
            $message2 = 'Hello there!'; // Replace with the message you want to pre-fill
            $whatsappLink = "https://wa.me/".$phoneNumber."?text=" . urlencode($message2);
          
            $mailtoLink = "mailto:".$emailAddress."?subject=" . urlencode($subject2) . "&body=" . urlencode($body);
            $url=base_url('order-details/'.$this->input->post('cartId'));
            $link ="<a href='".$url."'><b>Click Here</b></a>";
            
            // // Fetch website content
            //     $websiteContent = file_get_contents('https://www.30minutesvape.co.uk/bill-invoice/'.$this->input->post('cartId'));
            //     // Create new PDF document
            //     $pdf = new TCPDF();
            //     // Add a page
            //     $pdf->AddPage();
            //     // Write HTML content
            //     $pdf->writeHTML($websiteContent);
            //     // Output PDF
            //     $pdf->Output(IMGS_URL_ROOT.'attatchments/'.$this->input->post('cartId').'.pdf', 'I');
             
            
            $subject = "Order confirmation 30minutesvape";
            $message = "Thank you for placing your order with 30 MINUTES VAPE, for more details on your order and invoice, go to the profile section of your website account  ".$link."<br><br><br><br>Call Us: <a href=".$whatsappLink." target='_blank'>+447414110414</a><br>Email Us: info@30minutesvape.com";
            
           
            $user_id = $rs->id;
            $all_data = $this->user_model->fetch_shop_inventory($this->input->post('cartId'));
            foreach ($all_data as $inventory) {
             $inventory_id = $inventory->id;
             $get_product_stock = $this->user_model->get_data('shops_inventory','id',$inventory->id);
             if(!empty($get_product_stock))
             {
                 foreach($get_product_stock as $stock)
                 {
                        
                     $inventory_data['qty'] = $stock->qty - $inventory->qty;
                      $this->user_model->edit_data('shops_inventory', 'id', $inventory_id, $inventory_data);
                 }
             }
            }
            $this->user_model->delete_data1('cart','user_id',$user_id);
            
            
            //mail and attatchment code
                $html=file_get_contents('https://www.30minutesvape.co.uk/bill-invoice-open/'.$this->input->post('cartId'));
              
                 $pdf = new TCPDF();
                 $pdf->AddPage();
                 $pdf->writeHTML($html);
                 $pdf->Output('/home/rootvape/public_html/30minutesvape.co.uk/portal/portal/assets/attatchments/INVOICE_'.$this->input->post('cartId').'.pdf', 'F');
                 $billPath=IMGS_URL_ROOT.'attatchments/INVOICE_'.$this->input->post('cartId').'.pdf';
                 $fileName='INVOICE_'.$this->input->post('cartId').'.pdf';
                 sendMail($message,$usermail,$subject,$billPath,$fileName); 

            $viewData['page'] = 'thanksworldpay';
            $this->load->view('thanksworldpay', $viewData);
           // $this->load->view('layouts/index', $viewData);
            
        }
        else
        {
            $data=array(
            'payment_transaction_code'=>$this->input->post('transId'),
            'ip'=>$this->input->post('ipAddress'),
            'status'=>'1'    
            );
            $this->db->where('id',$this->input->post('cartId'));
            $this->db->update('orders',$data);
            $rs = $this->user_model->get_user_id($this->input->post('cartId'));
            $usermail =  $rs->email;
            $link ="<a href=".base_url('cart')."><b>Go to cart</b></a>";
            $subject = "Order failed 30minutesvape";
            $message = "Sorry.Your payment failed. ".$link;
            sendMail($message,$usermail,$subject); 
            //$this->load->view('thanksworldpay', $viewData);
            $viewData['page'] = 'thanksworldpay';
            //$this->load->view('layouts/index', $viewData);
            $this->load->view('thanksworldpay', $viewData);
        }
       
    }
    
    
    public function checkout_items($action=null,$id='null')
    {
        switch ($action) {
            case null:
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $user_code = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $shop_id = '6';
                $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
                $data['title'] = 'Checkout';
                $data['country']  = $this->db->get('countries')->result();
                $data['addresses'] = $this->user_model->get_data1('customers_address','customer_id',$user_id);
                $data['edit_addr_url'] = base_url().'user/users/edit_address/';
                $data['add_url'] = base_url('checkout/checkout_items/add_address/');
                $data['coupon_url'] = base_url('checkout/coupon');
                $data['remote']     = base_url().'user_remote/pincode/';
                // $data['shop_detail'] = $this->user_model->get_row_data('shops','id',$shop_id);
                //cart items
                $data['cart_data'] = $this->home_model->get_data1('cart','user_id',$user_id);
                $subtotaloffer=  $total_savings= $subtotal=0;
                foreach ($data['cart_data'] as $cart) {
                    $product_id = $cart->product_id;
                    $cart_items = $this->product_model->product_details($product_id);
                    //calculate selling rate
                    if($cart_items->discount_type=='0') //0->rupee
                    {
                        $selling_rate = ($cart->qty*$cart_items->selling_rate) - $cart_items->offer_upto;
                    }
                    else if($cart_items->discount_type=='1') //1->%
                    {
                        $selling_per = ($cart->qty*$cart_items->selling_rate * $cart_items->offer_upto)/100;
                        $selling_rate = ($cart->qty*$cart_items->selling_rate) - $selling_per;
                    }else{
                        $selling_rate = $cart->qty*$cart_items->selling_rate;
                    }
                    //end of calculate selling rate
                    //$subtotal = $subtotal + ($selling_rate);
                    // if offer iplicable
             if(!empty($cart_items->offer_upto))
             {
                if($cart_items->discount_type=='1')
                {
                    $subtotaloffer = $selling_rate;
                    $subtotal = $subtotal + $selling_rate;
                }else{
                      $subtotaloffer= ($cart_items->selling_rate-$cart_items->offer_upto)*$cart->qty ;
                     $subtotal = $subtotal + $subtotaloffer;
                }
            
             }else{   
                  $subtotal = $subtotal + ($selling_rate) ;
            
             }


                    $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
                //     $deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
                //     $totalsave=0;
                //     if($cart_items->discount_type !='1' &&  $cart_items->discount_type !='0')
                //     {
                //      foreach($deal as $rowdeal){
                //           if ($rowdeal->qty == $cart->qty) {
                //               $subtotal = $subtotal - $selling_rate;
                //                $selling_rate = $rowdeal->price;
                //                   $subtotal = $subtotal + $selling_rate ; 
                             
                //           }
                //      }       
                //   }                                                         
                }
                $data['sub_total'] =bcdiv($subtotal, 1, 2);                
                $data['coin'] = $this->db->order_by('id DESC')->select('balance')->get_where('customers_coin_transaction', array('user_id'=>$user_code))->row();
                //$data['slots'] = $this->db->get_where('booking_slots', array('shop_id'=>$shop_id))->result_array();
                $data['page'] = 'checkout';
                if ($this->input->is_ajax_request()) {
                   $this->load->view('checkout', $data);
                }else{
                    $this->load->view('includes/index', $data);
                }
                break;
                case 'add_address':
                    if($this->session->userdata('logged_in'))
                    {
                        $customer_id = $this->session->userdata('user_id');
                    }
                    else
                    {
                        $customer_id = get_cookie("user_id");
                    }
                    $count = count($this->user_model->get_data1('customers_address','customer_id',$customer_id));
                    
                    $post = $this->input->post();
    
                       $data = array(
                        'customer_id'    => $customer_id,
                        'address_line_1'    => $post['address_line_1'],
                        'address_line_2'    => $post['address_line_2'],
                        'address_line_3'    => $post['address_line_3'],
                        'landmark' => $post['landmark'],
                        'pincode'    => $post['pincode'],
                        'contact_person_name'    => $post['contact_person_name'],
                        'mobile'    => $post['mobile'],
                        'state'=>$post['state'],
                        'city'    => $post['city'],    
                        'country'=>'Indian'                   
                    );
                    if( $post['id'] ):
                        $this->user_model->Update('customers_address',$data,['id'=>$post['id']]);
                    else:
                        if($count == 0)
                        {
                            $data['is_default'] ='1';
                        }else{
                            $data['is_default'] ='0';  
                        }
                        $this->user_model->add_data('customers_address',$data);
                    endif;
    
                    echo true;
                    break;
            case 'place_order':

                $shop_id = 6;
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $user_mobile = $this->session->user_mobile ? $this->session->user_mobile : get_cookie("user_mobile");
                $aid = $this->input->post('aid');
                $coin_pay = $this->input->post('coin_pay');
                $coupon_id = $this->input->post('coupon_code');
                $slot_id = $this->input->post('slot_id');
                $cart_data = $this->user_model->get_data1('cart','user_id',$user_id);
                $subtotal=$total_cutting_price=$total_savings=$total_tax=0.00;
                $out_of_stock_data = array();
                $insert_ids = $item_data = array();
                $remark = $this->input->post('remark');
                $shop_id = '6';
                $offer_type_new=2;
                $shop_detail = $this->home_model->get_shop_detail($shop_id);
                  	foreach ($cart_data as $cart) {
					$product_id_new = $cart->product_id;
					$cart_items_new = $this->product_model->product_details($product_id_new);
					if($cart_items_new->ProductFlag=='bundle')
						{
							$bundleItems = $this->product_model->getBundleProduct($cart_items_new->pid);
							if (empty($bundleItems)) {
								$bundle_name = $cart_items_new->product_name;
								echo json_encode(array('error'=>'true','msg'=>$bundle_name ." This item is can not be delivered. Kindly Remove this item in your cart."));
						         exit;
							}
						}
				}
                foreach ($cart_data as $cart) {
                    // product_id = inventory_id
                    $product_id = $cart->product_id;
                    $check_product_stock = $this->user_model->check_product_stock($cart->product_id,$cart->qty);
                    if(!empty($check_product_stock))
                    {
                        foreach($check_product_stock as $stock)
                        {
                            $output_array  = array(
                                'product_id' => $stock->inventory_id,
                                'product_name' => $stock->product_name,
                                'qty' => $stock->qty,
                            );
                            array_push($out_of_stock_data,$output_array);
                        }
                    }
                    if(empty($out_of_stock_data))
                    {
                        $cart_items = $this->product_model->product_details($product_id);
                        //calculate selling rate
                      
                        if($cart_items->discount_type=='0') //0->rupee
                        {
                            $offer_type_new = 0;
                            $selling_rate = ($cart_items->selling_rate - $cart_items->offer_upto)*$cart->qty;
                            
                        }else if($cart_items->discount_type=='1') //1->%
                        {
                            $selling_per = (($cart_items->selling_rate * $cart_items->offer_upto)/100);
                            $selling_rate = ($cart_items->selling_rate - $selling_per)*$cart->qty;
                            $offer_type_new=1;
                        }else{
                            $selling_rate = $cart->qty*$cart_items->selling_rate;
                            $offer_type_new=2;
                        }
                        
                        //end of calculate selling rate
                        
                        $subtotal = $subtotal + bcdiv(($selling_rate),1,2);
                        
                        
                        $product_detail = $this->user_model->get_ordered_product_detail($cart->product_id);
                        $cutting_price = $cart->qty *$cart_items->selling_rate;
                        $total_cutting_price += $cutting_price;
                        $total_savings = $total_cutting_price - $subtotal;
                        $inclusive_tax = $selling_rate - ($selling_rate * (100/ (100 + $product_detail->product_tax)));
                        $total_tax += $inclusive_tax;

                        $total_price =  $selling_rate*$cart->qty;

                        $offer_apply = $product_detail->offer_upto;
                        // $offer_type_new = $product_detail->discount_type ? $product_detail->discount_type : 1;

                        $item_array = array(
                            'product_id' => $product_detail->product_id,
                            'inventory_id' => $product_id,
                            'qty' => $cart->qty,
                            //'price_per_unit' =>bcdiv($product_detil->prodauct_tax, 1, 2),
                            'price_per_unit' =>bcdiv($product_detail->selling_rate, 1, 2),

                            'purchase_rate' => $product_detail->purchase_rate,
                            'mrp' => $product_detail->mrp,
                            'total_price' => bcdiv($selling_rate, 1, 2),
                            'tax_value' =>  bcdiv($product_detail->product_tax, 1, 2),
                            'offer_applied' =>$offer_apply,
                            'discount_type' =>$offer_type_new,
                        );

                        array_push($item_data,$item_array);

                    }
                }
                
                if(empty($out_of_stock_data))
                {
                    // $this->user_model->delete_data1('cart','user_id',$user_id);

                    $slots = $this->db->get_where('booking_slots', array('id'=>$slot_id))->row();

                    $address = $this->db->get_where('customers_address', array('id'=>$aid))->row();
                    $states = $this->db->get_where('states', array('id'=>$address->state))->row();
                    $cities = $this->db->get_where('cities', array('id'=>$address->city))->row();
                    $del_add = $address->address_line_1.' '.$address->address_line_2.' '.$address->address_line_2.' '.$address->landmark.' '.$states->name.' '.$cities->name.' '.$address->pincode.' '.$address->country;
                    $cus_email = $this->db->get_where('customers', array('id'=>$address->customer_id))->row();
                    
                    // Get Customer Billing Address 
                    $billing_address = $this->db->get_where('customers_address', array('customer_id'=>$address->customer_id,'is_default'=>'1'))->row();
                    $billingstates = $this->db->get_where('states', array('id'=>@$billing_address->state))->row();
                    $billingcities = $this->db->get_where('cities', array('id'=>@$billing_address->city))->row();
                    $delivery_charge =  delivery_charge($subtotal);
                    $data = array(
                        'orderid'    => '',
                        'shop_id'    => $shop_id,
                        'user_id'    => $user_id,
                        'datetime'  => @$slots ? date('Y-m-d', strtotime('next '.$slots->day)) : '0000-00-00',
                        'address_id'    => $aid,
                        'random_address' => $del_add,
                        'status'    => '1',
                        'total_value'    =>  bcdiv($subtotal, 1, 2),
                        'payment_method' => 'online gateway',
                        'total_savings' => bcdiv($total_savings, 1, 2),
                        'tax' => bcdiv($total_tax,1,2),
                        'timeslot_starttime' => @$slots->timestart,
                        'timeslot_endtime' => @$slots->timeend,
                        'time_slot_id' => @$slots->id,
                        'booking_name' => $address->contact_person_name,
                        'booking_contact' => $address->mobile,
                        'direction' => $address->landmark,
                        'delivery_charges'=>$delivery_charge,
                        //'longitude' => $address->longitude,
                        //'latitude' => $address->latitude,
                        'state'    =>$states->name,
                        'city'    =>$cities->name,
                        'pincode'    =>$address->pincode,
                        'house_no'    =>$address->address_line_1,
                        'address_line_2'    =>$address->address_line_2,
                        'address_line_3'    =>$address->address_line_3,
                        'email'           =>$cus_email->email,
                        'remark'     =>$remark,
                        'billing_state'    =>@$billingstates->name,
                        'billing_city'    =>@$billingcities->name,
                        'billing_pincode'    =>$billing_address->pincode,
                        'billing_house_no'    =>$billing_address->address_line_1,
                        'billing_address_line_2'    =>$billing_address->address_line_2,
                        'billing_address_line_3'    =>$billing_address->address_line_3,
                    );
                    $proFlg=FALSE;
                    if($this->db->insert('orders', $data))
                    {
                        $proFlg=TRUE;
                    }
                    if($proFlg)
                   {
                    $insert_id = $this->db->insert_id();
                    $orderIds= $insert_id;
                    // insert log data by ajay kumar
                    $logdata1 = array('order_id'=>$insert_id,'status_id'=>'1');
                    $this->db->insert('order_status_log', $logdata1);
                    $date = strtotime("now");
                    $mon=date('M', $date);
                    //generate unique orderid 
                    $num_padded = sprintf("%05d", $insert_id);
                    $code="BO".strtoupper($mon).$num_padded;
                    $oid['orderid'] = $code;
                    $this->user_model->Update('orders',$oid,['id'=>$insert_id]);
                   

                    //order item table insertion
                    foreach( $item_data as $itm ):
                        $itm['order_id'] = $insert_id;
                        $product_id =  $itm['product_id'];
                        $this->db->insert('order_items', $itm);
                        $itm_id = $this->db->insert_id();
                        // Bundle Product Insertion
                        $checkBundle = $this->db->get_where('products_subcategory', array('id'=>$product_id))->row();
                        if($checkBundle->flag=='bundle'){
                        $bundleProduct = $this->product_model->getBundleProduct($product_id);
                        foreach($bundleProduct as $Pro)
                        {
                            $BundlePro = array(
                              'bundle_id'=>$product_id,
                              'order_item_id'=>$itm_id,
                              'product_id'=>$Pro->prod_id,
                              'qty'=>$Pro->qty,
                              'selling_rate'=>$Pro->amount,
                              'mrp'=>$Pro->mrp,
                            );
                            $this->db->insert('order_bundle_items', $BundlePro);
                        }
                        }
                       
                    endforeach;
                }
                if($proFlg)
                {
                 //SmartHdfc code
                 $payable_final_amt = $subtotal+$delivery_charge;
                 if( $payable_final_amt > 0 ):
					$paymentHandler = new PaymentHandler(APPPATH ."third_party/hdfc/resources/config.json");
                    
					$orderId = "ORDERID_" . $orderIds;
					$customerId = "CUSTOMERID" . $user_id;
			
					$params = [
						"amount" => $payable_final_amt,
						"order_id" => $code,
						"customer_id" => $customerId,
						"action" => "paymentPage",
						"return_url" => base_url("handle-payment-response")
					];
					try {
					    
						$session = $paymentHandler->orderSession($params);
						$redirect = $session["payment_links"]["web"];
						
						$user_detail = $this->user_model->get_row_data('customers','id',$user_id);
						$user_name = $user_detail->name;
						$user_mobile = $user_detail->mobile;
						$user_email = $user_detail->email;
						echo json_encode(array('error'=>false,'url'=>$redirect,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$orderIds, 'total'=>$payable_final_amt));
					} catch (APIException $e) {
						http_response_code(500);
						$error = json_encode([
							"message" => $e->getErrorMessage(),
							"error_code" => $e->getErrorCode(),
							"http_response_code" => $e->getHttpResponseCode()
						]);
						echo json_encode(array('error'=>'true','msg'=>"Payment server threw a non-2xx error. Error message:".$error));
						exit;
					} catch (Exception $e) {
						http_response_code(500);
						
						$msg= "Unexpected error occurred, Error message:  {$e->getMessage()}";
						echo json_encode(array('error'=>'true','msg'=>" Unexpected error occurred, Error message:".$msg));
						exit;
					}
                 else:
                     $data = [
                         'status'=> '17',
                         'payment_method' => 'Coin Payment',
                     ];

                     $this->db->where('id', $insert_id)->update('orders', $data);
                     echo json_encode(array('flag'=>'success'));
                 endif;
                }
                else
                {
                    echo json_encode(array('error'=>'true','msg'=>'Something Went Wrong'));
                }

                }else{
                    echo json_encode(array('error'=>false,'flag'=>'out_of_stock','out_of_stock_data'=> $out_of_stock_data));
                }
                break;
            case 'make_cod_payment':

                $shop_id = 6;
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                // $user_mobile = $this->session->user_mobile ? $this->session->user_mobile : get_cookie("user_mobile");
                $user_mobile = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $aid = $this->input->post('aid');
                $coin_pay = $this->input->post('coin_pay');
                $coupon_id = $this->input->post('coupan_code');
                //$slot_id = $this->input->post('slot_id');
                $cart_data = $this->user_model->get_data1('cart','user_id',$user_mobile);
                $subtotal=$total_cutting_price=$total_savings=$total_tax=0;
                $out_of_stock_data = array();
                $insert_ids = $item_data = array();

                foreach ($cart_data as $cart) {
                    // $product_id = $inventory_id
                    $product_id = $cart->product_id;
                    $check_product_stock = $this->user_model->check_product_stock($cart->product_id,$cart->qty);
                    if(!empty($check_product_stock))
                    {
                        foreach($check_product_stock as $stock)
                        {
                            $output_array  = array(
                                'product_id' => $stock->inventory_id,
                                'product_name' => $stock->product_name,
                                'qty' => $stock->qty,
                            );
                            array_push($out_of_stock_data,$output_array);
                        }
                    }
                    if(empty($out_of_stock_data))
                    {
                        $cart_items = $this->product_model->product_details($product_id);
                        //calculate selling rate
                        if($cart_items->discount_type=='0') //0->rupee
                        {
                            $selling_rate = ($cart->qty*$cart_items->selling_rate) - $cart_items->offer_upto;
                        }else if($cart_items->discount_type=='1') //1->%
                        {
                            $selling_per = ($cart->qty*$cart_items->selling_rate * $cart_items->offer_upto)/100;
                            $selling_rate = ($cart->qty*$cart_items->selling_rate) - $selling_per;
                        }else{
                            $selling_rate = $cart->qty*$cart_items->selling_rate;
                        }
                        //end of calculate selling rate
                        $subtotal = $subtotal + ($selling_rate);

                        $product_detail = $this->user_model->get_ordered_product_detail($cart->product_id);
                        $cutting_price = $cart->qty *$cart_items->mrp;
                        $total_cutting_price += $cutting_price;
                        $total_savings = $total_cutting_price - $subtotal;
                        $inclusive_tax = $selling_rate - ($selling_rate * (100/ (100 + $product_detail->product_tax)));
                        $total_tax += $inclusive_tax;

                        $total_price = $selling_rate*$cart->qty;

                        $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
                        $deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
                        foreach($deal as $rowdeal){
                            if ($rowdeal->qty == $cart->qty) {
                                $subtotal = $subtotal - $selling_rate;
                                $total_price = $rowdeal->price;
                                $selling_rate = $cart_items->selling_rate;
                                $subtotal = $subtotal + $total_price;
                            }
                        }

                        $item_array = array(
                            'product_id' => $product_detail->product_id,
                            'inventory_id' => $product_id,
                            'qty' => $cart->qty,
                            'price_per_unit' => $selling_rate,
                            'purchase_rate' => $product_detail->purchase_rate,
                            'mrp' => $product_detail->mrp   ,
                            'total_price' => $total_price,
                            'tax_value' => $product_detail->product_tax,
                            'offer_applied' => $product_detail->offer_upto,
                            'discount_type' => $product_detail->discount_type ? $product_detail->discount_type : 1,
                        );
                        array_push($item_data,$item_array);

                        $get_product_stock = $this->user_model->get_data('shops_inventory','id',$cart->product_id);
                        if(!empty($get_product_stock))
                        {
                            foreach($get_product_stock as $stock)
                            {                            
                                $inventory_data['qty'] = $stock->qty - $cart->qty;
                                $this->user_model->edit_data('shops_inventory','id',$product_id,$inventory_data);
                            }
                        }
                        
                    }
                }
                if(!empty($out_of_stock_data))
                {
                    echo json_encode(array('flag'=>'out_of_stock','out_of_stock_data'=> $out_of_stock_data));
                }else{

                    $address = $this->db->get_where('customers_address', array('id'=>$_POST['aid']))->row();
                    $del_add = $address->house_no.' '.$address->floor.' '.$address->apartment_name.' '.$address->address.' '.$address->landmark.' '.$address->pincode.' '.$address->city.' '.$address->state;

                    $this->user_model->delete_data1('cart','user_id',$user_mobile);
                    //$slots = $this->db->get_where('booking_slots', array('id'=>$slot_id))->row();

                    $data = array(
                        'orderid'    => '',
                        'shop_id'    => '6',
                        'user_id'    => $user_id,
                        //'datetime'  => @$slots ? date('Y-m-d', strtotime('next '.$slots->day)) : '0000-00-00',
                        'address_id'    => $aid,
                        'random_address' => $del_add,
                        'status'    => '17',
                        'total_value'    => $subtotal,
                        'payment_method' => 'cod',
                        'total_savings' => $total_savings,
                        'tax' => round($total_tax,2),
                        'timeslot_starttime' => @$slots->timestart,
                        'timeslot_endtime' => @$slots->timeend,
                        'time_slot_id' => @$slots->id,
                        'booking_name' => $address->contact_name,
                        'booking_contact' => $address->contact,
                        'direction' => $address->landmark
                    );
                    $this->db->insert('orders', $data);
                    $insert_id = $this->db->insert_id();

                    $coupon_discount = $coin_discount = $left_coin = 0;
                    // coupon discount
                    if( $coupon_id ):
                        $coupon_detail = $this->db->select('*')
                            ->from('coupons_and_offers')
                            ->where('coupan_or_offer', 0)
                            ->where("'".date('Y-m-d')."' BETWEEN start_date AND expiry_date", NULL)
                            ->where('active', 1)
                            ->where('id', _decode($coupon_id))->get()->row();
                        if( $subtotal >= $coupon_detail->minimum_coupan_amount ):
                            if( $coupon_detail->discount_type == 1 ):
                                $coupon_discount = ($subtotal * $coupon_detail->value)/100;
                            else:
                                $coupon_discount = $coupon_detail->value;
                            endif;

                            $coupon_discount = ($coupon_discount <= $coupon_detail->maximum_coupan_discount_value) ? $coupon_discount : $coupon_detail->maximum_coupan_discount_value;
                            $coin_array = array(
                                'coupon_type' => 2,
                                'coupon_value_type' => ($coupon_detail->discount_type==1) ? 2 : 1,
                                'coupon_value' => round($coupon_discount, 2),
                                'coupon_value_percentage' => $coupon_detail->value,
                                'coupon_reference' => $coupon_detail->code,
                                'order_id' => $insert_id
                            );
                            $this->db->insert('order_coupons', $coin_array);
                        endif;
                    endif;

                    // coin pay discount
                    if( $coin_pay != 0 ):
                        $coin_bal = $this->db->order_by('id DESC')->select('IFNULL(balance, 0) AS balance')->get_where('customers_coin_transaction', array('user_id'=>$user_id))->row()->balance;
                        $coin_rate = $this->db->select('IFNULL(coin_value, 0) AS coin_value')->get_where('shops', array('id'=>$shop_id))->row()->coin_value;
                        $coins_rs = $coin_bal/$coin_rate;

                        if( $coins_rs > ($subtotal-$coupon_discount) ){
                            $coin_discount = $subtotal-$coupon_discount;
                        }else{
                            $coin_discount = $coins_rs;
                        }

                        $left_coin = ($coins_rs-$coin_discount)*$coin_rate;
                        $used_coin = $coin_bal - $left_coin;

                        $coin_array = array(
                            'coupon_type' => 1,
                            'coupon_value_type' => 1,
                            'coupon_value' => round($coin_discount, 2),
                            'coupon_value_percentage' => round($coin_discount, 2),
                            'coupon_reference' => NULL,
                            'order_id' => $insert_id
                        );
                        $this->db->insert('order_coupons', $coin_array);

                        $user_coin = array(
                            'user_id' => $user_id,
                            'coins' => $used_coin,
                            'coins_value' => 0.00,
                            'dr_cr' => 2,
                            'balance' => $left_coin,
                            'earned_from' => 2,
                            'reference_no' => $insert_id
                        );
                        $this->db->insert('customers_coin_transaction', $user_coin);
                    endif;

                    // credit purchase coins
                    $coin_mst = $this->db->where('type', 2)
                        ->where( "'".$subtotal."' BETWEEN purchase_minimum AND purchase_max", NULL)
                        ->get('coin_master')->row();
                    if( $coin_mst ):
                        $user_coin = array(
                            'user_id' => $user_id,
                            'coins' => $coin_mst->how_much_coin,
                            'coins_value' => 0.00,
                            'dr_cr' => 1,
                            'balance' => $coin_mst->how_much_coin,
                            'earned_from' => 2,
                            'reference_no' => $insert_id
                        );
                        $this->db->insert('customers_coin_transaction', $user_coin);
                    endif;

                    $date = strtotime("now");
                    $mon=date('M', $date);
                    //generate unique orderid 
                    $num_padded = sprintf("%05d", $insert_id);
                    $code="BO".strtoupper($mon).$num_padded;
                    $oid['orderid'] = $code;
                    $this->user_model->Update('orders',$oid,['id'=>$insert_id]);

                    foreach( $item_data as $itm ):
                        $itm['order_id'] = $insert_id;
                        $this->db->insert('order_items', $itm);
                    endforeach;
                    echo json_encode(array('flag'=>'success'));
                }
                break;
            case 'repayment':
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie('user_id');
                $order_id = _decode($this->input->post('order_id'));
                $order = $this->db->select('total_value')->get_where('orders', array('id'=>$order_id))->row();
                $total_value = $order->total_value;

                $pay_options = $this->db->select('SUM(coupon_value) as coupon_value')->get_where('order_coupons', array('order_id'=>$order_id))->row();
                if( $pay_options ):
                    $total_value = $total_value - $pay_options->coupon_value; 
                endif;
                $shop_id = '6';

//                $razorpay_data = $this->db->select('key_id, key_secret')->get_where('shops', array('id'=>$shop_id))->row();

//                // razorpay api 
//                $api = new Api($razorpay_data->key_id, $razorpay_data->key_secret);
//                $orderData = [
//                    'receipt'         => $order_id,
//                    'amount'          => $total_value*100, // 2000 rupees in paise
//                    'currency'        => 'INR',
//                    'payment_capture' => 1 // auto capture
//                ];
//                $razorpayOrder = $api->order->create($orderData);
//                // end razorpay api

                $response = json_encode(
                    array(
//                        'secret_key'=>$razorpay_data->key_id,
//                        'order_id_razor' => $razorpayOrder['id'],
                        'total' => $total_value
                    )
                );
                $user_detail = $this->user_model->get_row_data('customers','id',$user_id);
                $user_name = $user_detail->fname.' '.$user_detail->lname;
                $user_mobile = $user_detail->mobile;
                $user_email = $user_detail->email;

                echo json_encode(array('data'=>$response,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$order_id));
                break;
                case 'verify_payment':

                    $shop_id = '6';
                    $razorpay_data = $this->db->select('key_id, key_secret')->get_where('shops', array('id'=>$shop_id))->row();
    
                    $razorpay_payment_id = $this->input->post('razorpay_payment_id');
                    $razorpay_order_id = $this->input->post('razorpay_order_id');
                    $razorpay_signature = $this->input->post('razorpay_signature');
                    $order_idrazor = $this->input->post('order_idrazor');
                     $post = [
                        'order_idrazor'=>$order_idrazor,
                        'razorpay_order_id' => $razorpay_order_id,
                        'razorpay_payment_id' => $razorpay_payment_id,
                        'razorpay_signature' => $razorpay_signature,
                        'shopid' => '6',
                    ];
                    $success = 'true';
                    $api = new Api($razorpay_data->key_id, $razorpay_data->key_secret);
                    try{
                        $api->utility->verifyPaymentSignature($post);
                    }catch(SignatureVerificationError $e){
                        $success = 'Razorpay Error : ' . $e->getMessage();
                    }
                    echo $success;
                    break;
                case 'update_order_status':
    
                    $shop_id = 6;
                    // $bank_name = @$this->db->select('bank_name')->get_where('shops_account', array('shop_id'=>$shop_id))->row()->bank_name;
                    $payment_method = $this->input->post('payment_method');
                    $payment_id = $this->input->post('payment_id');
                    $signature = $this->input->post('signature');
                    $razorpay_ord_id = $this->input->post('razorpay_ord_id');
                    $order_id = $this->input->post('order_id');
                    
                    $data = [
                        'status'=> '17',
                        'razorpay_order_id' => $razorpay_ord_id,
                        'razorpay_payment_id' => $payment_id,
                        'razorpay_signature' => $signature,
                        'payment_method' => $payment_method,
                        // 'bank_name' => $bank_name
                    ];
                    
                    //update inventory
                    if($this->db->where('id',$order_id)->update('orders',$data))
                    {
                        // Log Insertion
                        $status_id = '17';
                        $logdata = array('order_id' => $order_id, 'status_id' => $status_id);
                        $this->db->insert('order_status_log', $logdata);
                        // End Log Insertion
                        $all_data = $this->user_model->fetch_shop_inventory($order_id);
                        foreach ($all_data as $inventory) {
                            $inventory_id = $inventory->inventory_id;
                            $get_product_stock = $this->user_model->get_data('shops_inventory','id',$inventory_id);
                            if(!empty($get_product_stock))
                            {
                                foreach($get_product_stock as $stock)
                                {
                                    $inventory_data['qty'] = $stock->qty - $inventory->qty;
                                    $this->user_model->edit_data('shops_inventory', 'id', $inventory_id, $inventory_data);
                                }
                            }
                           }
                        $rs = $this->user_model->get_user_id($order_id[0]);
                        $this->user_model->delete_data1('cart','user_id',$rs->id);
                        
                        echo "success";
                    }
                    else
                    {
                        echo "failed";
                    }
                    break;
            case 'user_profile':
                if($this->session->userdata('logged_in'))
                {
                    $user_id = $this->session->userdata('user_id');
                }
                else
                {
                    $user_id = get_cookie("user_id");
                }
                $data['user_details'] = $this->user_model->get_row_data('customers','id',$user_id);
                $this->load->view('user/my_profile',$data);
            break;
            
            case 'delievery_address':
                $user_id = $this->session->user_id ? $this->session->user_id : get_cookie("user_id");
                $data['addresses'] = $this->user_model->get_data1('customers_address','customer_id',$user_id);
                $data['edit_addr_url'] = base_url().'user/users/edit_address/';
                $this->load->view('delievery_address',$data);
            break;
            case 'order_details':
                $oid = $this->uri->segment(2);
                $data['title'] = 'Order Details';
                $data['order_details'] = $this->user_model->order_details($oid);
                $page = 'user/order_details';
                $this->header_and_footer($page, $data);
            break;
            case 'delete_cart':
                $cart_id = $this->input->post('cart_id');
                if($this->home_model->delete_data1('cart','id',$cart_id))
                {
                    echo "success";
                }
            break;
        }
    }
	public function handle_payment_response() {
        $inputParams = $this->input->post();
        if (isset($inputParams["order_id"])) {
            try {
                $params = [
                    "order_id" => $inputParams["order_id"],
                    "status" => $inputParams["status"],
                    "signature" => $inputParams["signature"],
                    "status_id" => $inputParams["status_id"]
                ];

                $order = $this->get_order_status($params);
                $message = $this->get_status_message($order);
            } catch (APIException $e) {
                http_response_code(500);
                $error = json_encode([
                    "message" => $e->getErrorMessage(),
                    "error_code" => $e->getErrorCode(),
                    "http_response_code" => $e->getHttpResponseCode()
                ]);
                $msg= " Payment server threw a non-2xx error. Error message: {$error}";
				echo json_encode(array('error'=>'true','msg'=>" Unexpected error occurred, Error message:".$msg));
                exit;
            } catch (Exception $e) {
                http_response_code(500);
                $msg= "Unexpected error occurred, Error message:  {$e->getMessage()}";
				echo json_encode(array('error'=>'true','msg'=>" Unexpected error occurred, Error message:".$msg));
                exit;
            }
        } else {
            http_response_code(400);
            $msg= "Required Parameter Order Id is missing";
			echo json_encode(array('error'=>'true','msg'=>" Unexpected error occurred, Error message:".$msg));
            exit;
        }

        $data['message'] = $message;
        $data['inputParams'] = $inputParams;
        $data['order'] = $order;
        // Prepare the data to be stored in the hdfc column
        // $hdfcData = json_encode($data);
        // $this->db->update('orders', ['hdfc' => $hdfcData], ['orderid' => $order["order_id"]]);
		$shop_id = 6;
        $data['shop_detail'] = $this->home_model->get_shop_detail($shop_id);
        $data['title'] = 'Thanks';
		  if ($order['status'] != 'CHARGED') {
			  $redirect_url = base_url('error/'.$order["order_id"]);
		  }else{
		      $redirect_url = base_url('thanks/'.$order["order_id"]);
		  }
		  header("Location: " . $redirect_url, true, 303);
		  exit;
    }

    public function get_order_status($params) {
        $paymentHandler = new PaymentHandler(APPPATH . "third_party/hdfc/resources/config.json");
        if ($paymentHandler->validateHMAC_SHA256($params) === false) {
            throw new APIException(-1, false, "Signature verification failed", "Signature verification failed");
        } else {
            $order = $paymentHandler->orderStatus($params["order_id"]);
            return $order;
        }
    }

    public function get_status_message($order) {
        $message = "Your order with order_id " . $order["order_id"] . " and amount " . $order["amount"] . " has the following status: ";
        $status = $order["status"];

         $orderNO =$order["order_id"];
        switch ($status) {
            case "CHARGED":
                $message .= "order payment done successfully";
				$data = [
					'status'=> '17',
					'payment_method'=>'1',
				];
				if($this->db->where('orderid',$orderNO)->update('orders',$data))
				{
					$status_id = '17';
					$OrderNo = $this->model->getRow('orders',['orderid'=>$orderNO]);
					$order_id = @$OrderNo->id;
					$logdata = array('order_id' => $order_id, 'status_id' => $status_id);
					$this->db->insert('order_status_log', $logdata);
					// End Log Insertion
					$all_data = $this->user_model->fetch_shop_inventory($order_id);
					foreach ($all_data as $inventory) {
						$inventory_id = $inventory->inventory_id;
						$get_product_stock = $this->user_model->get_data('shops_inventory','id',$inventory_id);
						if(!empty($get_product_stock))
						{
							foreach($get_product_stock as $stock)
							{
								$inventory_data['qty'] = $stock->qty - $inventory->qty;
								$this->user_model->edit_data('shops_inventory', 'id', $inventory_id, $inventory_data);
							}
						}
					   }
					$rs = $this->user_model->get_user_id($order_id);
					$this->user_model->delete_data1('cart','user_id',$rs->id);
				}
                break;
            case "PENDING":
				$data = [
					'status'=> '1',
				];
				$this->db->where('orderid',$orderNO)->update('orders',$data);
				break;
            case "PENDING_VBV":
				$data = [
					'status'=> '1',
				];
				$this->db->where('orderid',$orderNO)->update('orders',$data);
                $message .= "order payment pending";
                break;
            case "AUTHORIZATION_FAILED":
				$data = [
					'status'=> '1',
				];
				$this->db->where('orderid',$orderNO)->update('orders',$data);
                $message .= "order payment authorization failed";
                break;
            case "AUTHENTICATION_FAILED":
				$data = [
					'status'=> '1',
				];
				$this->db->where('orderid',$orderNO)->update('orders',$data);
                $message .= "order payment authentication failed";
                break;
            default:
			$data = [
				'status'=> '1',
			];
			$this->db->where('orderid',$orderNO)->update('orders',$data);
                $message .= "order status " . $status;
                break;
        }
        return $message;
    }



    public function checkout_cart()
    {
        $data['coupon_url'] = base_url('checkout/coupon');
        $this->load->view('checkout_cart', $data);
    }

    public function coupon()
    {
        // discount type 0 for fixed and 1 for percentage
        $shop_id = 6;
        $this->db->select('*')
            ->from('coupons_and_offers')
            ->where('coupan_or_offer', 0)
            ->where("'".date('Y-m-d')."' BETWEEN start_date AND expiry_date", NULL)
            ->where('active', 1);
        if( @$_GET['code'] ):
            $this->db->where('id', _decode($_GET['code']));
            $result = $this->db->get()->row();
            echo json_encode($result);
            die();
        endif;
        $this->data['rows'] = $this->db->get()->result();
        $this->load->view('coupon', $this->data);
    }

    public function test()
    {     
        $post = [
            'orderid' => 11,
            'total' => 1000,
            'shopid' => 6,
        ];
        $ch = curl_init('http://3.12.154.83/shopzone/shopzonews/index.php/utility/generateOrderRemote');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // execute!
        $response = curl_exec($ch);
        echo json_encode($response);
        // close the connection, release resources used
        curl_close($ch);
    }
    public function fetch_city()
    {
        if($this->input->post('state'))
        {
            //echo "hello";die();
            $sid= $this->input->post('state');
            $this->user_model->fetch_city($sid);
        }
    }
}
