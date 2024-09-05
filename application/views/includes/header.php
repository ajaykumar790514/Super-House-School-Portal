<?php 
   if($this->session->userdata('logged_in') || get_cookie("logged_in"))
   {}else{ redirect(base_url()); };
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $shop_detail->shop_name; ?></title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="Add_Description_Text">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="canonical" href="Replace_with_your_PAGE_URL" />

    <!-- Open Graph (OG) meta tags are snippets of code that control how URLs are displayed when shared on social media  -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Add a Title" />
    <meta property="og:url" content="Replace_with_your_PAGE_URL" />
    <meta property="og:site_name" content="SITE_NAME" />
    <!-- For the og:image content, replace the # with a link of an image -->
    <meta property="og:image" content="#" />
    <meta property="og:description" content="Add_Description_Text" />
    <!-- Add site Favicon -->
    <link rel="icon" href="<?=base_url();?>assets/images/favicon/cropped-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?=base_url();?>assets/images/favicon/cropped-favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?=base_url();?>assets/images/favicon/cropped-favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="<?=base_url();?>assets/images/favicon/cropped-favicon-270x270.png" />

    <!-- All CSS is here
	============================================ -->

    <link rel="stylesheet" href="<?=base_url();?>assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/vendor/font-cerebrisans.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/vendor/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/vendor/font-medizin.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins/slick.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins/animate.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins/select2.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Include Toastr CSS and JS files from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="<?= base_url('assets/js/vendor/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugins/toastr.min.js')?>"></script>
    <script>
        // Example initialization
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '5000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
};

    </script>

</head>

<body>
    <div class="main-wrapper">
        <header class="header-area header-height-2">
            <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
                <div class="custom-container">
                    <div class="header-wrap header-space-between">
                        <div class="logo logo-width-1">
                            <a href="<?=base_url();?>dashboard"><img src="<?=IMGS_URL.$shop_detail->logo ?>" alt="logo" height="70px"></a>
                        </div>
                        <div class="search-style-2">
                            <form action="<?=base_url('home/products/search_list');?>" method="get" id="search-form" >
                                <input type="text" class="search__input" id="search-box" name="search" placeholder="Search for items…">
                                <button type="button" id="search_btn" ><div class="search-icon "></div> <i class="far fa-search"></i> </button>
                            </form>
                            <div id="result" class="search-result-box shadow-sm border-0 w-100">
                            <!-- Search Result will be here -->
                        </div>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                
                            <div class="header-action-icon-2 user">
                                    <a class='mini-cart-icon' href='#'>
                                    <img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/user.svg">
                                    </a>
                                    <div class="cart-dropdown-wrap-login cart-dropdown-hm2">
                                        <ul>
                                            <li><h4 class="text-primary"><a class="text-primary" href="<?=base_url();?>profile">Profile</a></h4></li>
                                            <li><h4 class="text-primary"><a class="text-primary" href="<?=base_url();?>logout">Logout</a></h4></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="header-action-icon-2 wishlist">
                                    <a href="<?= base_url('wishlist'); ?>"><img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/heart.svg">
                                    <span class="pro-count blue" id="wishlish_count"><?php $wishlist_data = count(wishlist_data()); ?><?= $wishlist_data ? $wishlist_data.' ' : '0 ' ?></span></a>
                                </div>
                                <div class="header-action-icon-2 cart">
                                    <a class='mini-cart-icon' href='#'>
                                        <img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/cart-2.svg">
                                        <span class="pro-count blue" id="cart_count"><?php $total_count = 0; foreach(cart_data() as $row){ $total_count += $row->qty; } ?><?= cart_data() ? $total_count.' ' : '0 ' ?></span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <div class="cart-div">
                
                                        </div>  
                                         <script>
                                            $(document).ready(function(){
                                                setTimeout(()=> {
                                                    $(".cart-div").load("<?=base_url()?>home/cart_view");
                                                }, 100);                                           
                                            });                       
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom header-bottom-bg-color sticky-bar gray-bg sticky-blue-bg">
                <div class="custom-container">
                    <div class="header-wrap header-space-between position-relative">
                        <div class="logo logo-width-1 d-block d-lg-none">
                            <a href="<?=base_url();?>dashboard"><img src="<?=IMGS_URL.$shop_detail->logo ?>" alt="logo" height="70px"></a>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block main-menu-light-white hover-boder hover-boder-white">
                            <nav>
                                <ul>
                                    <li><a class='active' href='<?=base_url('dashboard')?>'>HOME</a></li>
                                    <?php
                                     if($this->session->userdata('logged_in'))
                                     {
                                         $user_group = $this->session->userdata('group_id');
                                     }
                                     else
                                     {
                                         $user_group =get_cookie("group_id");
                                     }
                                $category = $this->category_model->get_user_category($user_group);
                                $sub_category = $this->category_model->get_user_subcategory($user_group);                     
                                       
                                foreach($category as $row): 
                            ?>
                             <?php $url1 = $row->url ? $row->url : 'null'; ?>
                                    <li class="position-static"><a href="<?= base_url('category/'.$url1) ?>"><?=ucfirst($row->name)?> 
                                    <!-- <i class="fa fa-chevron-down"></i> -->
                                </a>
                                    <ul class="mega-menu">
                                        <?php
                                     foreach($sub_category as $rowsub):
                                      if($rowsub->is_parent==$row->id):
                                    ?> 
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                            <?php $url1 = $rowsub->url ? $rowsub->url : 'null'; ?>
                                                <a class="menu-title" href="<?= base_url('category/'.$url1) ?>"><?=ucfirst($rowsub->name)?></a>
                                                <hr>
                                                <ul>
                                                <?php foreach($sub_category as $rowsub2):
                                                       if($rowsub2->is_parent==$rowsub->id):
                                                         if(@$rowsub2->pro_url !='')
                                                           {?>
                                                               <li><a href="<?=$rowsub2->pro_url ;?>"><?=ucfirst($rowsub2->name)?></a></li>
                                                                <?php  }else{;
                                                            ?>
                                                              <li>
                                                              <?php $url2 = $rowsub2->url ? $rowsub2->url : 'null'; ?>
                                                                <a href="<?= base_url('category/'.$url2) ?>"><?=ucfirst($rowsub2->name)?></a></li>   <br>  <br>
                                                                 <?php }?>
                                                  <?php 
                                                   endif;
                                                   endforeach; 
                                                   ?> 
                                                   
                                                </ul>
                                            </li>
                                         
                                            <?php
                                            endif;
                                            endforeach;
                                            ?> 
                                        </ul>
                                       </li>
                                    <?php endforeach; ?>   

                                </ul>
                            </nav>
                        </div>
                        <div class="header-action-right d-block d-lg-none">
                            <div class="header-action-2">
                                <div class="header-action-icon-2 wishlist">
                                    <a href='<?=base_url();?>wishlist'><img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/heart.svg"></a>
									<span class="pro-count blue" id="wishlish_count"><?php $wishlist_data = count(wishlist_data()); ?><?= $wishlist_data ? $wishlist_data.' ' : '0 ' ?></span></a>
                                </div>
                                <div class="header-action-icon-2 cart">
                                    <a class='mini-cart-icon' href='#'>
                                        <img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/cart-2.svg">
                                        <span  id="cart_countmobile"><?php $total_count = 0; foreach(cart_data() as $row){ $total_count += $row->qty; } ?><?= cart_data() ? $total_count.' ' : '0 ' ?></span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <div class="cart-div">
                
                                        </div>  
                                        <script>
                                            $(document).ready(function(){
                                                setTimeout(()=> {
                                                    $(".cart-div").load("<?=base_url()?>home/cart_view");
                                                }, 100);                                           
                                            });                       
                                        </script>
                                    </div>
                                </div>
                                <div class="header-action-icon-2 user">
                                    <a class='mini-cart-icon' href='#'>
                                    <img class="injectable" alt="" src="<?=base_url();?>assets/images/icon-img/user.svg">
                                    </a>
                                    <div class="cart-dropdown-wrap-login cart-dropdown-hm2">
                                        <ul>
                                            <li><h4><a class="text-primary" href="<?=base_url();?>profile">Profile</a></h4></li>
                                            <li><h4><a class="text-primary" href="<?=base_url();?>logout">Logout</a></h4></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="header-action-icon-2 d-block d-lg-none">
                                    <div class="burger-icon burger-icon-white">
                                        <span class="burger-icon-top"></span>
                                        <span class="burger-icon-bottom"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
