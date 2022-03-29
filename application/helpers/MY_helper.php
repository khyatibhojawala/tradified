<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_parent_categories($parent_id = 0, $prefix = '')
{
	$CI =& get_instance();
	$list = '';
	$CI->db->select('*');
	$CI->db->from('categories');
	$CI->db->where('parent_category_id', $parent_id);
	$parent_categories = $CI->db->get()->result_array();

	if (count($parent_categories) > 0) {
        foreach ($parent_categories as $category) {
            $list .="<option value='".$category['id']."'>" . $prefix . $category['category_name'] ."</option>" . "\n";
            // Append sub-categories
            $list .= get_parent_categories($category['id'], $prefix . '-');
        }
    }
	return $list;
}

function get_count_subcategories($parent_id)
{
	$CI =& get_instance();
	$list = '';
	$CI->db->select('*');
	$CI->db->from('categories');
	$CI->db->where('parent_category_id', $parent_id);
	$parent_categories = $CI->db->get()->result_array();
	return count($parent_categories);
}