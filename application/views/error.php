<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="<?=base_url('dashboard');?>">Home</a>
                        </li>
                        <li class="active">Payment Cancelled! </li>
                    </ul>
                </div>
            </div>
        </div>
		<div class="wishlist-area pt-5 pb-75">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <img class="img-fluid img-thumbnail mb-5" style="width:200px" src="<?= base_url('assets/img/paymentfailed.png'); ?>" alt="Failed" id="error-img">
                <h4 class="mt-2 mb-2 text-danger">Payment Cancelled!</h4>
				<p class="mt-2 mb-2">Your Order ID : <?=@$oid;?></p>
				<?php $Orders = $this->model->getRow('orders',['orderid'=>$oid]);?>
			<p class="mt-2 mb-2">Order Amount : Rs.<?= number_format(@$Orders->total_value + $Orders->delivery_charges, 2); ?></p>
                <p class="mb-5">Payment process has been cancelled. Kindly go to cart and initiate payment again.</p>
                <a class="btn btn-primary btn-lg" href="<?= base_url('profile'); ?>">View Order :)</a>
            </div>
        </div>
    </div>
</div>
