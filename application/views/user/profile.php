<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/dropify/css/dropify.min.css">

<script src="<?=base_url()?>assets/vendor/dropify/js/dropify.min.js"></script>

<script src="<?= base_url('assets/js/vendor/jquery.validate.min.js') ?>"></script>

<div class="card card-body account-right mt-3">

    <div class="widget">

        <div class="section-header">

            <h4 class="fw-500 mb-0" > 

            My Profile

            </h4>

        </div>

        <form action="<?= $edit_url ?>" class="profile-form" autocomplete="off">

            <div class="row">

                <div class="col-sm-12 mt-3">

                    <div class="form-group">

                        <label class="control-label">Profile </label>

                        <input class="form-control border-form-control dropify" data-allowed-file-extensions="jpg png jpeg" data-default-file="<?= @$user->photo ? IMGS_URL.$user->photo : '' ?>" data-show-remove="false" name="photo" type="file"  style="height:400px">

                        <input type="hidden" name="old_photo" value="<?= @$user->photo ?>" />

                        <input type="hidden" name="uid" value="<?= @$user->id ?>" />

                    </div>

                </div>

                <div class="col-sm-6 mt-3">

                    <div class="form-group">

                        <label class="control-label">Name <span class="required">*</span></label>

                        <input type="text" value="<?= @$user->name ?>" name="name" class="form-control" placeholder="Enter Name">

                        <span class="name text-danger" required></span>

                    </div>

                    

                </div>

                <div class="col-sm-6 mt-3">

                    <div class="form-group">

                        <label class="control-label">Email <span class="required">*</span></label>

                        <input type="text" value="<?= @$user->email ?>" name="email" class="form-control" placeholder="Email" required>

                         <span class="email text-danger"></span>

                    </div>                   

                </div>

            </div>

            <div class="row">

            <div class="col-sm-6 mt-3">

                    <div class="form-group">

                        <label class="control-label">Mobile <span class="required">*</span></label>

                        <input type="number" value="<?= @$user->mobile ?>" name="mobile" class="form-control" placeholder="Mobile" readonly required>

                         <span class="mobile text-danger"></span>

                    </div>                   

                </div>

              

                <div class="col-sm-6 mt-3">

                    <div class="form-group">   

                    <label class="control-label">Admission No <span class="required">*</span></label>

                        <input type="text" value="<?=@$user->admission_no;?>" name="admission_no" class="form-control" placeholder="Admission NO" readonly required>

                         <span class="admission_no text-danger"></span>

                    </div>                   

                </div>

                <div class="col-sm-6 mt-3">

                    <div class="form-group">   

                    <label class="control-label">School <span class="required">*</span></label>

                        <select name="school" id="school" class="form-control" required>

                            <option value="">--Select--</option>

                            <?php foreach($school as $s): ?>

                            <option value="<?=$s->id;?>" <?php if($s->id==@$user->school_id){echo "selected";} ;?> ><?=$s->name;?></option>

                            <?php endforeach;?>

                        </select>                    

                         <span class="school text-danger"></span>

                    </div>                   

                </div>

                    <div class="col-sm-6 mt-3">

                    <div class="form-group">  

                    <label class="control-label">Class <span class="required">*</span></label>

                        <select name="class_id" id="class_id" class="form-control" required>

                            <option value="">--Select--</option>

                            <?php foreach($classs as $class): ?>

                            <option value="<?=$class->id;?>" <?php if($class->id==@$user->class_id){echo "selected";} ;?> ><?=$class->name;?></option>

                            <?php endforeach;?>

                        </select>                    

                         <span class="class_id text-danger"></span>

                    </div>                   

                </div>
                 <div class="col-sm-12 mt-3">

                    <div class="form-group">  

                    <label class="control-label">Group <span class="required">*</span></label>

                        <select  class="form-control" disabled>

                            <?php foreach($groups as $grpup): ?>

                            <option value="<?=$grpup->id;?>" selected><?=$grpup->name;?></option>

                            <?php endforeach;?>

                        </select>                    

                         <span class="class_id text-danger"></span>

                    </div>                   

                </div>

            </div>



            <div class="row mt-3">

                <div class="col-sm-12 text-center">

                    <button type="submit" class="btn btn-primary"> Save </button>

                </div>

            </div>

        </form>

    </div>

</div>



<script type="text/javascript">

      $(".profile-form").validate({

            rules : {

                mobile :{

                    minlength: 10,

                    maxlength: 10,

                },

            },

            messages : {

                mobile:{

                    minlength: 'Number should be 10 digit.',

                    maxlength: 'Number should be 10 digit.',

                }

            }

        });

    $(document).ready(function(){

        $(".dropify").dropify();



        $('body').on('submit', '.profile-form', function(e){

          

            e.preventDefault();

            if( $('.profile-form').valid() )

            {

            let frm = $(this);



            let url = frm.attr('action');

            let btn = frm.find('button[type=submit]');

            let name = frm.find('input[name=name]').val();

            let school = frm.find('select[name=school]').val();

            let email = frm.find('input[name=email]').val();

            let admission_no = frm.find('input[name=admission_no]').val();

            let mobile = frm.find('input[name=mobile]').val();

            let old_phto = frm.find('input[name=old_photo]').val();

            let uid = frm.find('input[name=uid]').val();

            let class_id = frm.find('select[name=class_id]').val();

            if( !name )

            {

                frm.find('span.name').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter  Name');

                return false;

            }else{

                frm.find('span.name').html('');

            }

            if( !email )

            {

                frm.find('span.email').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Email');

                return false;

            }else{

                frm.find('span.email').html('');

            } 

            if( !mobile )

            {

                frm.find('span.mobile').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Mobile Number');

                return false;

            }else{

                frm.find('span.mobile').html('');

            } 

            if( !admission_no )

            {

                frm.find('span.admission_no').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Enter Admission Number');

                return false;

            }else{

                frm.find('span.admission_no').html('');

            } 

            if( !school )

            {

                frm.find('span.school').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Select School');

                return false;

            }else{

                frm.find('span.school').html('');

            }

              if( !class_id )

            {

                frm.find('span.class_id').html('<i class="fa fa-times text-danger"></i>&nbsp; Please Select Class');

                return false;

            }else{

                frm.find('span.class_id').html('');

            }

                      

            

            let formdata = new FormData(frm[0]);



            $.ajax({

                url: url,

                type: 'POST',

                data: formdata,

                contentType: false,

                processData: false,

                // dataType: 'json',

                beforeSend: function() {

                    btn.attr("disabled", true);

                    btn.text("Please wait...");

                }, 

                success: function(response) {

                    // console.log(response);

                    toastr.success('Profile Updated!');

                    window.location.reload();

                },

                error: function (response) {

                    btn.removeAttr("disabled");

                    btn.html("Save");

                    toastr.error('Please try again!');

                }

            });

        }

            return false;

        });

    });

</script>