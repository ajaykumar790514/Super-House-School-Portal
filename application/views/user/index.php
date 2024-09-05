<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">

            <div class="custom-container">

                <div class="breadcrumb-content text-center">

                    <ul>

                        <li>

                            <a href='/medizin/'>Home</a>

                        </li>

                        <li class="active">My Account</li>

                    </ul>

                </div>

            </div>

        </div>

        <input type="hidden" name="page_url" value="<?= $page_url ?>">

        <div class="my-account-area pt-75 pb-75">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">

                        <!-- My Account Page Start -->

                        <div class="myaccount-page-wrapper">

                            <!-- My Account Tab Menu Start -->

                            <div class="row">

                                <div class="col-lg-4 col-md-4">

                                <div class="user-profile-header mt-3 text-center card">

                                

                                <img src="<?= IMGS_URL.@$user_details->photo; ?>" alt="<?= @$user_details->fname; ?>" onerror="this.src='<?= base_url('uploads/photo/users/1.png'); ?>'" class="img-fluid" style="height:290px;width:100%" />

                                <h4 class="fw-500 mb-0" > <?= @$user_details->fname.' '.@$user_details->lname; ?> </h4>

                                <span class="fw-400 text-brand mb-10">( <?= @$user_details->mobile; ?> )</span>

                                <span class="fw-400 text-brand mb-10">( <?= @$user_details->email; ?> )</span>

                            </div>

                                    <div class="myaccount-tab-menu nav" role="tablist">

                                        <a  class="nav-link active" data-url="<?= base_url('user/users/profile/') ?>"  href="javascript:void(0)">Profile</a>

                                        <a data-url="<?= base_url('user/users/address/') ?>"  href="javascript:void(0)" class="nav-link">My Address</a>

                                        <a data-url="<?= base_url('user/users/order/') ?>"  href="javascript:void(0)" class="nav-link">Orders</a>

                                        <a data-url="<?= base_url('user/users/change_password/') ?>"  href="javascript:void(0)" class="nav-link" >Change Password</a>

                                        <a  href="<?= base_url('logout') ?>">Logout</a>

                                    </div>

                                </div>

                                <!-- My Account Tab Menu End -->

                                <!-- My Account Tab Content Start -->

                                <div class="col-lg-8 col-md-8">

                                <div class="tab-content dashboard-content">

                                        

                                        </div>

                                </div> <!-- My Account Tab Content End -->

                            </div>

                        </div> <!-- My Account Page End -->

                    </div>

                </div>

            </div>

        </div>



        <script type="text/javascript">

    $(document).ready(function(){

        let page_url = $('input[name=page_url]').val();

        $('.dashboard-content').load(page_url);



        $('body').on('click', '.nav-link', function(){

            $('.nav-link').removeClass('active');

            $(this).addClass('active');

            let page_url = $(this).data('url');

            alert

            $('.dashboard-content').load(page_url);

        });

    });

</script>