<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class categories extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('MY_helper');
        $this->load->model('category_model');
    }

	public function index()
	{
		$data['parent_categories'] = $this->category_model->get_parent_categories();
		$this->load->view('categories_listing', $data);
	}


	public function add_category()
	{
		if($this->input->post())
		{
			$data = array(
				'category_name' 		=>  $this->input->post('category_name'),
				'parent_category_id' 	=>  $this->input->post('parent_id'),
			);
			$result =  $this->db->insert('categories', $data);
			if($result)
			{
				$final['flag'] = true;
				$final['message'] = "Added Category Successfully";
			}
			else
			{
				$final['flag'] = false;
				$final['message'] = "Please try again";
			}
			echo json_encode($final);
			exit();
		}
		else
		{
			$this->load->view('add_category');
		}
	}


	public function get_child_categories()
	{
		$html = '';
		$parent_id = $this->input->post('parent_category_id');
		$child_categories = $this->category_model->get_child_categories($parent_id);
		if($child_categories)
		{	
			$html .= '<ul class="nested">';
			foreach ($child_categories as $category) 
			{
				$count = get_count_subcategories($category['id']);
		  		if($count > 0)
		  		{
		  			$html .= '<li class="category_'. $category['id'].'" data-id="'.$category['id'].'"><span class="caret">' . $category['category_name'] . '</span>';
		  		}
		  		else
		  		{
					$html .= '<li class="category_'. $category['id'].'" data-id="'.$category['id'].'">' . $category['category_name'];
		  		}
				$html .= '</li>';
			}
			$html .= '<ul>';
			$final['flag'] = true;
			$final['child_categories'] = $html;
		}
		else
		{
			$final['flag'] = true;
			$final['message'] = "No child categories";
		}
		echo json_encode($final);
		exit();
	} 
}
	