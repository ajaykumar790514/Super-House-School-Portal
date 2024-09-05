<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Name</th>
      <th>Quantity</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <?php $qty = $total =0;foreach($bundle as $b): $qty=$qty+$b->pro_qty;$total=$total+$b->pro_price;?>
    <tr>
      <td>
        <div class="d-flex align-items-center">
          <img
              src="<?php echo displayPhoto($b->thumbnail); ?>"
              class="rounded-circle"
              alt=""
              style="width: 100px; height: 100px"
              />
          <div class="ms-3 ml-4">
            <p class="fw-bold mb-1"><?=$b->name_portal;?></p>
            <p class="text-muted mb-0"><?=$b->product_code;?></p>
          </div>
        </div>
      </td>
      <td>
            <p class="text-muted mb-0"><?=$b->pro_qty;?></p>
      </td>
      <td><b><?=$b->pro_price;?></b>
      </td>
     
    </tr>
    <?php endforeach;
    if($SubTotal==0 || $SubTotal== $total){?>
    <tr>
        <td align="left">Total</td>
        <td><b><?=$qty;?></b></td>
        <td><b class="text-danger"><?=$total;?></b></td>
    </tr>
    <?php }else{?>
        <tr>
        <td align="left">Total</td>
        <td><b><?=$qty;?></b></td>
        <td><del><?=$total;?></del>  <b class="text-danger"><?=bcdiv($total-$SubTotal, 1, 2);;?></b></td>
    </tr>
        <?php }?>
  </tbody>
</table>
