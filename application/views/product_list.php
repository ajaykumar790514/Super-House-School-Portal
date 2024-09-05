<style>

.checkbox-container input {
    display: none;
}

.checkbox-container {
    display: block;
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    cursor: pointer;
}
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #aaa;
    border-radius: 4px;
}
.checkbox-container input:checked ~ .checkmark {
    background-color: blue;
}
.checkbox-container:hover input ~ .checkmark {
    background-color: #aaa;
}
.checkbox-container:hover input ~ .checkmark {
    background-color: blue;
}
n the checkbox is checked, add a blue background */
.checkbox-container input:checked ~ .checkmark {
    background-color: #2196F3;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}
.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}
.checkbox-container .checkmark:after {
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

</style>
<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href='<?=base_url();?>dashboard'>Home</a>
                        </li>
                        <?php if( $cat_detail ): ?>
                        <li>
                        <a href="<?= base_url('products/'._encode($cat_id)) ?>">
                                <?= $cat_detail->name; ?>
                            </a>
                        </li>
                        <?php endif; ?> 
                   
                        </li>
                   
                        <?php if( $subcat_detail ): ?>
                        <li class="active"><?= $subcat_detail->name; ?></li>
                        
                        <?php endif; ?> 
                    </ul>
                </div>
            </div>
        </div>
        <div class="shop-area adding-30-row-col pt-25">
            <div class="custom-container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-12">
                        <div class="shop-topbar-wrapper">
                            <div class="totall-product">
                               <h4>We found <strong class="text-brand" id="count"></strong> items for you!</h4>
                            </div>
                            <div class="shop-filter">
                                <a class="shop-filter-active" href="#">
                                    <span class="fal fa-filter"></span>
                                    Filters
                                    <i class="far fa-angle-down angle-down"></i>
                                    <i class="far fa-angle-up angle-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-filter-wrapper">
                        <div class="row">
                            <?php 
                            $classes = $this->home_model->getData('class_master', ['is_deleted' => 'NOT_DELETED']); 
                            $i=1; foreach($classes as $class): ?>
                                <div class="col-md-2">
                                    <label class="checkbox-container"><?php echo $class->name; ?>
                                        <input type="checkbox" name="class_checkbox[]" class="form-check-input common_selector prop_filter" value="<?=$i.':'.$class->id?>" value="<?php echo $class->id; ?>"  id="prop_name1<?= $class->id; ?>">
                                        <span for="prop_name1<?= $class->id; ?>" id="prop_name1<?= $class->id; ?>" class="checkmark"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        <?php 
                        $i=1;
                        foreach($props_filter as $prop): ?>
                            <div class="collection-collapse-block prop-filter d-none">
                                <h3 class="collapse-block-title"><?= $prop->name; ?></h3>
                                <div class="collection-collapse-block-content" style="display:none;">
                                    <div class="collection-brand-filter">
                                        <?php 
                                        $this->db->select('t3.value,t3.id as vid,t2.id');
                                        $this->db->from('cat_pro_maps as t1');
                                        $this->db->join('product_props as t2','t1.pro_id=t2.product_id and t2.props_id='.$prop->id);
                                        $this->db->join('product_props_value as t3','t2.value_id=t3.id');
                                        if($sub_cat_id!="")
                                            $this->db->where('t1.cat_id',$sub_cat_id);
                                        else
                                            $this->db->where('t1.cat_id',$cat_id);
                                        $res=$this->db->group_by('t2.value_id')->get()->result();
                                        foreach($res as $row)
                                        {?>
                                         <div class="form-check collection-filter-checkbox">
                                                <input type="checkbox" class="form-check-input common_selector prop_filter" value='<?=$i.':'.$row->vid?>' id="prop_name1<?= $row->id; ?>">
                                                <label class="form-check-label" for="prop_name1<?= $row->id; ?>" id="prop_name1<?= $row->id; ?>"><?= $row->value; ?></label>
                                            </div>
                                       <?php
                                       } ?> 
                                    </div>
                                </div>
                            </div>
                        <?php
                        $i++;
                        endforeach;  ?>  
                        
        <div class="product-area border-top-2 pt-25 pb-70">
            <div class="custom-container">
            <!-- <h5>We found <strong class="text-brand" id="count"></strong> items for you!</h5> -->
            <!-- <hr> -->
                <div class="section-title-1 mb-40">
                </div>
                <input type="hidden" id="total_pages">
                <div class="product-slider-active-1s nav-style-2 nav-style-2-modify-3">
                <div class="row product-grid-3 filtered_data" id="product-list">                            
                           
                </div>
                </div>
            </div>
        </div>
        <?php if ($sub_cat_id) { ?>
         <input type="hidden" value="<?= $sub_cat_id; ?>" id="sub_cat_id">
         <?php }else{ ?>
         <input type="hidden" value="<?= $cat_id; ?>" id="cat_id">
         <?php } ?>
        <script>
                                            $(document).ready(function(){
                                                var page =0;
                                                var ele = '';
                                                filter_products(3,page);
                                                //pagination code
                                                $(window).scroll(function(){
                                                    if($(window).scrollTop() + $(window).height() > $(".filtered_data").height()) 
                                                    {
                                                        var total_pages = $("#total_pages").val();
                                                        page++;
                                                        if(page <= total_pages-1) 
                                                        {
                                                            filter_products(3,page);
                                                        }
                                                    }
                                                });
                                                //end pagination code
                                                function filter_products(sort_by,page)
                                                {
                                                    $(".load-more").prop('hidden',false);
                                                    var cat_id = $("#cat_id").val();
                                                    var sub_cat_id = $("#sub_cat_id").val();
                                                    var prop_filter = get_filter('prop_filter');
                                                    var base_url="<?=base_url();?>";
                                                    $.ajax({
                                                        url:"<?= base_url(); ?>home/products/filter_products",
                                                        method:"POST",
                                                        dataType:"JSON",
                                                        data:{sub_cat_id:sub_cat_id,cat_id:cat_id,prop_filter:prop_filter,prop_filter_count:<?=$i?>, sort_by:sort_by, page:page},
                                                        success:function(data)
                                                        {    
                                                            $(".load-more").prop('hidden',true);

                                                            if (data !='') {                                                          $.each(data, function(index,value){
                                                                    $('#total_pages').val(value.total_pages); 
                                                                    $("#count").html(`<span>${value.count}</span>`);
                                                                    ele += `
                                                                    <div class="col-xl-3 col-md-4 col-6 col-grid-box">
                                                                    <div class="product-plr-1">
                                                                    <div class="single-product-wrap">
                                                                        <div class="product-img-action-wrap mb-20">
                                                                            <div class="product-img product-img-zoom">
                                                                            <input type="hidden" value="${value.product_name}" id="product_name">
                                                                                <a href="${value.detail_page}">
                                                                                    <img class="default-img" src="${value.img}" alt="${value.product_name}" onerror="this.src='<?= base_url(); ?>assets/img/noimage.png'">
                                                                                </a>
                                                                            </div>
                                                                            <div class="product-action-1">
                                                                                `
                                                                                if (value.product_qty > 0) {
                                                                                        ele += `
                                                                                        <button
                                                                                        id="cart_btn${value.id}" onclick="add_to_cart_by_btn(${value.id},this)" href="javascript:void(0)" aria-label="Add To Cart"><i class="far fa-shopping-bag"></i></button>`
                                                                                        if (value.wishlist !='') {
                                                                                        ele += `${value.wishlist}`
                                                                                        
                                                                                    }
                                                                                        }else{
                                                                                        ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm mt-1 me-1" >Out of Stock</button>`
                                                                                        <?php if( is_logged_in() ): ?>
                                                                                            ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm" onclick="notify_me(<?=$this->session->userdata('user_id')?>,${value.product_id},this)">Notify Me</button>`
                                                                                        <?php else:?>
                                                                                            ele += `<button type="button" class="button button-add-to-cart btn-solid btn-solid-sm mt-1 ms-1" onclick="openAccount()">Notify Me</button>`
                                                                                        <?php endif;?>
                                                                                    }
                                                                          ele +=`</div>
                                                                            <div class="product-badges product-badges-position product-badges-mrg">`
                                                                            if (value.deal_tag_0 !='') {
                                                                                        ele += `${value.deal_tag_0}`
                                                                                    }
                                                                                
                                                                            ele +=`</div>
                                                                        </div>
                                                                            <div class="product-content-wrap">`
                                                                            if (value.checkbundle=='1') {
                                                                                ele += `${value.bundle}`
                                                                                    }else
                                                                         if (value.checkbundle=='0') {
                                                                                ele += `${value.bundle}`
                                                                                    }     
                                                                            ele +=`<h2><a href="${value.detail_page}">${value.product_name}</a></h2>
                                                                            <div class="product-price">
                                                                            ${value.offers}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                `;
                                                                    
                                                                    ele +=`  </div>
                                                                    </div>
                                                                </div>
                                                                </div>`;                                         
                
                                                                });
                                                                $('.filtered_data').html(ele);
                                                                 $.each(data, function(index,value){
                                                                    $(".prop_"+value.product_id).load('<?=base_url()?>home/get_mapped_props/'+value.product_id);
                                                                });
                                                            }
                                                            else{
                                                                ele += `<div class="col-xl-12 col-grid-box mt-2"><h3>Not found any products</h3></div>`;
                                                                $('.filtered_data').html(ele);
                                                            }             
                                                        }
                                                    })
                                                }
                                                function get_filter(class_name)
                                                {           
                                                    var filter = []; $('.'+class_name+':checked').each(function(){
                                                        filter.push($(this).val());
                                                    });
                                                    return filter;
                                                }
                                                    document.addEventListener('click', function(event) {
                                                        if (event.target.classList.contains('bundle-link')) {
                                                            event.preventDefault();
                                                            showModal(event.target.getAttribute('data-proid'));

                                                        }
                                                    });

                                                    function showModal(productId) {
                                                    $.ajax({
                                                        url: '<?= base_url() ?>home/load_bundle_name/' + productId,
                                                        type: 'GET',
                                                        success: function(pro_name) {
                                                            $('.proname').text(pro_name);
                                                            $("#load_details_").load('<?= base_url() ?>home/load_bundle_details/' + productId);
                                                            $('#bundleModal').modal('show');
                                                        },
                                                        error: function() {
                                                            console.error('Error loading data.');
                                                        }
                                                    });
                                                }


                                                $('.common_selector').click(function(){
                                                    ele = '';
                                                    page=0;
                                                    $('.filtered_data').html("");
                                                    filter_products(3,page);
                                                });
                                                $('.sort_by').change(function(){
                                                    var sort_by_val = $(".sort_by").val();
                                                    if (sort_by_val == 'low_to_high') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(1,page);
                                                    }

                                                    if (sort_by_val == 'high_to_low') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(2,page);
                                                    }

                                                    if (sort_by_val == 'newest_first') {
                                                        ele = '';
                                                        page=0;
                                                        filter_products(3,page);
                                                    }
                                                });
                                            });
                                       </script>

<div class="modal fade" id="bundleModal" tabindex="-1" aria-labelledby="bundleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title proname" id="bundleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
               <div id="load_details_" class="bundle-details"></div>
            </div>
        </div>
    </div>
</div>