<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href='<?=base_url();?>'>Home</a>
                        </li>
                        <li class="active">Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    $shop_id = '6';
    $shop_detail = $this->home_model->get_shop_detail($shop_id);
	$cart_data = cart_data();
	if( $cart_data ):
?>
        <div class="cart-area pt-75 pb-35">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <div class="cart-table-content">
                                <div class="table-content table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="width-thumbnail">Product</th>
                                                <th class="width-name"></th>
                                                <th class="width-price"> Price</th>
                                                <th class="width-quantity">Quantity</th>
                                                <th class="width-subtotal">Subtotal</th>
                                                <th class="width-remove"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                            
                            $delivery_charges = 0.00;  
                            
                            $user_id = $this->session->userdata('user_id');
                            $address = $this->user_model->get_data1('customers_address','customer_id',$user_id);
                            foreach($address as $row){
                                if ($row->is_default==1) {
                                    $query = $this->user_model->get_data1('pincodes_criteria','pincode',$row->pincode);
                                    //$delivery_charges = $query[0]->price;
                                    $delivery_charges=0.00;
                                }
                            }   

                            $totalsaveoffer =  $subtotaloffer=  $total_savings =  $totalovervalue =  $afernotsaving = $subtotalofferall = $subtotal = $total_cutting_price = 0;
                            foreach( $cart_data as $cart ):
                                $product_id = $cart->product_id;
                                $cart_items = $this->product_model->product_details($product_id);
                                 $cutting_price = $cart->qty * $cart_items->selling_rate;
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
                                 $total_cutting_price = $total_cutting_price + $cutting_price;

                                $offer_type = ($cart_items->discount_type =='1') ? $cart_items->offer_upto.'%' : '₹'.$cart_items->offer_upto;
                               
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
                                          // $total_savings = $total_cutting_price - $subtotal;
                                    }
                                
                                 }else{
                                    $afernotsaving = $afernotsaving + $cart_items->selling_rate*$cart->qty;     
                                    $subtotal = $subtotal + ($selling_rate) ;
                                     $total_savings = $total_cutting_price - $subtotal;
                                
                                 }
                                     $totalovervalue = $subtotaloffer+$afernotsaving;
                                     //echo $total_savings += $totalsaveoffer;
               
                                if( is_logged_in() ):
                                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="decrease_quantity('.$cart->id.','.$product_id.',this)"><i style="font-size:8px" class="fas fa-minus"></i></a> ';
                                    $input .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$cart->qty.'" onchange="quantity_by_input('.$cart->id.','.$product_id.', this)">';
                                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus"  href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="increase_quantity('.$cart->id.','.$product_id.', this)"><i style="font-size:8px" class="fas fa-plus"></i></a>';
            	               else:
                                    $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_decrease_quantity('.$product_id.',this)"><i style="font-size:8px" class="fas fa-minus"></i></a> ';
                                    $input .= '<input class="count-number-input qty-val'.$product_id.'" type="number" value="'.$cart->qty.'" onchange="cookie_quantity_by_input('.$product_id.',this)">';
                                    $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$product_id.'" onclick="cookie_increase_quantity('.$product_id.',this)"><i style="font-size:8px" class="fas fa-plus"></i></a> ';
            	               endif;
                               //print_r($subtotal);
                               $pid_by_inv_id = $this->product_model->getRow('shops_inventory',['id'=>$product_id]);
                            //    $deal = $this->product_model->get_data('multi_buy','product_id',$pid_by_inv_id->product_id);  
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
                                //echo   $total_savings =  $totalsave+$totalsaveoffer;
		                      ?>
                              <?php $rs = $this->product_model->get_cart_url($pid_by_inv_id->product_id);$url = $rs->url  ? $rs->url : 'null';?>
                            <?php   //$rsvalue = $this->product_model->get_value($pid_by_inv_id->product_id);?>
                                            <tr>
                                                <td class="product-thumbnail">
                                                <a href="<?= base_url('product/'.$url) ?>">  <img alt="<?=$cart_items->product_name?>" src="<?php echo displayPhoto($cart_items->img); ?>" class="img-fluid"></a>
                                                </td>
                                                <td class="product-name">
                                                <a href="<?= base_url('product/'.$url) ?>"> <h5 class="product-name text-uppercase"> <strong><?= ( @$cart_items->flavour_name) ?></strong></h5></a>
                                           <a href="<?= base_url('product/'.$url) ?>"> <h5 class="product-name"><?php if(@$cart_items->product_name){ echo strip_tags( $cart_items->product_name) ; } ?><?=@$rsvalue->value;?></h5></a>
                                                </td>
                                                
                                                <?php $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$pid_by_inv_id->product_id);
                                    // echo $this->db->last_query();
                                    foreach($offers as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $offervalue=   $offer->offer_associated.' % OFF ';
                                        $offertype=$offer->discount_type;
                                         $finalperlist = $cart_items->selling_rate*$offer->offer_associated/100;
                                          $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                      
                                    }else
                                    {
                                        $offervalue ='Only '.$shop_detail->currency.'  '.$cart_items->selling_rate-$offer->offer_associated;
                                        $offertype=$offer->discount_type;
                                        $finalamountlist = ($cart_items->selling_rate-$offer->offer_associated);
                                        // $finalamountlist = $cart_items->selling_rate-$finalperlist;
                                       
                                    }    
                                    
                                    }?>  
                                        <?php if(!empty($offers))
                                         {?>
                                          <td class="product-price" data-title="Price">
                                             <span><del class="text-primary"><?= $shop_detail->currency; ?><?php echo bcdiv(($cart_items->selling_rate), 1, 2); ?> </del> 
                                          <h3 class="amount text-danger"><?= $shop_detail->currency; ?><?php echo bcdiv(($finalamountlist), 1, 2); ?> </h3>
                                         </span>
                                          </td>
                                          <?php }
                                          else{?>
                                            <td class="product-price" data-title="Price"><h3 class="amount text-danger"><?= $shop_detail->currency; ?> <?=_round($cart_items->selling_rate,2); ?></h3>
                                            </td>
                                           <?php }?>


                                            <td class=" text-center" data-title="Stock" add-to-cart-div-<?=$product_id ?>>
                                            <div id="plusminuscart">
                                            <?=$input; ?>
                                            </div>
                                            </td>
                                            <?php if(!empty($offers))
                                         {?>
                                        <td class="product-total" data-title="Cart">
                                         <h3 class="text-danger"><?= $shop_detail->currency; ?>
                                         <?php echo bcdiv(($subtotaloffer), 1, 2); ?> </h3>
                                        </td>
                                        <?php }else{?>
                                            <td class="product-total" data-title="Cart">
                                            <h3 class="text-danger"><?= $shop_detail->currency; ?> 
                                            <?php echo bcdiv(($selling_rate), 1, 2); ?></h3>
                                        </td>
                                            <?php }?>


                                                <td class="product-remove action" data-title="Remove"><a href="javascript:void(0)" onclick="removeFromCart('<?=$product_id?>')" class="text-muted icon" >Remove</a></td>
                                            </tr>
                                            <?php
                                    endforeach;
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart-shiping-update-wrapper">
                                    
                                    <!-- <div class="update-btn">
                                        <a href='/medizin/cart'>Update cart</a>
                                    </div> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                     <?php  $delivery_charges =  delivery_charge($subtotal);?>
                <div class="col-lg-4 col-md-12 col-12"></div>
                    <div class="col-lg-8 col-md-12 col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <h3>Cart Totals</h3>
                                <hr>
                                <div class="grand-total-wrap mb-40">
                                    <ul>
                                        <li>Cart Subtotal
                                        <?php if(!empty($offers))
                                                      {?>
                                                    <h4><?= $shop_detail->currency; ?>
                                                    <?php echo bcdiv(($subtotal), 1, 2); ?></h4>
                                                    <?php }else{?>
                                                        <h4><?= $shop_detail->currency; ?> <?php echo bcdiv(($subtotal), 1, 2); ?> </h4>
                                                    <?php }?>
                                        </li>
                                        <li>Delivery Charges <h4> <?= $shop_detail->currency; ?> 
                                                    <?php echo bcdiv(($delivery_charges), 1, 2); ?> </h4>
                                        </li>
                                        <li>
                                        Your total savings
                                        <h4>
                                        <?= $shop_detail->currency; ?>
                                                    <?php echo bcdiv(($total_savings ?? '0'), 1, 2); ?>
                                        </h4>
                                        </li>
                                    </ul>
                                    <div class="grand-total">
                                        <h4>Total 
                                        <?php if(!empty($offers))
                                                      {?>
                                                    <span class="cart_total_amount"><strong><span class="font-xl fw-900 text-brand"><?= $shop_detail->currency; ?> 
                                                    <?php echo bcdiv(($subtotal+$delivery_charges), 1, 2); ?> </span></strong></span>
                                                    <?php }else{?>
                                                        <span class="cart_total_amount"><strong><span class="font-xl fw-900 text-brand"><?= $shop_detail->currency; ?>
                                                        <?php echo bcdiv(($subtotal+$delivery_charges), 1, 2); ?>
                                                       </span></strong></span>
                                                    <?php }?>
                                       </h4>
                                    </div>
                                    <div class="grand-total-btn">
                                        <a href='<?=base_url('checkout');?>'>Proceed To CheckOut</a>
                                    </div>
                                      <div class="grand-total-btn mt-2">
                                            <a href="<?=base_url();?>">Continue shopping</a>
                                            </div>
                                            <div class="grand-total-btn mt-2">
                                        <?php
                                    if (is_logged_in()):
                                    ?>
                                    <div class="button clearcart">
                                            <a href="javascript:void(0)" onclick="delete_cart_all(this)" class="view-cart">Clear Cart</a>
                                            
                                        </div>
                                    <?php else: ?>
                                    <div class="button clearcart">
                                            <a href="javascript:void(0)" onclick="delete_cookie_cart_all()" class=" view-cart">Clear Cart</a>
                                            
                                        </div>
                                    <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
    <section class="py-5">
        <h1 class="text-center">Cart is empty.</h1>
    </section>
    <?php endif; ?>


    <input type="hidden" id="deleteId" />
<script>

     function removeFromCart(pid){
    
        <?php if( is_logged_in() ): ?>
                delete_cart(<?=$cart_items->cart_id ?>,pid,this);
        <?php else: ?>
                delete_cookie_cart(pid,this);
        <?php endif; ?>
     }

</script>