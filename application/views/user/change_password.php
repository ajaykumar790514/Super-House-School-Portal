<script src="<?= base_url(); ?>assets/js/bootstrap-notify.min.js"></script>

<div class="card mt-3">

    <div class="card-header"><h5>Cahnge Password</h5></div>

    <div class="card-body">

        <form class="row" id="change-password">

            <p id="error-msg" class="text-danger"></p>

            <div class="col-sm-12">

                <div class="form-group">

                    <label>Old Password</label>                        

                    <input type="password" id="old_pwd" name="old_pwd" class="form-control" placeholder="Password" required minlength="8">                        

                </div>                   

            </div>

            <div class="col-sm-12 mt-3">

                <div class="form-group">

                    <label>New Password</label>                        

                    <input type="password" name="new_pwd" id="newp" class="form-control" placeholder="Password" required minlength="8" onkeyup="validatePassword()"  >

                    <p class="text-danger" id="error-message1"></p>                     

                </div>                   

            </div>

            <div class="col-sm-12 mt-3">

                <div class="form-group">

                    <label>Confirm Password</label>                        

                    <input type="password" id="confp" name="conf_pwd" class="form-control" placeholder="Password" required minlength="8" onkeyup="validateCPassword()">

                    <p class="text-danger" id="error-message2"></p>                      

                </div>                   

            </div>

            <div class="col-sm-12 mt-3">

                <button type="button" id="submitbtn" class="btn btn-primary text-center" onclick="change_password(this)"> Submit </button>

            </div>

        </form>

    </div>

</div>



<script>

    

    function validatePassword() {

            var passwordInput = document.getElementById('newp');

            var errorMessage = document.getElementById('error-message1');

            var submitButton = document.getElementById('submitbtn');

            var lowercaseRegex = /[a-z]/;

            var uppercaseRegex = /[A-Z]/;

            var digitRegex = /[0-9]/;

            var specialRegex = /[$#@!%&]/;



            var hasLowercase = lowercaseRegex.test(passwordInput.value);

            var hasUppercase = uppercaseRegex.test(passwordInput.value);

            var hasDigit = digitRegex.test(passwordInput.value);

            var hasSpecial = specialRegex.test(passwordInput.value);

            var isLengthValid = passwordInput.value.length >= 8;



            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {

                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';

                submitButton.disabled = true;

            } else {

                errorMessage.textContent = '';

                submitButton.disabled = false;

            }

        }



        function validateCPassword() {

            var passwordInput = document.getElementById('confp');

            var errorMessage = document.getElementById('error-message2');

            var submitButton = document.getElementById('submitbtn');

            var lowercaseRegex = /[a-z]/;

            var uppercaseRegex = /[A-Z]/;

            var digitRegex = /[0-9]/;

            var specialRegex = /[$#@!%&]/;



            var hasLowercase = lowercaseRegex.test(passwordInput.value);

            var hasUppercase = uppercaseRegex.test(passwordInput.value);

            var hasDigit = digitRegex.test(passwordInput.value);

            var hasSpecial = specialRegex.test(passwordInput.value);

            var isLengthValid = passwordInput.value.length >= 8;



            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {

                errorMessage.textContent = 'Confirm Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';

                submitButton.disabled = true;

            } else {

                errorMessage.textContent = '';

                submitButton.disabled = false;

            }

        }

    function change_password(btn)

    {

        

        let flag = 0;

        let newp = $('input[name="new_pwd"]').val();

        let confp = $('input[name="conf_pwd"]').val();

        let old_pwd = $('input[name="old_pwd"]').val();

        if (old_pwd == '' || old_pwd == undefined) {

            $('#old_pwd').css('border', '1px solid red');

            $('#error-msg').text("Enter  Old Password.")

            flag = 1;

            return;

          }

        if (newp == '' || newp == undefined) {

            $('#newp').css('border', '1px solid red');

            $('#error-msg').text("Enter New Password.")

            flag = 1;

            return;

            }

           if (confp == '' || confp == undefined) {

            $('#confp').css('border', '1px solid red');

            $('#error-msg').text("Enter  Confirm Password.")

            flag = 1;

            return;

          }

          if (old_pwd == newp ) {

            $('#confp').css('border', '1px solid red');

            $('#error-msg').text("Old or New Password not use same.")

            flag = 1;

            return;

            }

         

        if (newp !=confp) {

            $('#error-msg').text("Your password not match.")

            $(btn).text("Submit").removeAttr("disabled");

            flag = 1;

            return;

        }

        if(flag==0){

            $(btn).text("Please wait...").attr("disabled");

        let dataString = $("#change-password").serialize();

        $.ajax({

            url: "<?php echo base_url('user/users/update_password'); ?>",

            method: "POST",

            data: dataString,                

            success: function(data){
               if(data==='1'){
                $(btn).text("Submit").removeAttr("disabled");

                $('input[name="old_pwd"]').val('');

                $('input[name="new_pwd"]').val('');

                $('input[name="conf_pwd"]').val('');

                $('#error-msg').css("visibility","hidden")

                $('#confp').css('border', '1px solid black');

                $('#old_pwd').css('border', '1px solid black');

                $('#newp').css('border', '1px solid black');

                //// notification

                $.notify({

                    icon: 'fa fa-check',

                    title: 'Success!',

                    message: 'Password updated.'

                },{

                    element: 'body',

                    position: null,

                    type: "success",

                    allow_dismiss: true,

                    newest_on_top: false,

                    showProgressbar: true,

                    placement: {

                        from: "top",

                        align: "right"

                    },

                    offset: 20,

                    spacing: 10,

                    z_index: 1031,

                    delay: 5000,

                    animate: {

                        enter: 'animated fadeInDown',

                        exit: 'animated fadeOutUp'

                    },

                    icon_type: 'class',

                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +

                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +

                    '<span data-notify="icon"></span> ' +

                    '<span data-notify="title">{1}</span> ' +

                    '<span data-notify="message">{2}</span>' +

                    

                    '<a href="{3}" target="{4}" data-notify="url"></a>' +

                    '</div>'

                });

                //// notification end
               }else{
                $.notify({
                    icon: 'fa fa-times', // Cross icon for failure
                    title: 'Failed!',
                    message: 'Password not updated, old password does not match.'
                }, {
                    element: 'body',
                    position: null,
                    type: "danger",
                    allow_dismiss: true,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        '</div>'
                });

               }

            },

        });

    }

    }

</script>