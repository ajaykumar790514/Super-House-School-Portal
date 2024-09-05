<?php
            if($product->discount_type=='0') //0->rupee
            {
                 $selling_rate = $product->selling_rate - $product->offer_upto;
            }
            else if($product->discount_type=='1') //1->%
            {
                $selling_per = ($product->selling_rate * $product->offer_upto)/100;
                $selling_rate = $product->selling_rate - $selling_per;
            }else
            {
                $selling_rate = $product->selling_rate;
            }
            $discount_price = $product->mrp - $selling_rate;
            $offer_type = ($product->discount_type =='1') ? $product->offer_upto.'%' : '₹'.$product->offer_upto;
                            
        ?>
        <!-- section start -->
       <div class="product-details-area padding-30-row-col pt-25 pb-75">
            <div class="custom-container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="product-details-wrap">
                            <div class="product-details-wrap-top">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                    <?php //echo $product->id;
                                    $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$product->id);
                                    foreach($offerss as $offer)
                                    {
                                    if($offer->discount_type==1)
                                    {
                                        $deatailoffervalue=   $offer->offer_associated.' % OFF';
                                        $deatailoffertype=$offer->discount_type;
                                         $deatailfinalper = $product->selling_rate*$offer->offer_associated/100;
                                         $deatailfinalamount = $product->selling_rate-$deatailfinalper;
                                    }else
                                    {
                                        $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$product->selling_rate-$offer->offer_associated;
                                        $deatailoffertype=$offer->discount_type;
                                        $deatailfinalamount = ($product->selling_rate-$offer->offer_associated);
                                        // $deatailfinalamount = $product->selling_rate-$deatailfinalper;
                                    }    
                                    
                                    }?>
                                 <?php
                            $flag = 0; 
                            $cart_data = cart_data();
                            $cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();
                            $flag = in_array($inventory_id, $cart_items) ? 1 : 0;

                            $cart_qty = $product->cart_qty ? $product->cart_qty : 1;
                            $cart_style = 'btn-secondary';
                            $cart_onclick = 'add_to_cart('.$inventory_id.',this,2)';
                            $cart_title = 'Add to cart';
                            $cart_css = '';
                            $cart_toggle = '';
                            if( $flag == 1 ):
                                $cart_qty = $cart_id = 0;
                                foreach( $cart_data as $cd ):
                                    if( $cd->product_id==$inventory_id ):
                                        $cart_qty = $cd->qty;
                                        $cart_id = @$cd->id;
                                        break;
                                    endif;
                                endforeach;
                            if( is_logged_in() ):
                                $input = '<a aria-label="-" class="plusminus action-btn hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="decrease_quantity('.$cart_id.','.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="number" value="'.$cart_qty.'" onchange="quantity_by_input('.$cart_id.','.$inventory_id.', this)">';
                                $input .= '<a aria-label="+" class="plusminus action-btn hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="increase_quantity('.$cart_id.','.$inventory_id.', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
                            else:
                                $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_decrease_quantity('.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                                $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="number" value="'.$cart_qty.'" onchange="cookie_quantity_by_input('.$inventory_id.', this)">';
                                $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart plusminus" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_increase_quantity('.$inventory_id.',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                            endif;
                            endif;
                        ?>
                                        <div class="product-details-slider-wrap">
                                            <div class="pro-dec-big-img-slider">
                                            <?php if($product_photos){ $i=0; foreach($product_photos as $photos):  ?>
                                                <div class="single-big-img-style">
                                                    <div class="pro-details-big-img">
                                                        <a class="img-popup" href="<?php echo displayPhoto($photos->img); ?>">
                                                            <img src="<?php echo displayPhoto($photos->img); ?>" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="pro-details-badges product-badges-position">
                                                        <?php if(!empty($offerss))
                                                         {?>
                                                        <span class="red"><?=$deatailoffervalue;?></span>
                                                        <?php   }?>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; }else{ ?>
                                                 <div class="single-big-img-style">
                                                    <div class="pro-details-big-img">
                                                        <a class="img-popup" href="<?=base_url('assets\images\noimg\new.png');?>">
                                                            <img height="500px" src="<?=base_url('assets\images\noimg\new.png');?>" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="pro-details-badges product-badges-position">
                                                        <?php if(!empty($offerss))
                                                         {?>
                                                        <span class="red"><?=$deatailoffervalue;?></span>
                                                        <?php   }?>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>
                                            <div class="product-dec-slider-small product-dec-small-style1">
                                            <?php if($product_photos){ $i=0; foreach($product_photos as $photos):  ?>
                                                <div class="<?= ($i==0)?'product-dec-small active':'product-dec-small' ?>">
                                                    <img src="<?php echo displayPhoto($photos->img); ?>" alt="">
                                                </div>
                                                <?php $i++; endforeach;}else{ ?>
                                                <div class="product-dec-small active">
                                                    <img src="<?=base_url('assets\images\noimg\new.png');?>" alt="">
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="product-details-content pro-details-content-pl">
                                            <div class="pro-details-category">
                                                <ul>
                                                    <li><a href='#'>Code : <?=$product->product_code?> </a></li>
                                                </ul>
                                            </div>
                                            <h1><?=$product->prod_name?></h1>
                                            <div class="pro-details-price-short-description">
                                                <div class="pro-details-price ">
                                                  <?php if(!empty($offerss))
                                                { ?>
                                                <span>
                                                    <del class="old-price"> 
                                                        <?= $shop_detail->currency; ?><?php echo number_format((float)($product->selling_rate), 2, '.', ''); ?>
                                                    </del>
                                                    <h4 class="new-price">
                                                        <?= $shop_detail->currency; ?><?php echo number_format((float)($deatailfinalamount), 2, '.', ''); ?>
                                                    </h4>
                                                </span>
                                                <?php  }else{?>
                                                    <span>
                                                        <h4 class="new-price"><?= $shop_detail->currency; ?><?php echo number_format((float)($selling_rate), 2, '.', '') ;?></h4>
                                                    </span>
                                                <?php }?>
                                                    <!-- <span class="new-price">$19.00 - $29.00</span>
                                                    <span class="old-price">$19.00 - $35.00</span> -->
                                                </div>
                                            </div>
                                            <div class="pro-details-color-wrap">
                                            </div>
                                     <div class="product-buttons">
                                     <div class="product-extra-link2 add-to-cart-div-<?=$inventory_id?>">
                                     <?php
                                      if($shop_detail->is_ecommerce == '1'):
                                        if( $product->qty > 0 ): 
                                         ?>          
                                            <div class="pro-details-quality-stock-area">
                                                <span>Quantity</span>
                                                <div class="newcart_btn">
                                                <a aria-label="-" class="action-btn-qty-detail hover-up me-1 add-cart plusminuss" href="javascript:void(0)" onclick="decrease_quantity_by_btn(this)"><i style="font-size:8px" class="fas fa-minus"></i></a>

                                                <input class="count-number-input" type="number" value="1" onchange="quantity_by_input_by_btn(this)">

                                                <a aria-label="+" class="action-btn-qty-detail hover-up ms-1 add-cart plusminuss" href="javascript:void(0)" onclick="increase_quantity_by_btn(this)"><i style="font-size:8px" class="fas fa-plus"></i></a>
                                            </div>
                                            </div>
                                            <div class="pro-details-action-wrap">
                                                <div class="pro-details-add-to-cart">
                                                    <button id="cart_btn<?=$inventory_id?>" onclick="add_to_cart_by_btn(<?=$inventory_id?>,this)" href="javascript:void(0)"><i class="fa fa-shopping-bag"></i> Add to cart</button>
                                                    <?php
                                                    //endif;
                                                    else:
                                                    ?>
                                                    <button >Out of Stock</button>
                                                    <?php if( is_logged_in() ): ?>
                                                        <button type="button" class="button button-add-to-cart btn-solid" onclick="notify_me(<?=$this->session->userdata('user_id')?>,<?= $product->id ?>,this)">Notify Me</button>
                                                    <?php else:?>
                                                        <button type="button" class="button button-add-to-cart btn-solid" onclick="openAccount()">Notify Me</button>
                                                    <?php endif;?>

                                                    <?php
                                                        endif;
                                                        endif;
                                                    ?>  
                                                </div>
                                               
                                                <div class="pro-details-action tooltip-style-4">
                                                    <!-- <button type="button" href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('<?=$product->id;?>"  aria-label="Add To Wishlist"><i class="fad fa-heart"></i> </button> -->
                                                    <?php
                                                    $wishlist_btn = '<button href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('.$product->id.')" aria-label="Add To Wishlist"><i class="far fa-heart" aria-label="Add To Wishlist"  aria-hidden="true"></i></button>';

                                                    $wishlist_data = wishlist_data();
                                                    foreach ($wishlist_data as $row) {
                                                        $product_id = $row->product_id;            
                                                        if ($product_id == $product->id) {
                                                            $wishlist_btn = '<button href="javascript:void(0)" title="Already added" class="wishlist text-danger" aria-label="Add To Wishlist"><i class="far fa-heart"  aria-hidden="true"></i></button>';
                                                        }
                                                    }
                                                    
                                                    echo $wishlist_btn;
                                                ?>
                                                </div>
                                                <div class="row mt-2">
                                                <div class="col-6">
                                                <h4><?php if($product->ProductFlag=='bundle'){echo "This is Bundle for books";}else{ echo "Products";}?></h4>
                                            </div>
                                            <div class="col-6">
                                            <h4><?php if($product->ProductFlag=='bundle'){?><a class="text-danger" data-bs-toggle="modal" data-bs-target="#bundleModalSingle<?=$product->proid;?>">View Details</a><?php }?></h4>
                                                </div>
                                                </div>  
                                                 <!-- Bundle Details MOdel -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="bundleModalSingle<?=$product->proid;?>" tabindex="-1" aria-labelledby="bundleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bundleModalLabel"><?=$product->prod_name?> (  <?=$product->product_code?>  )</h5>
                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="row">
                                                    <div id="load-details-single-<?=$product->proid;?>"></div>
                                                </div>
                                                <script>
                                                    $(document).ready(function(){
                                                    setTimeout(()=> {
                                                        $("#load-details-single-<?=$product->proid;?>").load("<?=base_url()?>home/load_bundle_details/<?=$product->proid;?>");
                                                    }, 100);                                           
                                                });
                                                </script>   
                                                </div>
                                                </div>
                                            </div>
                                            </div> 
                                            <div class="border-product mt-3">
                                                <h4 class="product-title">Check Delivery Area</h4>
                                                <form class="row" method="POST" id="check-pincode-new">
                                                    <div class="col-8">
                                                        <input type="text" name="pincode" class="form-control" placeholder="Enter Your Pincode" style="height:40px" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <button type="submit" class="btn btn-solid">Check</button>
                                                    </div>
                                                </form>
                                                <p id="available-msg" style="font-size:20px"></p>
                                            </div>                    
                                                </div>                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-wrap-bottom">
                                <div class="product-details-description">
                                    <div class="entry-product-section-heading">
                                        <h2>Description</h2>
                                    </div>
                                    <?php
                                        foreach($product_desc as $result):            
                                    ?>
                                    <p><p><?= $result['description'];?></p></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- Related Product Dynamic by AJAY KUMAR -->

         <?php if($similer_products): ?>
        <div class="product-area border-top-2 pt-75 pb-70">
            <div class="custom-container">
                <div class="section-title-1 mb-40">
                    <h2>Related Products</h2>
                </div>
                <div class="product-slider-active-1 nav-style-2 nav-style-2-modify-3">
                <div class="row">
                    <?php
                    foreach($similer_products as $result):
                    $flag = 0;
                    $input = '';
                    $discount_price = $result['mrp'] - $result['selling_rate'];
                    $discount_percentage = ($discount_price == 0) ? 0 : (($discount_price/$result['mrp'])*100);

                    //calculate selling rate

                    if($result['discount_type']=='0') //0->rupee
                    {
                        $selling_rate = $result['selling_rate'] - $result['offer_upto'];
                    }
                    else if($result['discount_type']=='1') //1->%
                    {
                        $selling_per = ($result['selling_rate'] * $result['offer_upto'])/100;
                        $selling_rate = $result['selling_rate'] - $selling_per;
                    }
                    else
                    {
                        $selling_rate = $result['selling_rate'];
                    }

                    $offer_type = ($result['discount_type'] =='1') ? $result['offer_upto'].'%' : '₹'.$result['offer_upto'];

                    $flag = in_array($result['product_id'], $cart_items) ? 1 : 0;
                    $cart_style = 'btn-secondary';
                    $cart_onclick = 'add_to_cart('.$result['inventory_id'].',this,2)';
                    $cart_title = 'Add to cart';
                    if( $flag == 1 ):
                        $cart_qty = $cart_id = 0;
                        foreach( $cart_data as $cd ):
                            if( $cd->product_id==$result['inventory_id'] ):
                                $cart_qty = $cd->qty;
                                $cart_id = @$cd->id;
                                break;
                            endif;
                        endforeach;
                    if( is_logged_in() ):
                        $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="decrease_quantity('.$cart_id.','.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                        $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="text" value="'.$cart_qty.'" readonly />';
                        $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="increase_quantity('.$cart_id.','.$inventory_id.', this)"><i style="font-size:8px" class="fi-rs-plus">';
                    else:
                        $input = '<a aria-label="-" class="action-btn hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_decrease_quantity('.$inventory_id.',this,2)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
                        $input .= '<input class="count-number-input qty-val'.$inventory_id.'" type="text" value="'.$cart_qty.'" readonly />';
                        $input .= '<a aria-label="+" class="action-btn hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$inventory_id.'" onclick="cookie_increase_quantity('.$inventory_id.',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
                    endif;
                    endif;
                    ?>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6 mt-3 mb-3">
                    <div class="product-plr-1">
                      <div class="product-box product_<?= $result['inventory_id']?>">
                        <div class="single-product-wrap">
                            <div class="product-img-action-wrap mb-20">
                                <div class="product-img product-img-zoom">
                                <?php $url = $result['url'] ? $result['url'] : 'null'; ;?>
                                    <a  href="<?= base_url('product/'.$url) ?>">
                                        <img class="default-img" src="<?php echo displayPhoto($result['thumbnail']); ?>" alt="">
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <button id="cart_btn<?=$inventory_id?>" onclick="add_to_cart_by_btn(<?=$inventory_id?>,this)" href="javascript:void(0)" aria-label="Add To Cart"><i class="far fa-shopping-bag"></i></button>
                                    <!-- <button href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('<?=$result['product_id'];?>" aria-label="Add To Wishlist"><i class="far fa-heart"></i></button> -->
                                    <?php
                                    $wishlist_btn = '<button href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('.$product->id.')" aria-label="Add To Wishlist"><i class="far fa-heart" aria-label="Add To Wishlist"  aria-hidden="true"></i></button>';
                                     $wishlist_data = wishlist_data();
                                     foreach ($wishlist_data as $row) {
                                     $product_id = $row->product_id;            
                                     if ($product_id == $product->id) {
                                     $wishlist_btn = '<button href="javascript:void(0)" title="Already added" class="wishlist text-danger" aria-label="Add To Wishlist"><i class="far fa-heart"  aria-hidden="true"></i></button>';
                                        }
                                     }
                                   echo $wishlist_btn;
                                                ?>
                                </div>
                                <div class="lable-wrapper">
                                 <!-- offer conditions -->
                                 <?php
                                    $offers = $this->product_model->get_data('shops_coupons_offers','product_id',$result['product_id']);
                                    foreach($offers as $offer)
                                    {
                                        if($offer->discount_type==1)
                                        {
                                            $offervalue=   $offer->offer_associated.' % OFF';
                                            $offertype=$offer->discount_type;
                                             $finalperlist = $result['selling_rate']*$offer->offer_associated/100;
                                             $finalamountlist = $result['selling_rate']-$finalperlist;
                                          
                                        }else
                                        {
                                            $offervalue ='Only '.$shop_detail->currency.'  '.$result['selling_rate']-$offer->offer_associated;
                                            $offertype=$offer->discount_type;
                                            $finalamountlist = ($result['selling_rate']-$offer->offer_associated);
                                            //$finalamountlist = $result['selling_rate']-$finalperlist;
                                        }     
                                    
                                    }?>
                               
                              </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                               <?php if(!empty($offers))
                                    {?>
                                    <span class="red"><?=$offervalue;?></span>
                                    <?php   }?>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                            <div class="row">
                                            <div class="col-6">
                                            <h2><?php if($result['ProductFlag']=='bundle'){echo "Bundle";}else{ echo "Product";}?></h2>
                                            </div>
                                            <div class="col-6">
                                            <h2><?php if($result['ProductFlag']=='bundle'){?><a class="text-danger" data-bs-toggle="modal" data-bs-target="#bundleModal<?=$result['product_id'];?>">View Details</a><?php }?></h2>
                                            </div>
                                        </div>
                                <h2><a  href="<?= base_url('product/'.$url) ?>"><?=$result['name_portal']?></a></h2>
                                <div class="product-price">
                                       <!-- offer related conditions are applied -->
                                       <?php if(!empty($offers))
                                       { ?>
                                     <span>
                                        <del class="old-price"> 
                                            <?= $shop_detail->currency; ?><?php echo number_format((float)($result['selling_rate']), 2, '.', ''); ?>
                                        </del>
                                        <h4 class="new-price">
                                            <?= $shop_detail->currency; ?><?php echo number_format((float)($finalamountlist), 2, '.', ''); ?>
                                        </h4>
                                    </span>
                                    <?php  }else{?>
                                        <span>
                                            <h4 class="new-price "><?= $shop_detail->currency; ?><?php echo number_format((float)($selling_rate), 2, '.', '') ;?></h4>
                                        </span>
                                    <?php }?>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                       <!-- Bundle Details MOdel -->
                        <!-- Modal -->
                        <div class="modal fade" id="bundleModal<?=$result['product_id'];?>" tabindex="-1" aria-labelledby="bundleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bundleModalLabel"><?=$result['name_portal'] ?></h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                                <div id="load-details-<?=$result['product_id'];?>"></div>
                            </div>
                            <script>
                                  $(document).ready(function(){
                                setTimeout(()=> {
                                    $("#load-details-<?=$result['product_id']?>").load("<?=base_url()?>home/load_bundle_details/<?=$result['product_id'];?>");
                                }, 100);                                           
                            });
                             </script>   
                            </div>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?> 
                </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--End Related Product Dynamic by AJAY KUMAR -->