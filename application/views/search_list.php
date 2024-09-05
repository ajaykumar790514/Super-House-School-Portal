<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href='<?=base_url();?>dashboard'>Home</a>
                        </li>
                        <li class="active">Search SUPERHOUSE </li>
                    </ul>
                </div>
            </div>
        </div>

 <div class="product-area border-top-2 pt-75 pb-70">
   <div class="custom-container">
   <div class="product-top-filter">
     <div class="row">
       <div class="col-6">
        <div class="product-filter-content">
           <div class="search-count">
           <h5>We found <strong class="text-brand" id="count"></strong> items for you!</h5>
        </div>
         </div>
     </div>
     <div class="col-3"></div>
    <div class="col-3">
   <div class="product-page-filter">                                                        
   <select class="sort_by form-control">
   <option value="newest_first">Newest First</option>
   <option value="low_to_high">Price: Low to High</option>
   <option value="high_to_low">Price: High to Low</option>
   </select>
   </div>
   </div>
   </div>
   </div>
     <div class="section-title-1 mb-40">
       <h2>Related products</h2>
        </div>
        <div class="product-area border-top-2 pt-75 pb-70">
            <div class="custom-container">
                <div class="product-slider-active-1s nav-style-2 nav-style-2-modify-3">
                 <div class="product-wrapper-grid">
                   <?php if ($search_val) { ?>
                        <input type="hidden" value="<?= $search_val; ?>" id="search_val">
                          <?php } ?>                                       
                              <input type="hidden" id="total_pages">
                        <div class="row product-grid-3 filtered_data" id="product-list">                            
                            </div>
                            <div class="col-md-12 text-center load-more" hidden>
                            <button class="btn btn-primary btn-sm" type="button" disabled="">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Loading...
                            </button>
                        </div>
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
                                                    var search_val = $("#search_val").val();
                                                    $("#search-box").val(search_val);
                                                   
                                                    $.ajax({
                                                        url:"<?= base_url(); ?>home/products/search_products",
                                                        method:"POST",
                                                        dataType:"JSON",
                                                        data:{search_val:search_val, sort_by:sort_by, page:page},
                                                        success:function(data)
                                                        {    
                                                            $(".load-more").prop('hidden',true);

                                                            if (data !='') {                                                            
                                                                  $.each(data, function(index,value){
                                                                    $('#total_pages').val(value.total_pages); 
                                                                    $("#count").html(`<span>${value.count}</span>`);
                                                                    ele += `
                                                                    <div class="col-xl-3 col-md-4 col-6 col-grid-box">
                                                                    <div class="product-plr-1">
                                                                    <div class="single-product-wrap">
                                                                        <div class="product-img-action-wrap mb-20">
                                                                            <div class="product-img product-img-zoom">
                                                                                <a href="${value.detail_page}">
                                                                                <img class="default-img" src="${value.img}" alt="${value.product_name}">
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
                                                                    </div>`;
                                                                    
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
                                                                $(".prop-filter").hide();
                                                            }
                                                           // console.log(ele);                                                            
                                                        }
                                                    })
                                                }

                                                function get_filter(class_name)
                                                {           
                                                    var filter = [];
                                                    $('.'+class_name+':checked').each(function(){
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
                 
                </div>
            </div>
        </div>

        </div>
   </div>
 </div>
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



        <!-- <div class="container">
            <div class="row">
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                
                                <div class="collection-product-wrapper">
                               
                                    <div class="product-wrapper-grid">
                                    <?php if ($search_val) { ?>
                                        <input type="hidden" value="<?= $search_val; ?>" id="search_val">
                                        
                                    <?php } ?>                                       
                                         
                                         
                                         <input type="hidden" id="total_pages">

                                         <div class="row product-grid-3 filtered_data" id="product-list">                            
                           
                                        </div>

                                        <div class="col-md-12 text-center load-more" hidden>
                                            <button class="btn btn-primary btn-sm" type="button" disabled="">
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                            </button>
                                        </div>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
     </div>  
       -->
