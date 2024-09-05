<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="<?=base_url('dashboard');?>">Home</a>
                        </li>
                        <li>
                        <a href="<?= base_url('products/'._encode($cat_id)) ?>">
                                <?= $cat_detail->name; ?>
                            </a>
                        </li>
                        <?php if( $subcat_detail ): ?>
                        <li class="active"> <?= $subcat_detail->name; ?> </li>
                        <?php endif; ?>   
                    </ul>
                </div>
            </div>
        </div>
        <style>
        #spinner-div {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 50%;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 2;
        }
        </style>
        <main>        
        <div class="single-product">
            
        </div>
        <div id="spinner-div" class="pt-5">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
        <script>
            $(".single-product").load('<?=base_url()?>home/single_product_detail/<?= $inventory_id ?>/<?= $cat_id ?>/<?= $sub_cat_id ?>');
        </script>


        </main>



     
  
<script>    
    ///////// prop filter by Ajay Kumar
    function select_props_single(btn, pid, value, prop_id){ 
        $('#spinner-div').show();
        $.ajax({
            url:"<?= base_url('home/get_product_map_details'); ?>",
            method:"POST",
            data:{
                pid:pid,
                value:value,
                prop_id:prop_id
            },
            dataType:"JSON",
            success:function(data){
                // console.log(data);
                $('#spinner-div').hide();
                if (data.get_prop_data) {
                   
                    $(data.get_prop_data).each(function(index,element){
                        if (index == 0) {
                            
                            $.ajax({
                                url:"<?= base_url('home/get_product_map_details_second'); ?>",
                                method:"POST",
                                data:{
                                    pid:element[0].product_id               
                                },
                                dataType:"JSON",
                                success:function(data){
                                    // console.log(data);
                                    if (data.inventry_data) {
                                        if (data.inventry_data[0].qty == 0) {
                                            alert("This product is out of stock");
                                        }else{
                                            $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');                                        
                                        }
                                    }
                                }
                            });
                        }                        
                        
                    });
                }               
            }
        });
    }


    // fro dropdown
    function select_props_single_dropdown(btn, pid, prop_id){
        $('#spinner-div').show();
        let value = $(btn).find('option:selected').attr('data-selectid');
        $.ajax({
            url:"<?= base_url('home/get_product_map_details'); ?>",
            method:"POST",
            data:{
                pid:pid,
                value:value,
                prop_id:prop_id
            },
            dataType:"JSON",
            success:function(data){
                // console.log(data);
                $('#spinner-div').hide();
                if (data.get_prop_data) {
                    $(data.get_prop_data).each(function(index,element){
                        if (index == 0) {
                            $.ajax({
                                url:"<?= base_url('home/get_product_map_details_second'); ?>",
                                method:"POST",
                                data:{
                                    pid:element[0].product_id               
                                },
                                dataType:"JSON",
                                success:function(data){
                                    // console.log(data);
                                    if (data.inventry_data) {
                                        if (data.inventry_data[0].qty == 0) {
                                            alert("This product is out of stock");
                                         $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');   
                                        }else{
                                            $(".single-product").load('<?=base_url()?>home/single_product_detail/'+data.inventry_data[0].id+'/<?= $cat_id ?>/<?= $sub_cat_id ?>');                                        
                                        }
                                    }
                                }
                            });
                        }                        
                        
                    });
                }               
            }
        });
    }

    $('body').on('submit', '#check-pincode', function(e){
        e.preventDefault();
        let dataString = $("#check-pincode").serialize();
        $.ajax({
            url:"<?= base_url('home/check_delivery_area'); ?>",
            method:"POST",
            data:dataString,
            success:function(data){
                // console.log(data);
                if (data == 'SUCCESS') {
                    $("#available-msg").text("Service available here.");
                }else{
                    $("#available-msg").text("Service not available.");
                }                
            }
        });
    });

</script>


      