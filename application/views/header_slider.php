<div class="slider-<?=$header_id?>">
<hr>
<div class="row">
                    <div class="col-lg-12">
                        <div class="row">
    <?php
		$cart_data = cart_data();
		$cart_items = $cart_data ? array_column($cart_data, 'product_id') : array();

		foreach($header_slider as $result):
			$flag = 0;
			$input = '';
            
	        //calculate selling rate
	        if($result['discount_type']=='0') //0->rupee
	        {
	            $selling_rate = $result['selling_rate'] - $result['offer_upto'];
	        }
	        else if($result['discount_type']=='1') //1->%
	        {
	            $selling_per = ($result['selling_rate'] * $result['offer_upto'])/100;
	            $selling_rate = $result['selling_rate'] - $selling_per;
	        }else{
	            $selling_rate = $result['selling_rate'];
	        }
	        $discount_price = $result['mrp'] - $selling_rate;
	        $discount_percentage = ($discount_price == 0) ? 0 : (($discount_price/$result['mrp'])*100);

	        $offer_type = ($result['discount_type'] =='1') ? $result['offer_upto'].'%' : '₹'.$result['offer_upto'];

	        $flag = in_array($result['inventory_id'], $cart_items) ? 1 : 0;
	        $cart_style = 'btn-secondary';
            $cart_onclick = 'add_to_cart('.$result['inventory_id'].',this)';
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
            		$input = '<a aria-label="-" class="action-btn-qty hover-up me-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="decrease_quantity('.$cart_id.','.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart"  href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="increase_quantity('.$cart_id.','.$result["inventory_id"].', this)"><i style="font-size:8px" class="fi-rs-plus"></i></a>';
            	else:
            		$input = '<a aria-label="-" class="action-btn-qty hover-up me-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_decrease_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-minus" ></i></a> ';
		            $input .= '<input class="count-number-input qty-val'.$result["inventory_id"].'" type="text" value="'.$cart_qty.'" readonly />';
		            $input .= '<a aria-label="+" class="action-btn-qty hover-up ms-1 add-cart" href="javascript:void(0)" data-target=".qty-val'.$result["inventory_id"].'" onclick="cookie_increase_quantity('.$result["inventory_id"].',this)"><i style="font-size:8px" class="fi-rs-plus" ></i></a> ';
            	endif;
                 endif;
	            ?>
              
                            <div class="col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
                                <div class="single-product-wrap mb-50 wow tmFadeInUp">
                                    <div class="product-img-action-wrap mb-10">
                                        <div class="product-img product-img-zoom">
                                            <a href="<?=base_url('product/')?><?php if($result['url'] !=''){echo $result['url'];}else{echo 'null';} ;?>">
                                                <img class="default-img" src="<?php echo displayPhoto($result['thumbnail']); ?>" alt="">
                                            </a>
                                        </div>
                                        <?php
                                        $offerss = $this->product_model->get_data('shops_coupons_offers','product_id',$result['product_id']);
                                        foreach($offerss as $offer)
                                        {
                                        if($offer->discount_type==1)
                                        {
                                            $deatailoffervalue=   $offer->offer_associated.' % OFF';
                                            $deatailoffertype=$offer->discount_type;
                                            $deatailfinalper = $result['selling_rate']*$offer->offer_associated/100;
                                            $deatailfinalamount = $result['selling_rate']-$deatailfinalper;
                                        }else
                                        {
                                            $deatailoffervalue ='Only '.$shop_detail->currency.'  '.$result['selling_rate']-$offer->offer_associated;
                                            $deatailoffertype=$offer->discount_type;
                                            $deatailfinalamount = ($result['selling_rate']-$offer->offer_associated);
                                            //$deatailfinalamount = $result['selling_rate']-$deatailfinalper;
                                        }    
                                        
                                        }  
                                           ?>
                                  
                                        <div class="product-action-1">
                                            <button id="cart_btn<?=$result["inventory_id"]?>" onclick="add_to_cart_by_btn(<?=$result['inventory_id']?>,this)" href="javascript:void(0)" aria-label="Add To Cart"><i class="far fa-shopping-bag"></i></button>
                                            <?php
                                            $wishlist_btn = '<button href="javascript:void(0)" title="Add to Wishlist" class="wishlist" onclick="add_to_wishlist('.$result['product_id'].')" aria-label="Add To Wishlist"><i class="far fa-heart" aria-label="Add To Wishlist"  aria-hidden="true"></i></button>';
                                            $wishlist_data = wishlist_data();
                                            foreach ($wishlist_data as $row) {
                                            $product_id = $row->product_id;            
                                            if ($product_id == $result['product_id']) {
                                            $wishlist_btn = '<button href="javascript:void(0)" title="Already added" class="wishlist text-danger" aria-label="Add To Wishlist"><i class="far fa-heart"  aria-hidden="true"></i></button>';
                                                }
                                            }
                                        echo $wishlist_btn;
                                                        ?>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <!-- <span class="hot yellow">Hot</span> -->
                                        <?php if(!empty($offerss))
                                           {?>
                                            <span class="red"><?=$deatailoffervalue;?></span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="product-content-wrap">
                                        <div class="row">
                                            <div class="col-6">
                                            <h2><?php if($result['ProductFlag']=='bundle'){echo " Bundle";}else{ echo "Product";}?></h2>
                                            </div>
                                            <div class="col-6">
                                            <h2><?php if($result['ProductFlag']=='bundle'){?><a class="text-danger" data-bs-toggle="modal" data-bs-target="#bundleModal<?=$result['product_id'];?>">View Details</a><?php }?></h2>
                                            </div>
                                        </div>
                                        <h2><a href="<?=base_url('product/')?><?php if($result['url'] !=''){echo $result['url'];}else{echo 'null';} ;?>"><?=$result['name_portal'] ?></a></h2>
                                        <div class="product-price">
                                       <?php if(!empty($offerss))
                                       { ?>
                                     <span>
                                        <del class="old-price"> 
                                            <?= $shop_detail->currency; ?><?php echo number_format((float)($result['selling_rate']), 2, '.', ''); ?>
                                        </del>
                                        <h4 class="new-price">
                                            <?= $shop_detail->currency; ?><?php echo number_format((float)($deatailfinalamount), 2, '.', ''); ?>
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
