<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="<?=base_url('dashboard');?>">Home</a>
                        </li>
                        <li class="active">Order Details </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wishlist-area pt-5 pb-75">
        <main class="main">
     <section class="mt-50 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div>
                <div class="row order-items no-gutters">
                    <?php $total_qty = 0; foreach( $order_items as $items  ): $total_qty += $items->item_qty;
                    $url =  $items->pro_url ?>
                     <?php $pro_url = $url ? $url : 'null'; ;?>
                    <div class="col-md-4 ml-3 border align-items-center">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-4 justify-content-center bg-light text-center">
                                <a href="<?= base_url('product/'.$pro_url) ?>">
                                <img class="img-fluid" src="<?= displayPhoto($items->img); ?>">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="<?= base_url('product/'.$pro_url) ?>">
                                    <h6 class="text-dark pt-4" style="  word-wrap: break-word;max-width:180px;"><?= $items->product_name ?></h6>
                                    <span class="text-dark"><?php if($items->price_per_unit > $items->total_price/$items->item_qty){?><del class="text-primary"><?=$shop_detail->currency.' '.$items->price_per_unit ?></del><?php }?> <h4 class="text-danger"><?=$shop_detail->currency.' '.bcdiv($items->total_price/$items->item_qty, 1, 2);?></h4></span>
                                </a>
                                <span class="order-title">Qty : <?= $items->item_qty; ?> items</span>
                                <?php if($items->flag=='bundle'){?>
                                <a data-bs-toggle="modal" data-bs-target="#bundleModal<?=$items->product_id;?>" class="order-title text-danger ml-3">View Bundle</a>
                                <?php }?>
                       <!--     <?php // $rs = $this->product_model->product_props_flavour($items->product_id);?>-->
                       <!--<?php // if(!empty($rs->flavour)){?> <h6><span class='text-danger'><? // =@$rs->flavour;?></span></h6> <?php // }?>-->
                                <div id="props<?=$items->product_id?>">
                         
                        </div>
                       
                            </div>
                        </div>
                    </div>
                     <!-- Modal -->
                     <div class="modal fade" id="bundleModal<?=$items->product_id;?>" tabindex="-1" aria-labelledby="bundleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bundleModalLabel"><?=$items->product_name ?></h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                                <div id="load-details-<?=$items->product_id;?>"></div>
                            </div>
                            <script>
                                  $(document).ready(function(){
                                setTimeout(()=> {
                                    $("#load-details-<?=$items->product_id?>").load("<?=base_url()?>home/load_bundle_details_new/<?=$items->product_id;?>/<?=$items->item_id;?>");
                                }, 100);                                           
                            });
                             </script>   
                            </div>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <div class="status-main card p-3 mt-5">
                <div class="row mb-4 m-2">
                    <div class="col-lg-6">
                        <div class="statustop">
                            <p class="mb-2 text-dark"><strong>Order Status:</strong> <?= $order_details->status_name; ?></p>
                            <p class="mb-2 text-dark"><strong>Order Date:</strong> <?= uk_date($order_details->order_date); ?>
                            <?= uk_time($order_details->order_date); ?></p>
                            <p class="mb-2 text-dark"><strong>Order Id:</strong> <?= $order_details->orderid; ?> </p>
                        </div>
                    </div>
                    <div class="col-lg-2 d-flex justify-content-center align-items-center">
                        <?php  if( $order_details->status == 4 && !empty($order_details->invoice_file)): ?>
                        <a href="<?=IMGS_URL.$order_details->invoice_file ?>" target="_blank"><button class="btn btn-solid"><i class="fa fa-download"></i> Invoice</button></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-2 d-flex justify-content-center align-items-center">
                         <?php  if( $order_details->status == 1 || $order_details->status == 17 || $order_details->status == 3 || $order_details->status == 21 ): ?>
                            <?php
                        $orderDate = new DateTime($order_details->added);
                        $today = new DateTime();
                        $returndays = $days;
                         $daysDifference = $today->diff($orderDate)->days;
                        if ($daysDifference < $returndays): ?>
                        <a data-bs-toggle="modal" id="cancelbtn" data-bs-target="#myModal"><button class="btn btn-solid"> Cancel Order</button></a>
                        <?php endif; ?>
                        <?php endif; ?>
                        
                        <input type="hidden" value="<?=$productID;?>" id="productID">
                            <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <form id="cancelForm">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-danger">Cancel Order </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <input type="hidden" name="id" value="<?=$order_details->oid;?>">
                                <input type="hidden" value="<?=$productID;?>" name="productid" id="productID">
                                <div class="modal-body">
                                   <div class="row">
                                    <div class="col-12">
                                        <label for="">Select Reason</label>
                                        <select name="reason" id="reason" class="form-control reason">
                                            <option value="">--Select Reason--</option>
                                            <?php foreach($reason as $re):?>
                                             <option value="<?=$re->content;?>"><?=$re->content;?></option>
                                             <?php endforeach;?>   
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Remark / Comment</label>
                                        <textarea name="remark" id="remark" class="form-control"></textarea>
                                    </div>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="confirmChangeStatus()">Change Status</button>
                                </div>
                                </div>
                                </form>
                            </div>
                            </div>
                           
                    </div>
                   
                    <?php if( $order_details->status == 1 || $order_details->status == 17 || $order_details->status == 3 || $order_details->status == 21 ){}elseif($order_details->status == 4){ ?>
                    <div class="col-lg-2 d-flex justify-content-center align-items-center">
                        <?php
                        $orderDate = new DateTime($order_details->added);
                        $today = new DateTime();
                         $returndays = $days;
                        $daysDifference = $today->diff($orderDate)->days;
                        if ($daysDifference <= $returndays): ?>
                            <a data-bs-toggle="modal" id="returnbtn" data-bs-target="#myModal2">
                                <button class="btn btn-solid">Return Order</button>
                            </a>
                        <?php endif; ?>
                        <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="returnForm">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-danger">Return Order </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <input type="hidden" name="id" value="<?=$order_details->oid;?>">
                                <input type="hidden" value="<?=$productID;?>" name="productid" id="productID">
                                <div class="modal-body">
                                   <div class="row">
                                    <div class="col-12">
                                        <label for="">Select Reason</label>
                                        <select name="reason" id="reason" class="form-control reason">
                                            <option value="">--Select Reason--</option>
                                            <?php foreach($reason as $re):?>
                                             <option value="<?=$re->content;?>"><?=$re->content;?></option>
                                             <?php endforeach;?>   
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="">Remark / Comment</label>
                                        <textarea name="remark" id="remark" class="form-control"></textarea>
                                    </div>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#9999;">Close</button>
                                    <button type="button" class="btn btn-danger"  style="background-color: red;color:white"  onclick="confirmreturn()">Confirm</button>
                                </div>
                                </div>
                                </form>
                            </div>
                            </div>
                    </div>
                    <?php }?>


                </div>
                <div class="row mb-3">
                    <!-- <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Delivery Slot</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-2"><?= date_format_func($order_details->datetime); ?></p>
                                <?php if($order_details->timeslot_starttime!= NULL){ ?>
                                <p class="card-text mb-2"><?= date('h:i A',strtotime($order_details->timeslot_starttime)).'-'.date('h:i A',strtotime($order_details->timeslot_endtime)); ?></p>
                                <?php } ?>
                                <p class="card-text mb-2"><?= $order_details->status_name; ?></p>

                                <?php if( $order_details->status == 3 ): ?>
                                <p>Delievery Boy : <?= $order_details->delivery_boy_name ?></p>
                                <p>Contact : <?= $order_details->delivery_boy_contact ?></p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Delivery Address</h5>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-text mb-2"><?= $order_details->house_no.' '.$order_details->address_line_2.' '.$order_details->address_line_3.' , '.@$order_details->landmark.' , '.$order_details->city.' '.$order_details->state.' '.$order_details->country.' , '.$order_details->pincode ; ?> </h5>
                                <h5 class="card-text mb-2"><?= $order_details->booking_name; ?></h5>
                                <h5 class="card-text mb-0"><?= $order_details->booking_contact.' ('.$order_details->email.' )'; ?></h5>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                           
                            <h5 class="mb-0">Payment Details</h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-text text-dark mb-2">
                                    <?php if($order_details->payment_method == 'cod')
                                    {
                                        echo 'COD';
                                    }
                                    else
                                    {
                                        echo $order_details->payment_method.'<br>'.$order_details->bank_name;
                                    } ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Order Summary  ( <?= $total_qty ?> Items )</h5>
                             
                            </div>
                           
                            <div class="card-body">
                                <!-- <h5 class="card-text mb-2"> <strong>Total Items : </strong><span class="float-right"> <?= $total_qty ?> </span> </h5> -->

                                <h5 class="card-text mb-2">Sub Total: <strong class="float-right"><?= $shop_detail->currency; ?> <?= $order_details->total_value-$order_details->tax ?></strong> </h5>
                                <h5 class="card-text mb-2">Delivery Charges  : <strong class="float-right"><?= $shop_detail->currency; ?> <?= $order_details->delivery_charges; ?></strong> </h5>
                                  
                                <h5 class="mb-2">Your total savings : <span class="float-right "><strong><?= $shop_detail->currency; ?> <?= $order_details->total_savings; ?></strong></span> </h5>
                                 
                                <!-- <h5 class="card-text mb-2">Approx GST ( + ) : <strong class="float-right"><?= $shop_detail->currency; ?> <?= $order_details->tax ?></strong> </h5> -->

                               
                                <h5 class="card-text mb-2">Total:<span class="float-right"><strong><?= $shop_detail->currency; ?> <?= $order_details->total_value + $order_details->delivery_charges?> </strong></span></h5>

                                <h5 class="card-text mb-2">To Pay :<span class="float-right text-danger" style="font-size: 1.2rem;"><strong><?= $shop_detail->currency; ?> <?= ($order_details->total_value + $order_details->delivery_charges) ?> </strong></span></h5>

                                <?php
                                    $offer_discount = 0;
                                    foreach( $offers as $offer ):
                                        $offer_discount += $offer->coupon_value;
                                        if( $offer->coupon_type == 1 ):
                                ?>
                                <h5 class="card-text mb-2 text-danger"> <strong>Coin Discount :</strong> <span class="float-right"><?= $shop_detail->currency; ?> <?= $offer->coupon_value ?></span></h5>
                                <?php 
                                        endif;
                                        if( $offer->coupon_type == 2 ):
                                ?>
                                <h5 class="card-text mb-2 text-danger"> </strong>Coupon Discount (<?= $offer->coupon_reference ?>) :</strong> <span class="float-right">$ <?= $offer->coupon_value ?> </span></h5>
                                <?php 
                                        endif;
                                    endforeach;
                                ?>
                                <!-- <h5 class="text-danger"> Total Payable : <strong class="float-right"><?= $shop_detail->currency; ?> <?= $order_details->total_value - $offer_discount ?></strong> </h5> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
      $(document).ready(function () {
        $('#cancelbtn').on('click', function() {
            $('#myModal').appendTo("body").modal('show');
        });
        $('#returnbtn').on('click', function() {
            $('#myModal2').appendTo("body").modal('show');
        });
       
    });
</script>
<script>
    function confirmChangeStatus() {
         $('#myModal').modal('hide'); // If you don't have a modal with id 'myModal', you can comment this line
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are canceling this order!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                changeStatus();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'The order remains cancelled.', 'info');
            }
        });
    }

    function changeStatus() {
        var formData = new FormData($('#cancelForm')[0]);
        var reason = formData.get('reason');
        var remark = formData.get('remark');
        if (!reason.trim() && !remark.trim()) {
            Swal.fire('Error', 'Please select reason and enter remark.', 'error');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '<?=base_url();?>home/changeStatusCancel',
            data: formData,
            dataType: 'json',
            contentType: false, // Required for FormData
            processData: false, // Required for FormData
            success: function (response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    setTimeout(function () {
                location.reload();
            }, 2000);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    function confirmreturn() {
         $('#myModal').modal('hide'); // If you don't have a modal with id 'myModal', you can comment this line
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are return this order!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, return it!',
            cancelButtonText: 'No, return!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                changeStatusreturn();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelled', 'The order remains return.', 'info');
            }
        });
    }

    function changeStatusreturn() {
        var formData = new FormData($('#returnForm')[0]);
        var reason = formData.get('reason');
        var remark = formData.get('remark');
        if (!reason.trim() && !remark.trim()) {
            Swal.fire('Error', 'Please select reason and enter remark.', 'error');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '<?=base_url();?>home/changeStatusReturn',
            data: formData,
            dataType: 'json',
            contentType: false, // Required for FormData
            processData: false, // Required for FormData
            success: function (response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    setTimeout(function () {
                location.reload();
            }, 2000);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    
</script>