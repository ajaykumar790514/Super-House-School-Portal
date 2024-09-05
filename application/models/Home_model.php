<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    
    public function get_new_in($val)
    {
        $this->db->select('*');
        $this->db->from('products_category');
        if($val=='women')
            $this->db->where(['new_in_women'=>'1','is_deleted'=>'not_deleted','active'=>'1']);
        if($val=='men')
            $this->db->where(['new_in_men'=>'1','is_deleted'=>'not_deleted','active'=>'1']);
        if($val=='kids')
            $this->db->where(['new_in_kids'=>'1','is_deleted'=>'not_deleted','active'=>'1']);
        return $this->db->get()->result();
    }
    
	public function get_banners($shop_id)
	{
		$query = $this->db->order_by('seq','asc')->select('*')->get_where('home_banners', ['is_deleted' => 'NOT_DELETED', 'shop_id' => $shop_id, 'banner_type' => '1', 'active' => '1']);
		return $query->result();
	}
	public function get_other_banners($shop_id)
	{
		$query = $this->db->order_by('seq','asc')->limit(10,0)->get_where('home_banners', ['is_deleted' => 'NOT_DELETED', 'shop_id' => $shop_id, 'banner_type' => '0', 'active' => '1']);
		return $query->result();
	}
	public function get_top_banners($shop_id)
	{
		$query = $this->db->order_by('seq','asc')->limit(10,0)->get_where('home_banners', ['is_deleted' => 'NOT_DELETED', 'shop_id' => $shop_id, 'banner_type' => '1', 'active' => '1']);
		return $query->result();
	}
	public function getHeaderCatMap($header_id)
	{
		$query = $this->db->select('t2.*')
		->from('home_headers_mapping t1')
		->join('products_category t2 ','t2.is_parent=t1.value')
		->where(['t1.header_id'=>$header_id,'t2.active'=>'1','t2.is_deleted' => 'NOT_DELETED']) ;
		return $this->db->get()->result();
	}
	public function get_top_one_banners($shop_id)
	{
		$query = $this->db->order_by('seq','asc')->limit(10,0)->get_where('home_banners', ['is_deleted' => 'NOT_DELETED', 'shop_id' => $shop_id, 'banner_type' => '1', 'active' => '1']);
		return $query->row();
	}
	public function get_states()
	{
		$query = $this->db->order_by('name','asc')->select('*')->get_where('states', ['is_deleted' => 'NOT_DELETED']);
		return $query->result();
	}
	
	public function check_cart_product_existence($user_id, $pid)
	{
		$query = $this->db->get_where('cart', ['user_id' => $user_id, 'product_id' => $pid]);
		return $query->result();
	}
	public function get_header_title($shop_id)
	{
		$query = $this->db->select('t1.*')
		->from('home_headers t1')
		->where(['t1.type' => '1','t1.shop_id'=>$shop_id,'t1.status'=>'1','t1.is_deleted' => 'NOT_DELETED'])->order_by('t1.seq','asc') ;
		return $this->db->get()->result();
	}
    
    public function get_category_header_title($shop_id)
    {
        $query = $this->db->select('t1.*')
		->from('home_headers t1')
		->where(['t1.type' => '2','t1.shop_id'=>$shop_id,'t1.status'=>'1','t1.is_deleted' => 'NOT_DELETED']) ;
		return $this->db->get()->result();
    }

	public function get_header_products($shop_id,$header_id,$class_id,$group)
	{
        $query = $this->db
		->select('t1.id as header_id, t1.*, t3.*, t3.id as product_id, t3.name as product_name, t3.name as product_name, t4.thumbnail, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t8.product_id as wislist_pid,t10.name as cat_name, t9.is_parent, t9.id as cat_id, t11.cat_id as category_id,t3.flag as ProductFlag')
		->from('home_headers_mapping t1')      
		->join('products_subcategory t3', 't3.id = t1.value','left')        
		->join('products_photo t4', 't4.item_id = t3.id  AND t4.is_cover="1"  ','left')  
		->join('shops_inventory t5', 't3.id=t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"','left')
		->join('shops_coupons_offers t6', 't3.id=t6.product_id','left')
		->join('product_flags t7', 't3.id=t7.product_id','left')
		->join('wishlist t8', 't8.product_id=t3.id','left')
		->join('products_category t9', 't9.id=t3.parent_cat_id','left')        
        ->join('cat_pro_maps t11', 't11.pro_id=t1.value','left')
        ->join('class_pro_maps t12', 't12.pro_id=t3.id','left')
        ->join('products_category t10', 't10.id=t11.cat_id','left')
		->where(['t3.is_deleted'=>'NOT_DELETED','t3.active'=>'1','t1.header_id'=>$header_id,'t12.class'=>$class_id,'t10.group_id'=>$group]) 
		->group_start()
		->where('t5.mrp >', 0.00)
		->or_where('t5.selling_rate >', 0.00)
	    ->group_end()  
		->group_by('t11.pro_id')   
		->limit(10,0);
		$results = $this->db->get()->result_array();
		$return = array();
		foreach($results as $result):
		if($result['ProductFlag']=='bundle'){
		  $product_id= $result['product_id'];
		 $bundle =  $this->getBundleProduct($product_id);
		 if(!empty($bundle)){
			$return=$results;
		 }
		}
		endforeach;	

	 return $return;
		// return $this->db->get()->result_array();
	}

	public function get_header_products_class($shop_id, $group, $class)
	{
		$query = $this->db
			->select('t2.id as class_id, t2.*, t3.*, t3.id as product_id, t3.name as product_name, t4.thumbnail, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t8.product_id as wislist_pid, t10.name as cat_name, t9.is_parent, t9.id as cat_id, t11.cat_id as category_id ,t3.flag as ProductFlag')
			->from('class_pro_maps t1')
			->join('class_master t2', 't2.id = t1.class', 'left')
			->join('products_subcategory t3', 't1.pro_id = t3.id', 'left')
			->join('products_photo t4', 't4.item_id = t3.id AND t4.is_cover="1"', 'left')
			->join('shops_inventory t5', 't3.id = t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"', 'left')
			->join('shops_coupons_offers t6', 't3.id = t6.product_id', 'left')
			->join('product_flags t7', 't3.id = t7.product_id', 'left')
			->join('wishlist t8', 't8.product_id = t3.id', 'left')
			->join('products_category t9', 't9.id = t3.parent_cat_id', 'left')
			->join('cat_pro_maps t11', 't11.pro_id = t3.id', 'left')
			->join('products_category t10', 't10.id = t11.cat_id', 'left')
			->where(['t3.is_deleted' => 'NOT_DELETED', 't3.active' => '1',  't1.class' => $class,'t10.group_id'=>$group])
			->group_start()
			->where('t5.mrp >', 0.00)
			->or_where('t5.selling_rate >', 0.00)
			->group_end() 
			->group_by('t11.pro_id')
			->order_by('RAND()') // Order by random
			->limit(20); // Limit to 20 records
			$results = $this->db->get()->result_array();
			$return = array();
			foreach($results as $result):
            if($result['ProductFlag']=='bundle'){
              $product_id= $result['product_id'];
			 $bundle =  $this->getBundleProduct($product_id);
			 if(!empty($bundle)){
				$return=$results;
			 }
			}
			endforeach;	
	
		 return $return;
	}
	public function getBundleProduct($id)

    {

        $this->db

        ->select('t2.*,t2.id as prod_id,t1.mrp,t1.amount,t1.qty')

        ->from('bundle_products_mapping t1')  

         ->join('products_subcategory t2', 't2.id=t1.pro_id ','left')

        ->where(['t2.is_deleted' => 'NOT_DELETED','t2.bundle_active_inactive'=>'1','t1.bundle_id' => $id]);

        return $this->db->get()->result();

    }
	
    public function check_admission_exists($admission,$school_id) {
        $query = $this->db->get_where('customers', array('admission_no' => $admission,'school_id'=>$school_id));
        return $query->num_rows() > 0;
    }
	// public function check_admission_exists($admission, $school_id) {
    //     // Assuming your table name is 'students'
    //     $this->db->where('admission_number', $admission);
    //     $this->db->where('school_id', $school_id);
    //     $query = $this->db->get('students'); // Update 'students' with your actual table name

    //     return $query->num_rows() > 0;
    // }

	public function get_featured_products($pro_id)
	{
        $query = $this->db
		->select('t3.*, t3.id as product_id, t3.name as product_name, t3.name as product_name, t4.thumbnail, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t8.product_id as wislist_pid,t10.name as cat_name, t9.is_parent, t9.id as cat_id, t11.cat_id as category_id, t12.name as flavour_name')
		->from('products_subcategory t3')      
		->join('products_photo t4', 't4.item_id = t3.id','left')  
		->join('shops_inventory t5', 't3.id=t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"','left')
		->join('shops_coupons_offers t6', 't3.id=t6.product_id','left')
		->join('product_flags t7', 't3.id=t7.product_id','left')
		->join('wishlist t8', 't8.product_id=t3.id','left')
		->join('products_category t9', 't9.id=t3.parent_cat_id','left')
		->join('cat_pro_maps t11', 't11.pro_id=t3.id','left')
        ->join('products_category t10', 't10.id=t11.cat_id','left')
        ->join('flavour_master t12', 't12.id = t3.flavour_id AND t12.is_deleted="NOT_DELETED" AND t12.active="1"','left')
        //->join('cat_pro_maps t11', 't11.cat_id='.$cat_id,'left')
		->where(['t4.is_cover' =>'1','t3.is_deleted'=>'NOT_DELETED','t3.active'=>'1'])   
		->where_in('t3.id', $pro_id)   
		->group_by('t11.pro_id')   
		->limit(9,0);
		return $this->db->get()->result_array();
	}

	public function get_product_by_id($pid)
	{
        $query = $this->db
		->select('t3.*, t3.id as product_id, t3.name as product_name, t3.name as product_name, t4.thumbnail, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t8.product_id as wislist_pid,t10.name as cat_name, t9.is_parent, t9.id as cat_id')
		->from('products_subcategory t3')      
		->join('products_photo t4', 't4.item_id = t3.id','left')  
		->join('shops_inventory t5', 't3.id=t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"','left')
		->join('shops_coupons_offers t6', 't3.id=t6.product_id','left')
		->join('product_flags t7', 't3.id=t7.product_id','left')
		->join('wishlist t8', 't8.product_id=t3.id','left')
		->join('products_category t9', 't9.id=t3.parent_cat_id','left')
        ->join('products_category t10', 't10.id=t9.is_parent','left')
       // ->join('flavour_master t11', 't11.id = t3.flavour_id AND t11.is_deleted="NOT_DELETED" AND t11.active="1"','left')
		->where(['t4.is_cover' =>'1','t3.id'=>$pid]);
		return $this->db->get()->result_array();
	}
    
    public function get_header_categories($shop_id,$header_id)
    {
        $this->db->select('t4.*, t4.id as product_id, t4.name as product_name, t4.name as product_name, t5.thumbnail, t6.id as inventory_id, t6.mrp, t6.selling_rate, t6.qty as product_qty, t7.offer_upto, t7.discount_type, t8.is_featured, t9.product_id as wislist_pid, t3.is_parent, t3.id as cat_id , t3.icon as cat_icon,t11.name as cat_name')
        ->from('home_headers_mapping t1') 
        ->join('products_category t3', 't3.is_parent = t1.value','left')   
        ->join('products_subcategory t4', 't4.parent_cat_id = t3.id','left')
        ->join('products_photo t5', 't5.item_id = t4.id','left')  
		->join('shops_inventory t6', 't4.id=t6.product_id AND t6.is_deleted="NOT_DELETED" AND t6.status="1"','left')
		->join('shops_coupons_offers t7', 't4.id=t7.product_id','left')
		->join('product_flags t8', 't4.id=t8.product_id','left')
		->join('wishlist t9', 't9.product_id=t4.id','left')
        ->join('products_category t10', 't10.id=t4.parent_cat_id','left')
        ->join('products_category t11', 't11.id=t10.is_parent','left')
        ->order_by("t4.added", "desc")    
        ->where(['t5.is_cover' =>'1','t4.is_deleted' =>'NOT_DELETED','t4.active'=>'1','t1.header_id'=>$header_id]) 
        ->limit(6,0);    
        return $this->db->get()->result_array();
     
        
    }
    
    public function get_header_newarrival_products($shop_id)
    {
        $query = $this->db
		->select('t3.*, t3.id as product_id, t3.name as product_name, t3.name as product_name, t4.thumbnail, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t8.product_id as wislist_pid, t9.is_parent, t9.id as cat_id')
		->from('products_subcategory t3')        
		->join('products_photo t4', 't4.item_id = t3.id','left')  
		->join('shops_inventory t5', 't3.id=t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"','left')
		->join('shops_coupons_offers t6', 't3.id=t6.product_id','left')
		->join('product_flags t7', 't3.id=t7.product_id','left')
		->join('wishlist t8', 't8.product_id=t3.id','left')
		->join('products_category t9', 't9.id=t3.parent_cat_id','left')
        ->order_by("t3.added", "desc")    
		->where(['t4.is_cover' =>'1','t3.is_deleted' =>'NOT_DELETED','t3.active'=>'1'])   
		->limit(10,0);
		return $this->db->get()->result_array();
    }

	//function to fetch all header products
	public function get_all_header_products($shop_id,$header_id)
	{
		$query = 
		$this->db
        ->select('t1.*, t2.id as header_id, t2.*, t3.*, t3.id as product_id, t3.name as product_name, t4.thumbnail, t4.img, t5.id as inventory_id, t5.mrp, t5.selling_rate, t5.qty as product_qty, t6.offer_upto, t6.discount_type, t7.is_featured, t1.title, t8.product_id as wislist_pid, t9.is_parent, t9.id as cat_id')
        ->from('home_headers t1')
        ->join('home_headers_mapping t2', 't2.header_id = t1.id','left')        
        ->join('products_subcategory t3', 't3.id = t2.value','left')        
		->join('products_photo t4', 't4.item_id = t3.id','left')  
		->join('shops_inventory t5', 't3.id=t5.product_id AND t5.is_deleted="NOT_DELETED" AND t5.status="1"','left')
		->join('shops_coupons_offers t6', 't3.id=t6.product_id','left')
		->join('product_flags t7', 't3.id=t7.product_id','left')
		->join('wishlist t8', 't8.product_id=t3.id','left')
		->join('products_category t9', 't9.id=t3.parent_cat_id','left')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id'=>$shop_id,'t1.type'=>'1','t1.status'=>'1','t4.is_cover' =>'1','t2.header_id'=>$header_id])  
		->get();
		// print_r($this->db->last_query());    
		return $query->result();
	}

    public function child_categories($shop_id)
    {
        $this->db
        ->select('t1.parent_cat_id,t2.name,t2.id as cat_id,t4.is_parent')
        ->from('products_subcategory t1')     
         ->join('products_category t2', 't2.id = t1.sub_cat_id')   
         ->join('shops_inventory t3', 't1.id=t3.product_id AND t3.is_deleted="NOT_DELETED" AND t3.status="1"','left')
         ->join('products_category t4', 't4.id = t1.parent_cat_id') 
         ->group_by('t2.id')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t3.shop_id' =>$shop_id]);   

        return $this->db->get()->result();
    }
	public function getBundleDetails($id)
    {
        $this->db
        ->select('t2.*,t3.*,t1.qty as pro_qty,t1.amount as pro_price,t4.thumbnail')
        ->from('bundle_products_mapping t1')     
         ->join('products_subcategory t2', 't2.id = t1.pro_id','left')   
         ->join('shops_inventory t3', 't2.id=t3.product_id AND t3.is_deleted="NOT_DELETED" AND t3.status="1"','left')
		 ->join('products_photo t4', 't4.item_id=t2.id AND t4.is_cover="1"','left')
        ->where(['t2.is_deleted' => 'NOT_DELETED','t2.bundle_active_inactive'=>'1','t1.bundle_id' =>$id]);   
      // echo $this->db->last_query();die();
        return $this->db->get()->result();
    }

	public function getBundleDetails_new($id,$oid)
    {
        $this->db
        ->select('t2.*,a.qty as pro_qty,a.selling_rate as pro_price,t4.thumbnail')
         ->from('order_items t1') 
		 ->join('order_bundle_items a', 'a.order_item_id = t1.id','left') 
         ->join('products_subcategory t2', 't2.id = a.product_id','left')  
		 ->join('products_photo t4', 't4.item_id=t2.id AND t4.is_cover="1"','left')
        ->where(['t2.is_deleted' => 'NOT_DELETED','t2.bundle_active_inactive'=>'1','t1.id' =>$oid]);  
      // echo $this->db->last_query();die();
        return $this->db->get()->result();
    }
	
	public function getProAllId($prourl)
	{
        $query = $this->db
		->select('.t1.id as pro_id,t4.level,t2.id as inventory_id,t3.cat_id as category_id,t4.is_parent as sub_cat_id,t4.is_parent')
		->from('products_subcategory t1')      
		->join('shops_inventory t2', 't1.id=t2.product_id AND t2.is_deleted="NOT_DELETED" AND t2.status="1"','left')
		->join('cat_pro_maps t3', 't3.pro_id=t1.id','left')
		->join('products_category t4', 't4.id=t3.cat_id','left')  
		->where(['t1.is_deleted'=>'NOT_DELETED','t1.active'=>'1','t1.url'=>$prourl]) ;
		return $this->db->get()->row();
	}
    public function get_shop_detail($shop_id)
    {
        $this->db
        ->select('t1.*,t2.*, t3.name as city_name,t4.name state_name')
        ->from('shops t1')     
        ->join('layout_settings t2', 't2.shop_id = t1.id','left')
        ->join('cities t3', 't3.id = t1.city','left')
		->join('states t4', 't4.id = t1.state','left')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id' =>$shop_id]);   

        return $this->db->get()->row();
    }

	function getRow($tb,$data=0) {

		if ($data==0) {
			if($data=$this->db->get($tb)->row()){
				return $data;
			}else {
				return false;
			}
		}elseif(is_array($data)) {
			if($data=$this->db->get_where($tb, $data)){
				return $data->row();
			}else {
				return false;
			}
		}else {
			if($data=$this->db->get_where($tb,array('id'=>$data))){
				return $data->row();
			}else {
				return false;
			}
		}

	}
	function getData($tb, $data = 0, $order = null, $order_by = null, $limit = null, $start = null)
    {

        if ($order != null) {
            if ($order_by != null) {
                $this->db->order_by($order_by, $order);
            } else {
                $this->db->order_by('id', $order);
            }
        }

        if ($limit != null) {
            $this->db->limit($limit, $start);
        }

        if ($data == 0 or $data == null) {
            return $this->db->get($tb)->result();
        }
        if (@$data['search']) {
            $search = $data['search'];
            unset($data['search']);
        }
        return $this->db->get_where($tb, $data)->result();
    }
    public function get_pincode($shop_id, $pincode){
    	$this->db
    	->select('t1.*')
        ->from('pincodes_criteria t1')     
        ->where(['t1.pincode' => $pincode,'t1.active' => 1,'t1.shop_id' =>$shop_id, 'is_deleted'=>'NOT_DELETED']);
        return $this->db->get()->result();
    }
    
    public function updateStatus($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('orders', ['status' => $data['status']]);
        return $this->db->affected_rows() > 0;
    }
	function SaveLog($data = array()){
		$result = $this->db->insert('order_status_log',$data);
		return $result;
	}

}
