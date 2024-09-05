<div class="breadcrumb-area breadcrumb-area-padding-2 bg-gray-2">
            <div class="custom-container">
                <div class="breadcrumb-content text-center">
                    <ul>
                        <li>
                            <a href="<?=base_url('dashboard');?>">Home</a>
                        </li>
                        <li class="active">Wishlist </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wishlist-area pt-75 pb-75">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <?php
                    $wishlist_data = wishlist_data();
                    if (empty($wishlist_data)) {
                        echo '<h3 class="text-center text-danger">Not Found Any Products</h3>';
                      }else{
                      ?>
                        <form action="#">
                            <div class="wishlist-table-content">
                                <div class="table-content table-responsive">
                                    <table class="table cart-table table-responsive-xs" id="wishlist-table">
                                    <thead>
                                    <tr class="table-head" align="center">
                                        <th scope="col">image</th>
                                        <th scope="col">product name</th>
                                        <th scope="col">availability</th>
                                        <th scope="col">action</th>
                                    </tr>
                                    </thead>
                                    <?php                        
                                    foreach ($wishlist_data as $row) {
                                        $product_id = $row->product_id;
                                        $wishlist_items = $this->product_model->wishlist_product_details($product_id);
                                ?>
                                        <tbody>
                                            <tr>
                                             
                                                <td class="wishlist-product-img">
                                                <a href="<?= base_url('product-detail/'.@$wishlist_items->id.'/'.@$wishlist_items->parent_cat_id.'/'.@$wishlist_items->parent_cat_id); ?>"><img src="<?php echo displayPhoto(@$wishlist_items->thumbnail); ?>" alt=""></a>
                                                </td>
                                                <td class="wishlist-product-info">
                                                <a href="#"><?=@$wishlist_items->name_portal; ?></a>
                                                </td>
                                                <td class="wishlist-product-add-wrap">
                                                <p><?= @$wishlist_items->qty == 0 ? 'out of stock' : 'in stock'; ?></p>
                                                    <div class="wishlist-product-add">
                                                    <div class="product-action-1">
                                                    <a id="cart_btn<?=@$wishlist_items->product_id?>" onclick="add_to_cart_by_btn(<?=@$wishlist_items->product_id?>,this)" href="javascript:void(0)" aria-label="Add To Cart"><i class="far fa-shopping-bag"></i> Add to cart</a>
                                                    </div>
                                                    </div>
                                                </td>
                                                <td class="wishlist-product-thumbnail">
                                                <a href="javascript:void(0)" class="icon me-3" onclick="remove_to_wishlist(this,<?= $product_id; ?>)"><i class="fas fa-trash"></i></a>
                                               <button class="btn quick-btn" onclick="openProductSidebar(<?= $product_id ?>)"><i class="ti-shopping-cart"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                        </form>
                         <?php } ?>
                    </div>
                </div>
            </div>
        </div>
