<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{
    public function get_category()
    {
        $query = $this->db->get_where('products_category', ['is_parent' => '0','is_deleted'=>'NOT_DELETED', 'active'=>1]);
        return $query->result();
    }
    public function get_user_category($user_group)
    {
        $query = $this->db->get_where('products_category', ['is_parent' => '0','is_deleted'=>'NOT_DELETED', 'active'=>1,'group_id'=>$user_group]);
        return $query->result();
    }
    
    public function get_categoryById($id)
    {
        $query = $this->db->get_where('products_category', ['is_parent' => $id,'is_deleted'=>'NOT_DELETED', 'active'=>1]);
        return $query->result();
    }
 
    public function get_random_category()
    {
        $query = $this->db->order_by('rand()')->limit(5,0)->get_where('products_category', ['is_parent' => '0','is_deleted'=>'NOT_DELETED','active'=>1]);
        // $query = $this->db->limit(5,0)->get_where('products_category', ['is_parent' => '0','is_deleted'=>'NOT_DELETED']);
        return $query->result();
    }
    
    public function get_subcategory()
    {
        $query = $this->db->get_where('products_category', ['is_parent !=' => '0','is_deleted'=>'NOT_DELETED', 'active'=>1]);
        return $query->result();
    }
    public function get_user_subcategory($user_group)
    {
        $query = $this->db->get_where('products_category', ['is_parent !=' => '0','is_deleted'=>'NOT_DELETED', 'active'=>1,'group_id'=>$user_group]);
        return $query->result();
    }
	public function sub_categories_by_id($id)
	{
		$this->db->select('t1.*')
        ->from('products_category t1')
		->where(['t1.is_deleted'=>'NOT_DELETED','t1.is_parent' =>$id]);
		return $this->db->get()->result();

	}
    public function get_map_products($pid)
    {
        $query = $this->db

        ->select('t1.id as pm_id,t2.name as product_name,t2.product_code,t2.id as pid,t3.img')
        ->from('products_mapping t1')                                         
        ->join('products_subcategory t2', 't2.id = t1.map_pro_id','left')                          
        ->join('products_photo t3', 't3.item_id = t2.id AND t3.is_cover = 1','left')   
        ->where('t1.pro_id' , $pid)
        ->get();
        return $query->result();
    }

    public function product_detail($inventory_id){
        return $this->db->select('ps.*')
            ->from('shops_inventory si')
            ->join('products_subcategory ps', 'ps.id=si.product_id')
            ->where('si.id', $inventory_id)
            ->get()->row();
    }
}