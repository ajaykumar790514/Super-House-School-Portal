

<div class="tab-pane fade active show mt-3" id="address" role="tabpanel" aria-labelledby="address-tab">
     <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">My Address</h5>
                                            </div>
<div class="card-body">
    <div class="row  p-10">
        <input type="hidden" id="deleteId" />
        <input type="hidden" name="page_url" value="<?= $page_url ?>">
  <?php 
    foreach($addresses as $address){ 
        if($address->nickname == 'HOME')
        {
            $nickname_icon = '<i class="icofont-ui-home icofont-3x"></i>';
        }else if($address->nickname == 'OFFICE'){
            $nickname_icon = '<i class="icofont-briefcase icofont-3x"></i>';
        }else{
            $nickname_icon = '<i class="icofont-location-pin icofont-3x"></i>';
        }
    ?>
                                            <div class="col-lg-6 mt-2" id="<?=$address->id?>">
                                                <div class="card mb-lg-0">
                                                    <div class="card-header">
                                                        <h5 class="mb-0"><?= $address->contact_person_name; ?></h5>
                                                        <div class="mr-4"><?= $nickname_icon; ?></div>
                                                          <div>
                                                            <div class="text-end">
                                                            <?php if( $address->is_default=='0' ): ?>
                                                            <span class="badge bg-success" id="badge" role="button" data-id="<?=$address->id?>">Default Address</span>
                                                            <?php else: ?>
                                                            <span class="badge bg-warning" id="badge" role="button" data-id="<?=$address->id?>">Set As Default</span>
                                                            <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="card-body">
                                                        <address><?= $address->address_line_1.' '.$address->address_line_2.' '.$address->address_line_3.' '.$address->city_name.' '.$address->state_name.' '.$address->country.' , '.$address->pincode ; ?></address>
                                                        <p><span class="text-dark">Phone: </span><?= $address->mobile; ?></p>
                                                        <a data-bs-toggle="modal" data-bs-target="#add-address-modal" data-whatever="Edit Delievery Address" href="javascript:void(0)" data-url="<?=$edit_addr_url?><?=$address->id?>" class="btn-small text-danger mr-4 "><i class="fi-rs-edit"></i> Edit</a>
                                                        <a data-bs-toggle="modal" data-bs-target="#delete-address-modal" href="#"  onclick="delete_address(<?= $address->id; ?>)" class="btn-small ml-5 text-danger "><i class="fi-rs-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>
        <?php
            }
        ?>
        <div class="col-md-6 pb-4 mt-10">
            <a data-bs-toggle="modal" data-bs-target="#add-address-modal" data-bs-whatever="Add Delievery Address" data-url="<?=$edit_addr_url?>" href="javascript:void(0);" >
                <div class="bg-light border rounded  mt-3  shadow-sm text-center h-100 d-flex align-items-center">
                    <h6 class="text-center  w-100"><i class="far fa-plus" style="font-size: 1.3rem;"></i><br><br>Add New Address</h6>
                </div>
            </a>
        </div>                           
    </div>
</div>
</div>
</div>




<!--Add Address modal-->
<div class="modal fade custom-modal" id="add-address-modal" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
    <div class="modal-dialog" style="overflow-y: initial !important">
        <div class="modal-content">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            <div class="modal-header">
                <h5 class="modal-title" id="add-address">Add Delivery Address</h5>
            </div>
            <form method="POST" action="<?= $add_url ?>" class="saddress-form">
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer justify-content-between d-flex">
                    <button type="button" class="btn text-center btn-danger " data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn text-center btn-primary">SUBMIT</button>
                </div>
            </form>
    
    </div>
    </div>
</div>
<!--/Add Address modal-->

<!--Delete Address modal-->
<div class="modal fade" id="delete-address-modal" tabindex="-1" role="dialog" aria-labelledby="delete-address" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-black">Are you sure?</p>
            </div>
            <div class="modal-footer justify-content-between d-flex">
                <button type="button" class="btn text-center btn-danger" data-bs-dismiss="modal">CANCEL
                </button><button type="button" class="btn text-center btn-primary" id="delete-address">DELETE</button>
            </div>
        </div>
    </div>
</div>



<!--/Delete Address modal-->
<script>
    function fetch_state(elem)
    {
        let country = $('option:selected', elem).attr('data-id');
        $.ajax({
            url: "<?php echo base_url('user/fetch_state'); ?>",
            method: "POST",
            data: {
                country:country
            },
            success: function(data){
                $(".state").html(data);
            },
        });
    }
    function fetch_city(elem)
    {
        let state = $('option:selected', elem).attr('data-id');
        
        $.ajax({
            url: "<?php echo base_url('user/fetch_city'); ?>",
            method: "POST",
            data: {
                state:state
            },
            success: function(data){
                $(".city").html(data);
            },
        });
    }
    function delete_address(aid)
    {
       $('#deleteId').val(aid);
    }

    $(document).ready(function(){
        
         $("#delete-address").click(function(){
            var aid=$('#deleteId').val();
            $.ajax({
                url: "<?php echo base_url('user/users/delete_address'); ?>",
                method: "POST",
                data: {
                    aid:aid
                },
                success: function(data){
                    $('#delete-address-modal').modal('toggle');
                    $(`#${aid}`).remove();
                    toastr.success('Address Deleted');
                },
            });
        });
        
        $('#add-address-modal').on('show.bs.modal', function (event) {
            
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var data_url  = button.data('url') 
            var modal = $(this)
            $('#add-address-modal .modal-title').text(recipient)
            $('#add-address-modal .modal-body').load(data_url);
        });

        $(".saddress-form").validate({
            rules : {
                mobile :{
                    minlength: 10,
                    maxlength: 10
                },
                pincode: {
                required:true,
                remote:"<?=$remote?>null/pincode"
            },
            },
            messages : {
                mobile:{
                    minlength: 'Number should be 10 digit.',
                    maxlength: 'Number should be 10 digit.'
                },
                pincode: {
                required : "Please enter pin code!",
                remote : "Delivery not available in this pincode!"
            },
            },
//             submitHandler: function(form, event) { 
//     event.preventDefault();
//    // alert("Do some stuff...");
//     //submit via ajax
//             }
        });

        $(document).on('submit', '.saddress-form', function(e){
            e.preventDefault();
            if( $('.saddress-form').valid() )
            {
                let frm = $(this);
                let btn = frm.find('button[type=submit]');
                let url = frm.attr('action');
                let formdata = $(frm).serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formdata,
                    beforeSend: function() {
                        btn.attr("disabled", true);
                        btn.text("Please wait...");
                    }, 
                    success: function(response) {
                        toastr.success('Address Added Successfully!');
                        // $('.list-group-item-action.active').click();
                        $('.nav-link.active').click();
                        $('#add-address-modal').modal('toggle');
                    },
                    error: function (response) {
                        toastr.error('Something went wrong. Please try again!');
                        btn.removeAttr("disabled");
                        btn.html("Submit");
                    }
                });
            }
            
            return false;
        });        

        $('body').on('click', '#badge', function(){
            let btn = $(this);
            let id = btn.attr('data-id');
            let page_url = $('input[name=page_url]').val();

            $.post(`<?=base_url();?>user/users/default_address`, {id:id}, function(data){
                if( data == 'success' ){
                    $('.badge').text('Set As Default');
                    btn.text('Default Address');
                    $('.dashboard-content').load(page_url);
                }
            });
        });
    });

</script>