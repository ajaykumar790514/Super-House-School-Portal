<?php 
$shop_id = '6';
$shop_detail = $this->home_model->get_shop_detail($shop_id);

$cart_data = cart_data(); ?>
<div class="card-header" style="background-color: #F8F8F8;">
    <h4 class="text-black mb-0">Cart Summary <span class="text-primary">(<?= count($cart_data) ?> item)</span></h4>
</div>
<div class="card-body">

<ul>
    <?php
        $user_id = $this->session->userdata('user_id');
        $address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
        // foreach($address as $row){
        //     if ($row->is_default==1) {
        //         $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
        //         if ($query == TRUE) {
        //             $delivery_charge = $query[0]->price;
        //         }else{
        //             $delivery_charge = 0.00;
        //         }
                
        //     }
        // }
        // print_r($address);

        $totalsaveoffer =  $subtotaloffer=  $total_savings =  $totalovervalue =  $afernotsaving = $subtotalofferall =$subtotal = $total_cutting_price = $total_tax = $TotalQty=0;
		foreach( $cart_data as $cart ):
			$product_id = $cart->product_id;
            $cart_items = $this->product_model->product_details($product_id);
            $cutting_price = $cart->qty*$cart_items->selling_rate;
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

            $offer_type = ($cart_items->discount_type =='1') ? $cart_items->offer_upto.'%' : '₹'.$cart_items->offer_upto;
            //end of calculate selling rate
            $total_cutting_price = $total_cutting_price + $cutting_price;

            //  $subtotal = $subtotal + ($selling_rate);
            //  $total_savings = $total_cutting_price - $subtotal;
             // if offer iplicable
             if(!empty($cart_items->offer_upto))
             {
                if($cart_items->discount_type=='1')
                {
                     $subtotaloffer = $selling_rate;
                     $subtotal = $subtotal + bcdiv(($selling_rate),1,2);
                      $totalsaveoffer = $total_cutting_price-$subtotal ;
                      $total_savings = $total_cutting_price - $subtotal;
                }else{
                      $subtotaloffer= ($cart_items->selling_rate-$cart_items->offer_upto)*$cart->qty ;
                      $subtotal = $subtotal + $subtotaloffer;
                      $totalsaveoffer = $total_cutting_price-$subtotal;
                      $total_savings = $total_cutting_price - $subtotal;
                }
            
             }else{
                  $afernotsaving = $afernotsaving + $cart_items->selling_rate*$cart->qty;     
                  $subtotal = $subtotal + ($selling_rate) ;
                  $total_savings = $total_cutting_price - $subtotal;
            
             }
                 $totalovervalue = $subtotaloffer+$afernotsaving;
            $tax = $cart_items->product_tax; 
            $total_value = $selling_rate;
            $inclusive_tax = $total_value - ($total_value * (100/ (100 + $tax)));
            $total_tax += $inclusive_tax;

            $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
            //$deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
          //   $totalsave=0;
          //   if($cart_items->discount_type !='1' &&  $cart_items->discount_type !='0')
          //   {
          //    foreach($deal as $rowdeal){
          //         if ($rowdeal->qty == $cart->qty) {
          //             $subtotal = $subtotal - $selling_rate;
          //              $selling_rate = $rowdeal->price;
          //                 $subtotal = $subtotal + $selling_rate ;   //last subtotal
          //              if($cart_items->discount_type=='1' || $cart_items->discount_type=='0')
          //              {

          //              }else
          //              {
          //                   $totalsave = $totalovervalue-$subtotal;
          //              }
                     
          //         }
          //    }       
          // }                              
          //      $total_savings =  $totalsave+$totalsaveoffer; 
                    //    if($cart_items->discount_type!='0' && $cart_items->discount_type!='1')
                    //     {
                    //     $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
                    //     $deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
                    //     foreach($deal as $rowdeal){
                    //         if ($rowdeal->qty == $cart->qty) {
                    //             $subtotal = $subtotal - $selling_rate;
                    //             $total_price = $rowdeal->price;
                    //             $selling_rate = $total_price;
                    //             $subtotal = $subtotal + bcdiv(($total_price),1,2);
                    //             $offer_apply =$rowdeal->qty.' For '.$shop_detail->currency.''.$rowdeal->price;
                    //             $offer_type_new =2;
                    //             $total_savings = $total_cutting_price - $subtotal;
                    //         }
                    //     }  
                    //     } 
	?>
        <?php $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$pid_by_inv_id->product_id);
                                    // echo $this->db->last_query();
                                    foreach($offers as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $offervalue=   $offer->offer_associated.' % ';
                                        $offertype=$offer->discount_type;
                                         $finalperlist = $cart_items->selling_rate*$offer->offer_associated/100;
                                          $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                      
                                    }else
                                    {
                                        $offervalue =$shop_detail->currency.'  '.$offer->offer_associated;
                                        $offertype=$offer->discount_type;
                                        $finalamountlist = ($cart_items->selling_rate-$offer->offer_associated);
                                        // $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                    }    
                                    
                                    }
                                    //echo $subtotal;?>
                                    <?php   //$rsvalue = $this->product_model->get_value($pid_by_inv_id->product_id);?>
                                    <?php $rs = $this->product_model->get_cart_url($pid_by_inv_id->product_id);$url = $rs->url  ? $rs->url : 'null';?>
        <li style="border-bottom: 1px dashed;padding-bottom: 20px;">
            <div class="shopping-cart-img">
                <a href="<?= base_url('product/'.$url) ?>"><img alt="" src="<?php echo displayPhoto($cart_items->img); ?>" class="img-fluid"></a>
            </div>
            <div class="shopping-cart-title">
                <h4><label><?=@$cart_items->flavour_name;?></label><br><a href="<?= base_url('product/'.$url) ?>" title="<?= $cart_items->product_name; ?>"><?= strip_tags( $cart_items->product_name) ?></a></h4>
                <?php if(!empty($offers)){?>
                <h4><?= $shop_detail->currency; ?><?php echo bcdiv(($finalamountlist), 1, 2); ?> </h4>
                <?php }else{?>
                <h4><?= $shop_detail->currency; ?><?php echo bcdiv(($cart_items->selling_rate), 1, 2); ?> </h4>
                <?php }?>
                <h6><span class="text-danger"><?=@$rsvalue->value;?></span></h6>
<!--
                <i class="fi-rs-star"></i>
                    <span class="font-small ml-5 text-muted"> (<?=  $cart_items->rating ?>)</span>
-->
                
<!--                <p> <?=$cart_items->unit_value ?> <?= $cart_items->unit_type ?></p>-->
                    
                <?php if($cart_items->stock_qty > 0): ?>
                        <span class="count-number<?=$product_id?> float-left">
                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in"))
                            { ?>
                            <a  aria-label="-" class="action-btn-qty-detail action-btn hover-up me-1  add-cart plusminuss"  href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="decrease_quantity(<?= $cart_items->cart_id ?>,<?= $product_id ?>,this)"><i style="font-size:8px" class="fas fa-minus"></i></a> 
                            <?php  } 
                            else
                            { ?>
                            <a  aria-label="-" class="action-btn-qty-detail action-btn hover-up me-1 add-cart plusminuss" href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="cookie_decrease_quantity(<?= $product_id ?>,this)">
                            <i style="font-size:8px" class="fas fa-minus"></i></a> 
                            <?php  } ?>

                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in")){ ?>
                            <input class="text-center count-number-input qty-val<?= $product_id ?>" type="number" value="<?= $cart->qty ?>" min="0" onchange="quantity_by_input(<?= $cart_items->cart_id?>,<?= $product_id ?>, this)">
                        <?php }else{ ?>
                            <input class="text-center count-number-input qty-val<?= $product_id ?>" type="number" value="<?= $cart->qty ?>" min="0" onchange="cookie_quantity_by_input(<?= $product_id ?>, this)">
                            <?php  } ?>
                            

                            <?php if($this->session->userdata('logged_in') || get_cookie("logged_in"))
                            { ?>
                            <a  aria-label="+" class="action-btn hover-up ms-1 add-cart plusminuss"  href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="increase_quantity(<?= $cart_items->cart_id?>,<?=$product_id ?>, this)"><i style="font-size:8px" class="fas fa-plus"></i></a>
                            <?php  } 
                            else
                            { ?>
                            <a  aria-label="+" class="action-btn hover-up ms-1 add-cart plusminuss" href="javascript:void(0)" data-target=".qty-val<?= $product_id ?>" onclick="cookie_increase_quantity(<?= $product_id ?>, this)"><i style="font-size:8px" class="fas fa-plus" ></i></a>
                            <?php  } ?>
                        </span>
                <?php else: ?>
                 <h6><strong><span class="mdi mdi-brightness-5"></span> Out Of Stock</strong></h6>
                 <?php endif; ?>
       <?php //echo (($subtotal)); ?>
            </div>
           
            <div class="shopping-cart-delete">  
                <a href="javascript:void(0)" 
                onclick="<?php if( is_logged_in() ) :
                    echo 'delete_cart('.$cart_items->cart_id.','.$product_id.',this)';
                    else:
                    echo 'delete_cookie_cart('.$product_id.',this)';
                    endif; ?> "><i class="ti-trash text-danger" aria-hidden="true"></i></a>
            </div>
                 
        </li>			
		
		<?php
				endforeach;
		?>
    </ul>
</div>

<!-- End Cart Body -->
<div class="card-footer" style="background-color: #F8F8F8;">
     <div class="shopping-cart-footer">
        <div class="shopping-cart-total">
            <input type="hidden" name="sub_total" value="<?php echo bcdiv(($subtotal), 1, 2); ?>">
          <?php  $delivery_charge =  delivery_charge($subtotal);?>
              <h4>Sub Total <span><?= $shop_detail->currency; ?><?php echo bcdiv(($subtotal), 1, 2); ?>  </span></h4>
            <!-- <h4>Sub Total <span><?= $shop_detail->currency; ?><?= number_format((float)(_round($subtotal-$total_tax)), 2, '.', '') ?></span></h4> -->
            <!-- <h4>Total Tax <span><?= $shop_detail->currency; ?><?= number_format((float)(_round($total_tax)), 2, '.', '') ?> </span></h4> -->
            <?php
             /*   $el_amnt = 0;
                $delivery_charge =0.00;
                if ($subtotal <= $shop_detail->free_delivery_eligibility) {
                    // $el_amnt = $shop_detail->free_delivery_eligibility - $subtotal;
                    // echo "<p class='mb-0 text-warning eligible-text'>Add more ".$shop_detail->currency." ".number_format($el_amnt, 2)." for free delivery.</p>";
                }else{
                    $delivery_charge = 0.00;
                }*/
            ?>
            
            <h4>Delivery Charges <span><?= $shop_detail->currency; ?> <span class="delivery-charge">
            <?php echo bcdiv(($delivery_charge), 1, 2); ?></span></span></h4>
            
            <h4>Your total savings <span><?= $shop_detail->currency; ?><?php echo bcdiv((@$total_savings), 1, 2); ?> </span></h4> 
            
            <h4>Total <span><?= $shop_detail->currency; ?> <span class="sub-total">
            <?php echo bcdiv(($subtotal+$delivery_charge), 1, 2); ?></span></span></h4>
            <br/>
           <h4><b>To Pay</b> <span style="font-size: 1.2rem;" class="text-danger"><b><?= $shop_detail->currency; ?> <span class="to-pay text-danger"><?php echo bcdiv(($subtotal+$delivery_charge), 1, 2); ?></b></span></span></h4>
             
            <div class="cart-store-details"> 
                <div class="coupon-head"></div> 
            </div>
        </div>   
    </div>
</div>
