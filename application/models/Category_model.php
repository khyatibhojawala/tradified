<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    
    public function get_parent_categories()
    {
    	$this->db->select('*');
    	$this->db->from('categories');
    	$this->db->where('parent_category_id', 0);
    	$result = $this->db->get()->result_array();
        return $result;
    }


    public function get_child_categories($parent_category_id)
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('parent_category_id', $parent_category_id);
        $result = $this->db->get()->result_array();
        return $result;
    }
}
?>