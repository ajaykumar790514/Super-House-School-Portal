<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login | Super House </title>
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
    <style>
        input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
#otpdiv{

display: none;
}
#verifyotp{

display: none;
}
#resend_otp{
display: none;
font-size: 1.2rem;
}
#resend_otp:hover{

text-decoration:underline;

}
#resend_otp2{
display: none;
font-size: 1.2rem;
}
#resend_otp2:hover{

text-decoration:underline;

}
    </style>
</head>

<body id="new">

    <div class="main-wrapper">
       
        <div class="login-register-area pt-25 pb-75 pl-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6" id="login">
                        <div class="login-register-wrap login-register-gray-bg">
                        <?php $rs = $this->model->get_row_data1('admin','id','1') ;?>
               <a href="javascript:void(0)" class="text-center db ml-4"><img src="<?=IMGS_URL.$rs->photo;?>" width="100%" height="140px" alt="Home" /></a>
                            <div class="login-register-title">
                                <h1 class="text-center pt-2">Login</h1>
                            </div>
                            <div class="text-danger" id="message"></div>
                            <div class="login-register-form">
                            <ul id="error-login-form" class="text-danger"></ul>
                                <form class="theme-form" id="login-form">
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Mobile Number *</label>
                                        <input type="number" id="mobile" name="mobile" placeholder="Enter Mobile Number" onkeyup='validate3(this)' required>
                                        <span class="error text-danger"></span>
                                    </div>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Password *</label>
                                        <input type="password" name="password" id="password" placeholder="Enter Password" required>
                                    </div>
                                    <div class="lost-remember-wrap">
                                        <div class="remember-wrap">
                                            <input type="checkbox" id="signed_in" name="signed_in" value="1" required>
                                            <span>Remember me</span>
                                        </div>
                                        <div class="lost-wrap">
                                            <a id="lost-password" href="javascript:void(0)">Lost your password?</a>
                                        </div>
                                    </div>
                                    <div class="login-register-btn">
                                    <a href="javascript:void(0)" class="btn btn-solid btn-solid-sm btn-block" id="login-register-btn" onclick="user_login(this)">Login</a>
                                        <!-- <button type="button" id="loginButton">Log in</button> -->
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="createnew">Create New Account?</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mobile" id="mobile" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Create New Account</h1>
                            </div>
                            <div id="message2"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Mobile Number *</label>
                                        <input type="number" id="create_mobile" name="mobile" placeholder="Enter Mobile Number"  onkeyup='validate1(this)' required>
                                        <span class="error text-danger"></span>
                                      
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" id="mobilebtn">Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 otp" id="otp" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Create New Account</h1>
                            </div>
                            <div id="message3"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Enter OTP *</label>
                                        <input type="number" id="create_otp" name="otp" placeholder="Enter OTP" required>
                                        <br><br>
                                                <div class="countdown"></div>
                                            <a href="#" id="resend_otp" class="text-primary" type="button">Resend</a>
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" id="otpbtn">Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 account_school" id="account_school" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Create New Account</h1>
                                <p class="text-center">Select Group , School and Class</p><br>
                            </div>
                            <div id="message5"></div>
                            <div class="login-register-form">
                                <form>
                                   
                                    <div class="form-group">
                                        <label>Group School *</label>
                                        <select name="group" id="group" class="form-control" onchange="fetch_school_class(this.value)">
                                            <option value="">--Group School--</option>
                                            <?php foreach($group as $s):?>
                                            <option value="<?=$s->id;?>"><?=$s->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Select School  *</label>
                                       <select name="school_id" id="school_id" class="form-control school_id">

                                       </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Select Class  *</label>
                                       <select name="class_id" id="class_id" class="form-control class_id">

                                       </select>
                                    </div>
                                    
                                    <div class="form-group mt-2">
                                        <label>Mobile  *</label>
                                        <input type="number" id="account_mobile_school" class="form-control account_mobile_school" name="mobile" placeholder="Enter Moble No" readonly>
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" onclick="submit_form_school()" >Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 account" id="account" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Create New Account</h1>
                                <p class="text-center">Fill Basic details of student</p><br>
                            </div>
                            <div id="message4"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="form-group mt-2">
                                        <label>Enter Name *</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Enter Name" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Email Address *</label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Enter email" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Admission No *</label>
                                        <input type="email" id="admission" class="form-control admission" name="admission" placeholder="Enter Admission No" required>
                                        <p class="text-danger admission-msg"></p>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Mobile  *</label>
                                        <input type="number" id="account_mobile" class="form-control account_mobile" name="mobile" placeholder="Enter Mobile No" readonly>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Password  *</label>
                                        <input type="password"  class="form-control password" name="password" id="password1" placeholder="Enter Password"  minlength="8" onkeyup="validatePassword()">
                                        <p class="text-danger" id="error-message1"></p>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Confirm Password  *</label>
                                        <input type="password"  class="form-control cpassword" name="cpassword" id="cpassword" placeholder="Enter Confirm  Password" minlength="8" onkeyup="validateCPassword()"  >
                                        <p class="text-danger" id="error-message2"></p>
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" class="accountbtn" onclick="submit_form()" id="accountbtn">Submit</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 lost-password-div" id="lost-password-div" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Recover Password</h1>
                            </div>
                            <div id="message6"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Mobile Number *</label>
                                        <input type="number" id="recover_mobile" name="recover_mobile" placeholder="Enter Mobile Number"  onkeyup='validate2(this)' required>
                                        <span class="error text-danger"></span>
                                        <input type="hidden" id="recover_mobile_old" class="recover_mobile_old">
                                      
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" id="recover_mobile_btn">Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn2">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 otp-recover" id="otp-recover" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Recover Password</h1>
                            </div>
                            <div id="message7"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Enter OTP *</label>
                                        <input type="number" id="create_otp_recover" name="otp" placeholder="Enter OTP" required>
                                        <br><br>
                                                <div class="countdown2"></div>
                                            <a href="#" id="resend_otp2" class="text-primary" type="button">Resend</a>
                                    </div>
                                    <div class="login-register-btn">
                                        <button type="button" id="otpbtnrecover">Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn2">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 forgot-recover" id="forgot-recover" style="display: none;">
                        <div class="login-register-wrap login-register-gray-bg">
                            <div class="login-register-title">
                                <h1>Recover Password</h1>
                            </div>
                            <div id="message8"></div>
                            <div class="login-register-form">
                                <form>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>New Password *</label>
                                        <input type="password" id="new-pass" name="new-pass" placeholder="Enter new password" required minlength="8" onkeyup="validatePassword1()" class="new-pass">
                                        <p class="text-danger" id="error-message3"></p>
                                    </div>
                                    <div class="login-register-input-style input-style input-style-white">
                                        <label>Confirm Password *</label>
                                        <input type="password" id="new-cpass" name="new-cpass" placeholder="Enter confirm password" required minlength="8" onkeyup="validateCPassword1()" class="new-cpass">
                                        <p class="text-danger" id="error-message4"></p>
                                        
                                    </div>
                                    <div class="login-register-btn">
                                        <button onclick="submit_form_forgot()" type="button" id="forgot-recover-btn">Next</button>
                                    </div>
                                    <div class="lost-remember-wrap mt-3 float-right mb-5">
                                        <div class="lost-wrap">
                                            <a href="#" id="loginbtn2">Login Here..</a>
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- All JS is here
============================================ -->

    <script src="<?=base_url();?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="<?=base_url();?>assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/slick.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/jquery.syotimer.min.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/wow.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/svg-inject.min.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/jquery-ui.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/jquery-ui-touch-punch.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/magnific-popup.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/select2.min.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/clipboard.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/vivus.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/waypoints.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/counterup.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/mouse-parallax.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/images-loaded.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/isotope.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/scrollup.js"></script>
    <script src="<?=base_url();?>assets/js/plugins/ajax-mail.js"></script>
    <!-- Main JS -->
    <script src="<?=base_url();?>assets/js/main.js"></script>
    
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
      

        function validatePassword() {
            var passwordInput = document.getElementById('password1');
            var errorMessage = document.getElementById('error-message1');
            var submitButton = document.getElementById('accountbtn');
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
            var passwordInput = document.getElementById('cpassword');
            var errorMessage = document.getElementById('error-message2');
            var submitButton = document.getElementById('accountbtn');
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
        function validatePassword1() {
            var passwordInput = document.getElementById('new-pass');
            var errorMessage = document.getElementById('error-message3');
            var submitButton = document.getElementById('forgot-recover-btn');
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

        function validateCPassword1() {
            var passwordInput = document.getElementById('new-cpass');
            var errorMessage = document.getElementById('error-message4');
            var submitButton = document.getElementById('forgot-recover-btn');
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

        
    $(document).on('input', '.admission', function (event) {
    var admission = $(this).val();
    var submitBtn = $('.accountbtn');
    var school_id = $("#school_id").val();

    $.post('<?=base_url()?>Login/check_admission/', {admission: admission,school_id:school_id})
        .done(function (data) {
            if (data.exists) {
                submitBtn.prop('disabled', true);
                $('.admission-msg').text('Admission Number Already Exist!.');
            } else {
                submitBtn.prop('disabled', false);
                $('.admission-msg').text();
            }
        })
        .fail(function () {
            alert_toastr("error", "error");
        });
});

   function fetch_school_class(group)
   {
    $.ajax({
        url: "<?php echo base_url('Login/fetch_school'); ?>",
        method: "POST",
        data: {
            group:group
        },
        success: function(data){
            $(".school_id").html(data);
            $.ajax({
            url: "<?php echo base_url('Login/fetch_class'); ?>",
            method: "POST",
            data: {
            group:group
            },
            success: function(data){
            $(".class_id").html(data);
             },
            });
        },
    });
   }
</script>
<script>
function validate1(phoneNum) {
    // Regular expression to validate phone numbers without leading zeros
    var phoneNumRegex = /^([1-9][0-9]{2})[ -]?([0-9]{3})[ -]?([0-9]{4})$/;
    var btn = document.getElementById('mobilebtn');

    if(phoneNum.value.match(phoneNumRegex)) {
        $(".success").html("Valid").fadeIn();
        $(".error").hide(); // Hide error message if valid
        btn.disabled = false; // Enable the button
        window.setTimeout(function() {
            $(".success").html("Valid").fadeOut();
        }, 5000);
    } else {
        $(".error").html("Please enter a valid number").fadeIn();
        btn.disabled = true; // Disable the button
        $(".success").hide(); // Hide success message if invalid
    }
}
function validate2(phoneNum) {
    // Regular expression to validate phone numbers without leading zeros
    var phoneNumRegex = /^([1-9][0-9]{2})[ -]?([0-9]{3})[ -]?([0-9]{4})$/;
    var btn = document.getElementById('recover_mobile_btn');

    if(phoneNum.value.match(phoneNumRegex)) {
        $(".success").html("Valid").fadeIn();
        $(".error").hide(); // Hide error message if valid
        btn.disabled = false; // Enable the button
        window.setTimeout(function() {
            $(".success").html("Valid").fadeOut();
        }, 5000);
    } else {
        $(".error").html("Please enter a valid number").fadeIn();
        btn.disabled = true; // Disable the button
        $(".success").hide(); // Hide success message if invalid
    }
}

function validate3(phoneNum) {
    // Regular expression to validate phone numbers without leading zeros
    var phoneNumRegex = /^([1-9][0-9]{2})[ -]?([0-9]{3})[ -]?([0-9]{4})$/;
    var btn = document.getElementById('login-register-btn');

    if(phoneNum.value.match(phoneNumRegex)) {
        $(".success").html("Valid").fadeIn();
        $(".error").hide(); // Hide error message if valid
        btn.disabled = false; // Enable the button
        window.setTimeout(function() {
            $(".success").html("Valid").fadeOut();
        }, 5000);
    } else {
        $(".error").html("Please enter a valid number").fadeIn();
        btn.disabled = true; // Disable the button
        $(".success").hide(); // Hide success message if invalid
    }
}



    </script>
    
<script>
    $(document).ready(function() {
        $('#createnew').click(function() {
            $('#login').hide();
            $('.mobile').show(); // Toggle the visibility of the div
        });
        $('#loginbtn').click(function() {
            $('#login').show();
            $('.mobile').hide();
            // Toggle the visibility of the div
        })
        $('#loginbtn2').click(function() {
            $('#login').show();
            $('.lost-password-div').hide();
            // Toggle the visibility of the div
        })
        $('#lost-password').click(function() {
            $('#login').hide();
            $('.lost-password-div').show(); // Toggle the visibility of the div
        });

        
    });
</script>
<script>
    	function user_login(btn) {
		dataString = $("#login-form").serialize();
        $.ajax({
            type: "POST",
            url: '<?= base_url("login") ?>',
            data: dataString,
            dataType: 'json',
            beforeSend: function() {
                $(btn).attr("disabled", true);
                $(btn).text("Process...");
            },
            success: function(data){ 
            // console.log(data);             
              if (data.status == false) {
              	$(btn).text("Login").removeAttr("disabled");
                $("#error-login-form").html('');
                $("#error-login-form").html("<h5 class='text-danger'>"+data.error+"</h5>");
              }

              if (data.status == true) {
                $("#error-login-form").html('');
               // window.location.href = base_url+'profile';   
                window.location.href = '<?= base_url("dashboard") ?>';               
              }
            }
        });
        return false;  //stop the actual form post !important!
	}
    $(document).ready(function() {
        $('#loginButton').click(function() {
            var flag = 0;
            var mobile = $('#mobile').val();
            var password = $('#password').val();
            var signed_in = $("#signed_in").val();
            if (mobile == '' || mobile == undefined) {
            $('#mobile').css('border', '1px solid red');
            flag = 1;
            showMessage('Mobile  cannot be blank.', 'error');
                return;
            }
           if (password == '' || password == undefined) {
            $('#password').css('border', '1px solid red');
            flag = 1;
            showMessage('Password cannot be blank.', 'error');
                return;
          }
        //   if (signed_in == '' || signed_in == undefined) {
        //     $('#signed_in').css('border', '1px solid red');
        //     flag = 1;
        //     showMessage('Checkbox check.', 'error');
        //         return;
        //   }
          if (flag == 0) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url("login") ?>',
                data: { mobile: mobile, password: password,signed_in:signed_in },
                dataType: 'json',
                success: function(response) {
                    if (response.status ==true) {
                       showMessage('Login successful. Redirecting...', 'success');
                       // Redirect or perform any other action for successful login
                       setTimeout(function() {
                           window.location.href = '<?= base_url("dashboard") ?>';
                       }, 2000); // Redirect after 2 seconds
                   } else {
                       showMessage(response.error, 'error');
                   }
                },
                error: function() {
                    showMessage('Error in the AJAX request', 'error');
                }
            });
          }else
          {

          }
        });
    });
  
</script>
<script>
       // Opt area BY AJAY KUMAR
$(document).ready(function(){

function send_otp(number){
if(number==''){
showMessage('Please Enter your Mobile Number', 'error');

}else{
    $.ajax({
url:"<?=base_url();?>create-account",
type:"POST",
data:{mobile:number},
success:function(data)
{
    console.log(data);
     data = JSON.parse(data);
    
    if (data.res=='success') {
    showMessage('OTP send you mobile number', 'success');
    timer();
    $("#account_mobile").val(number);
    $("#account_mobile_school").val(number);
    $(".otp").show();
    $(".mobile").hide();
    $("#login").hide();
   }
   
   if(data.res=='error')
   {
    showMessage(data.msg, 'error');
    $(".mobile").show();
    $("#login").hide();
   }
}
});
}
};

// send otp
$('#mobilebtn').click(function(){

var number = $('#create_mobile').val();
send_otp(number);
});
//resend otp function
$('#resend_otp').click(function(){

var number = $('#create_mobile').val();

send_otp(number);
$(this).hide();
});
//end of resend otp function

});
//start of timer function

function timer(){

var timer2 = "00:31";
var interval = setInterval(function() {


var timer = timer2.split(':');
//by parsing integer, I avoid all extra string processing
var minutes = parseInt(timer[0], 10);
var seconds = parseInt(timer[1], 10);
--seconds;
minutes = (seconds < 0) ? --minutes : minutes;

seconds = (seconds < 0) ? 59 : seconds;
seconds = (seconds < 10) ? '0' + seconds : seconds;
//minutes = (minutes < 10) ?  minutes : minutes;
$('.countdown').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
//if (minutes < 0) clearInterval(interval);
if ((seconds <= 0) && (minutes <= 0)){
clearInterval(interval);
$('.countdown').html('');
$('#resend_otp').css("display","block");
} 
timer2 = minutes + ':' + seconds;
}, 1000);

}

//end of timer
$(document).ready(function(){
              // check otp
              
        $("#otpbtn").on('click',function(){
           var otp = $('#create_otp').val();
          if(otp==''){
          showMessage('Please Enter Otp', 'error');
          }else{
          $.ajax({
          url:"<?=base_url();?>create-account/check_otp",
          type:"POST",
          data:{otp:otp},
          success:function(data)
          {

             if(data==1)
             {
                $(".account_school").show();
                $(".account").hide();
                $(".otp").hide();
             }else
             {
               
                showMessage('OTP not Correct', 'error');
             }
         }
      });
      }
      })





    });


    function submit_form_school(){
var flag = 0;   
var group_id = $("#group").val();
var class_id = $("#class_id").val();
var school_id = $("#school_id").val();
var mobile = $(".account_mobile_school").val();
if (group_id == '' || group_id == undefined) {
$('#group_id').css('border', '1px solid red');
 flag = 1;
showMessage('Group cannot be blank.', 'error');
return;
}
if (school_id == '' || school_id == undefined) {
$('#school_id').css('border', '1px solid red');
flag = 1;
showMessage('School check.', 'error');
return;
}
if (class_id == '' || class_id == undefined) {
$('#class_id').css('border', '1px solid red');
flag = 1;
showMessage('Class  check.', 'error');
return;
}

if (flag == 0) {
$.ajax({
url:"<?=base_url();?>create-account/schoolnew",
type:"POST",
data:{group_id:group_id,school_id:school_id,class_id:class_id,mobile:mobile},
success:function(data)
{
    console.log(data);
     data = JSON.parse(data);
    
    if (data.res=='success') {
    showMessage(data.msg, 'success');
    $(".account").show();
    $(".account_school").hide();
    $(".mobile").hide();
    $("#login").hide();
    $(".otp").hide();
   }
   
   if(data.res=='error')
   {
    showMessage(data.msg, 'error');
    $(".account_school").show();
    $(".mobile").hide();
    $("#login").hide();
    $(".otp").hide();
   }
}
});
}
};


function submit_form(){
var flag = 0;   
var name = $("#name").val();
var email = $("#email").val();
var admission = $("#admission").val();
var mobile = $(".account_mobile").val();
var password = $(".password").val();
var cpassword = $(".cpassword").val();
if (name == '' || name == undefined) {
$('#name').css('border', '1px solid red');
 flag = 1;
showMessage('Password cannot be blank.', 'error');
return;
}
if (email == '' || email == undefined) {
$('#email').css('border', '1px solid red');
flag = 1;
showMessage('Checkbox check.', 'error');
return;
}
if (admission == '' || admission == undefined) {
$('#admission').css('border', '1px solid red');
flag = 1;
showMessage('Checkbox check.', 'error');
return;
}
// if (school == '' || school == undefined) {
// $('#school').css('border', '1px solid red');
// flag = 1;
// showMessage('Checkbox check.', 'error');
// return;
// }
if (mobile == '' || mobile == undefined) {
$('.account_mobile').css('border', '1px solid red');
 flag = 1;
showMessage('Mobile  cannot be blank.', 'error');
return;
 }
 if (password == '' || password == undefined) {
$('.password').css('border', '1px solid red');
 flag = 1;
showMessage('Mobile  cannot be blank.', 'error');
return;
 }
 if (cpassword == '' || cpassword == undefined) {
$('.cpassword').css('border', '1px solid red');
 flag = 1;
showMessage('Mobile  cannot be blank.', 'error');
return;
 }
 if (cpassword != password) {
$('.cpassword').css('border', '1px solid red');
$('.password').css('border', '1px solid red');
 flag = 1;
showMessage('Password & Confirm Password does not match.', 'error');
return;
 }
if (flag == 0) {
$.ajax({
url:"<?=base_url();?>create-account/new",
type:"POST",
data:{mobile:mobile,name:name,email:email,admission_no:admission,password:password,cpassword:cpassword},
success:function(data)
{
    console.log(data);
     data = JSON.parse(data);
    
    if (data.res=='success') {
    showMessage(data.msg, 'success');
    $(".account").show();
    $(".mobile").hide();
    $("#login").hide();
    $(".otp").hide();
    window.setTimeout(function() {
    location.reload();
}, 1000);
   }
   
   if(data.res=='error')
   {
    showMessage(data.msg, 'error');
    $(".account").show();
    $(".mobile").hide();
    $("#login").hide();
    $(".otp").hide();
   }
}
});
}
};



       // Opt area BY AJAY KUMAR
 $(document).ready(function(){

function send_otp2(number){
if(number==''){
showMessage('Please Enter your Mobile Number', 'error');

}else{
    $.ajax({
url:"<?=base_url();?>create-new-pass",
type:"POST",
data:{mobile:number},
success:function(data)
{
    console.log(data);
     data = JSON.parse(data);
    
    if (data.res=='success') {
    showMessage('OTP send you mobile number', 'success');
    timer();
    $("#recover_mobile_old").val(number);
    $(".otp-recover").show();
    $(".lost-password-div").hide();
    $("#login").hide();
   }
   if(data.res=='error')
   {
    showMessage(data.msg, 'error');
    $(".lost-password-div").show();
    $("#login").hide();
   }
}
});
}
};

// send otp
$('#recover_mobile_btn').click(function(){
var number = $('#recover_mobile').val();
send_otp2(number);
});
//resend otp function
$('#resend_otp2').click(function(){
var number = $('#recover_mobile').val();
send_otp2(number);
$(this).hide();
});
});
//start of timer function

function timer(){

var timer2 = "00:31";
var interval = setInterval(function() {


var timer = timer2.split(':');
//by parsing integer, I avoid all extra string processing
var minutes = parseInt(timer[0], 10);
var seconds = parseInt(timer[1], 10);
--seconds;
minutes = (seconds < 0) ? --minutes : minutes;

seconds = (seconds < 0) ? 59 : seconds;
seconds = (seconds < 10) ? '0' + seconds : seconds;
//minutes = (minutes < 10) ?  minutes : minutes;
$('.countdown2').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
//if (minutes < 0) clearInterval(interval);
if ((seconds <= 0) && (minutes <= 0)){
clearInterval(interval);
$('.countdown2').html('');
$('#resend_otp2').css("display","block");
} 
timer2 = minutes + ':' + seconds;
}, 1000);

}

$(document).ready(function(){
        $("#otpbtnrecover").on('click',function(){
           var otp = $('#create_otp_recover').val();
          if(otp==''){
          showMessage('Please Enter Otp', 'error');
          }else{
          $.ajax({
          url:"<?=base_url();?>create-account/check_otp",
          type:"POST",
          data:{otp:otp},
          success:function(data)
          {

             if(data==1)
             {
                $(".forgot-recover").show();
                $("#login").hide();
                $(".otp-recover").hide();
             }else
             {
               
                showMessage('OTP not Correct', 'error');
             }
         }
      });
      }
      })

    });
function submit_form_forgot(){
var flag = 0;   
var password = $("#new-pass").val();
var mobile = $("#recover_mobile_old").val();
var cpassword = $("#new-cpass").val();

 if (password == '' || password == undefined) {
$('.new-pass').css('border', '1px solid red');
 flag = 1;
showMessage('Mobile  cannot be blank.', 'error');
return;
 }
 if (cpassword == '' || cpassword == undefined) {
$('.new-cpass').css('border', '1px solid red');
 flag = 1;
showMessage('Mobile  cannot be blank.', 'error');
return;
 }
 if (cpassword != password) {
$('.new-cpass').css('border', '1px solid red');
$('.new-pass').css('border', '1px solid red');
 flag = 1;
showMessage('Password & Confirm Password does not match.', 'error');
return;
 }
if (flag == 0) {
$.ajax({
url:"<?=base_url();?>new-password",
type:"POST",
data:{mobile:mobile,password:password,cpassword:cpassword},
success:function(data)
{
    console.log(data);
     data = JSON.parse(data);
    
    if (data.res=='success') {
    showMessage(data.msg, 'success');
    $("#login").hide();
    $(".otp-recover").hide();
    window.setTimeout(function() {
    location.reload();
}, 1000);
   }
   
   if(data.res=='error')
   {
    showMessage(data.msg, 'error');
    $("#login").hide();
    $(".otp-recover").hide();
   }
}
});
}
};
    
</script>
<script>
      function showMessage(message, type) {
            var messageDiv = $('#message');
            messageDiv.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 5000);
            var messageDiv2 = $('#message2');
            messageDiv2.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv2.fadeOut();
            }, 5000);
            var messageDiv3 = $('#message3');
            messageDiv3.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv3.fadeOut();
            }, 5000);
            var messageDiv4 = $('#message4');
            messageDiv4.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv4.fadeOut();
            }, 5000);
            var messageDiv5 = $('#message5');
            messageDiv5.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv5.fadeOut();
            }, 5000);

            var messageDiv6 = $('#message6');
            messageDiv6.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv6.fadeOut();
            }, 5000);

            var messageDiv7 = $('#message7');
            messageDiv7.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv7.fadeOut();
            }, 5000);
            var messageDiv8 = $('#message8');
            messageDiv8.html('<div class="' + (type === 'success' ? 'text-success' : 'text-danger') + '">' + message + '</div>').show();

            // Hide the message after 5 seconds
            setTimeout(function() {
                messageDiv8.fadeOut();
            }, 5000);
            
        }
</script>
</body>

</html>
