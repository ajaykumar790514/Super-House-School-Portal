<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php foreach($banners_top as $k => $top):?>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?= $k; ?>" class="<?= ($k == 0) ? 'active' : ''; ?>" aria-current="true" aria-label="Slide <?= $k + 1; ?>"></button>
    <?php endforeach; ?>
  </div>
  <div class="carousel-inner">
    <?php foreach($banners_top as $i => $top):?>
      <div class="carousel-item <?= ($i == 0) ? 'active' : ''; ?>" data-bs-interval="10000">
        <img src="<?= IMGS_URL . $top->img; ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="text-white"><?=$top->text_line1;?></h5>
          <h5 class="text-white"><?=$top->banner_title;?></h5>
          <h5 class="text-white"><?=$top->text_line2;?></h5> 
          <h3> <?=$top->text_line3;?></h3>
          <p> <?=$top->text_line4;?></p>
          <div class="btn-style-1">
          <a class='animated btn-1-padding-3' href="<?=base_url();?><?php if($top->link_type==1){echo 'products';} ;?>/<?=$top->link_id;?>" > <?=$top->banner_offer;?> - Buy now </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

      <!-- Header Slider Dynamic by AJAY KUMAR -->
        <!-- <div class="slider-area">
            <div class="hero-slider-active-2 dot-style-1 dot-style-1-position-1">
            <?php foreach($banners_top as $top):?>
                <div class="single-hero-slider single-animation-wrap slider-height-2 custom-d-flex custom-align-item-center bg-img" style="background-color:<?=$top->banner_color;?>">
                    <div class="custom-container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-6 col-md-6 col-12 col-sm-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated"><?=$top->text_line1;?></h4>
                                    <h1 class="animated"><?=$top->banner_title;?> </h1>
                                    <p class="animated"><?=$top->text_line2;?></p>
                                    <div class="btn-style-1">
                                        <a class='animated btn-1-padding-3' href="<?=base_url();?><?php if($top->link_type==1){echo 'products';} ;?>/<?=$top->link_id;?>" > <?=$top->banner_offer;?> - Buy now </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 col-sm-6 setbanner">
                                <div class="single-slider-img single-slider-img-1">
                                    <img class="animated" src="<?=IMGS_URL.$top->img?>" height="100%" width="100%" alt="">
                                    <div class="slider-product-price slider-product-position3 slider-animated-1 animated">
                                        <h3>
                                            <?=$top->text_line3;?>
                                            <span class="mrg-top">  <?=$top->text_line4;?> </span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div> -->

         <!--End Header Slider Dynamic by AJAY KUMAR -->


         <!-- End Category Header Dynamic By AJAY KUMAR -->
      <?php /* 
    $i=0;
    $seq = 6;
    foreach($category_header_title as $row): 
     if($i==0):     
     $rs1 = $this->home_model->getHeaderCatMap($row->id);  
    ?>
        <div class="product-area pt-80 pb-75">
            <div class="custom-container">
                <div class="product-area-border">
                    <div class="section-title-timer-wrap">
                        <div class="section-title-1 section-title-hm2">
                            <h2><?=$row->title?></h2>
                        </div>
                    </div>
                    <div class="product-slider-active-1 nav-style-2 product-hm1-mrg">
                    <?php foreach($rs1  as $r1): ?>
                        <div class="product-plr-1">
                            <div class="single-product-wrap">
                                <div class="product-content-wrap">
                                    <h2><a  href="<?php if($r1->level==2){ if($r1->url !=''){ echo "category/".$r1->url;}else {   echo "category/null"; }}elseif($r1->level==3){if($r1->url !=''){ echo "category/".$r1->url;}else {   echo "category/null"; }} ;?>"><?=$r1->name;?></a></h2>
                                </div>
                                <div class="product-img-action-wrap mb-20 mt-25">
                                    <div class="product-img product-img-zoom" >
                                        <a href="<?php if($r1->level==2){ if($r1->url !=''){ echo "category/".$r1->url;}else {   echo "category/null"; }}elseif($r1->level==3){if($r1->url !=''){ echo "category/".$r1->url;}else {   echo "category/null"; }} ;?>">
                                            <img class="default-img" src="<?=IMGS_URL.$r1->icon;?>" alt="">
                                            <img class="hover-img" src="<?=IMGS_URL.$r1->icon;?>" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; if($i==1):
       $rs2 = $this->home_model->getHeaderCatMap($row->id);  ?>
        <div class="product-area pt-5 pb-75">
            <div class="custom-container">
                <div class="product-area-border">
                    <div class="section-title-timer-wrap">
                        <div class="section-title-1 section-title-hm2">
                            <h2><?=$row->title?></h2>
                        </div>
                    </div>
                    <div class="product-slider-active-1 nav-style-2 product-hm1-mrg">
                    <?php foreach($rs2 as $r2):?>
                        <div class="product-plr-1">
                            <div class="single-product-wrap">
                                <div class="product-content-wrap">
                                    <h2><a  href="<?php if($r2->level==2){ if($r2->url !=''){ echo "category/".$r2->url;}else {   echo "category/null"; }}elseif($r2->level==3){if($r2->url !=''){ echo "category/".$r2->url;}else {   echo "category/null"; }} ;?>"><?=$r2->name;?></a></h2>
                                </div>
                                <div class="product-img-action-wrap mb-20 mt-25">
                                    <div class="product-img product-img-zoom" >
                                        <a href="<?php if($r2->level==2){ if($r2->url !=''){ echo "category/".$r2->url;}else {   echo "category/null"; }}elseif($r2->level==3){if($r2->url !=''){ echo "category/".$r2->url;}else {   echo "category/null"; }} ;?>">
                                            <img class="default-img" src="<?=IMGS_URL.$r2->icon;?>" alt="">
                                            <img class="hover-img" src="<?=IMGS_URL.$r2->icon;?>" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;   $i++; $seq++;  endforeach; */?> 
        <!-- End Category Header Dynamic By AJAY KUMAR -->


         <!-- Product Header Slider Dynamic Class Wise By AJAY KUMAR -->
        
        <div class="product-area pt-75 pb-30">
            <div class="custom-container">
                <div class="section-title-btn-wrap st-btn-wrap-xs-center wow tmFadeInUp mb-35">
                    <div class="section-title-1 section-title-hm2">
                        <?php $class_id = $this->session->class_id ? $this->session->class_id : get_cookie("class_id");
                         $group_id = $this->session->group_id ? $this->session->group_id : get_cookie("group_id");?>
                        <h2>Specially For <?=getClass($class_id,$group_id);?> class</h2>
                    </div>
                    <!-- <div class="btn-style-2 mrg-top-xs">
                        <a href='#'>View all products <i class="far fa-long-arrow-right"></i></a>
                    </div> -->
                </div>
                <div id="header-home-class-<?=$class_id;?>">
                
                </div>  
                <script>
                $(document).ready(function(){
                    setTimeout(()=> {
                        $("#header-home-class-<?=$class_id?>").load("<?=base_url()?>home/header_slider_class/<?=$group_id?>/<?=$class_id;?>");
                    }, 100);                                           
                });                       
            </script>
            </div>
        </div>
       <!--End Product Header Slider Dynamic Class Wise By AJAY KUMAR -->


         <!-- Product Header Slider Dynamic By AJAY KUMAR -->
         <?php 
        $i=1;
        $seq = 5;
        foreach($header_title as $row):   
        ?>
        <div class="product-area pb-30">
            <div class="custom-container">
                <div class="section-title-btn-wrap st-btn-wrap-xs-center wow tmFadeInUp mb-35">
                    <div class="section-title-1 section-title-hm2">
                        <h2><?=$row->title?></h2>
                    </div>
                    <div class="btn-style-2 mrg-top-xs">
                        <?php if($group_id==1){?> 
                         <a href='<?php if($i=='1'){echo base_url('category/dps-stationery');} ;if($i=='2'){echo base_url('category/dps-notebooks');} ; if($i=='3'){echo base_url('category/dps-books');} ;?>'>View all products <i class="far fa-long-arrow-right"></i></a>
                        <?php }else if($group_id==2){?>
                        <a href='<?php if($i=='1'){echo base_url('category/aps-stationery');} ;if($i=='2'){echo base_url('category/aps-notebooks');} ; if($i=='3'){echo base_url('category/aps-books');} ;?>'>View all products <i class="far fa-long-arrow-right"></i></a>
                         <?php }else if($group_id==3){?>
                         <a href='<?php if($i=='1'){echo base_url('category/stationery');} ;if($i=='2'){echo base_url('category/notebooks');} ; if($i=='3'){echo base_url('category/books');} ;?>'>View all products <i class="far fa-long-arrow-right"></i></a>
                         <?php }?>
                       
                    </div>
                </div>
                <div id="header-home-<?=$row->id?>">
                
                </div>  
                <script>
                $(document).ready(function(){
                    setTimeout(()=> {
                        $("#header-home-<?=$row->id?>").load("<?=base_url()?>home/header_slider/<?=$row->id?>/<?=$class_id;?>/<?=$group_id;?>");
                    }, 100);                                           
                });                       
            </script>
            </div>
        </div>
        <?php $i++; $seq++;   endforeach; ?> 
       <!--End Product Header Slider Dynamic By AJAY KUMAR -->
  


    
       <div class="banner-area pt-50 pb-45">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-8">
                    <?php foreach($banners_other as $row) :
                    if($row->seq==1):
                    ?>
                        <div class="banner-wrap wow tmFadeInUp mb-30">
                            <div class="banner-img banner-img-zoom">
                                <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" ><img src="<?= IMGS_URL.$row->img; ?>"  height="335px"  alt=""></a>
                            </div>
                            <div class="banner-content-2 pt-100">
                                <div class="btn-style-1">
                                    <a class='font-size-14 btn-1-padding-2' href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" >Shop now </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        endif;
                        endforeach;            
                      ?>
                    </div>
                    <div class="col-lg-4">
                    <?php foreach($banners_other as $row) :
                      if($row->seq==2):
                     ?>
                        <div class="banner-wrap wow tmFadeInUp mb-30">
                            <div class="banner-img banner-img-zoom">
                                <a href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>" ><img src="<?= IMGS_URL.$row->img; ?>" height="335px" alt=""></a>
                                
                            </div>
                            <div class="banner-content-3  pt-100">
                                <div class="btn-style-1">
                                    <a class='font-size-14 btn-1-padding-2' href="<?=($row->link_type==2)?base_url('products/'._encode($row->link_id)):'#'  ?>"  >Shop now </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                    endforeach;            
                   ?>
                    </div>
                    
                </div>
            </div>
        </div>




         <div class="contact-area bg-gray-2">
            <div class="custom-container">
                <div class="row">
                    <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="single-contact-wrap text-center wow tmFadeInUp">
                            <h4>Store location</h4>
                            <p> 219 Amara Fort Apt. 394</p>
                        </div>
                    </div> -->
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="single-contact-wrap text-center wow tmFadeInUp">
                            <h4>Work inquiries</h4>
                            <p> hello@superhouse.com</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="single-contact-wrap text-center wow tmFadeInUp">
                            <h4>Call us</h4>
                            <p> 800 388 80 90</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="single-contact-wrap text-center wow tmFadeInUp">
                            <h4>Open hours</h4>
                            <p> Mon-Sat : 08.00 - 18.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       