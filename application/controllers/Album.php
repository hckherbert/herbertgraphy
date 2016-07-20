<?php

class Album extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("album_model");
		$this->load->model("photo_model");
	}


	function _remap($param)
	{
		$this->index($param);
	}
 

	public function index($album_label = NULL)
	{
		$data = array();
		$album_label = trim(strtolower($album_label));
		$album_id = $this->album_model->get_album_id($album_label);

		if ($album_id === FALSE)
		{
			show_404();
		}
		
		$parent_id = $this->album_model->get_parent_album_id($album_id);
	
		$data["current_album_data"] = $this->album_model->get_album_details($album_id);
		$data["all_other_albums_data"] = $this->get_all_other_albums_data($data["current_album_data"]["album_details"]->label, $parent_id);
		$data["subalbum_data"] = $this->get_sub_albums($album_id);
		$this->load->template_client("album", "album", $data);

	}
	
	private function get_all_other_albums_data($current_album_label, $parent_id)
	{
		$data = $this->album_model->get_all_parent_albums();

		$data = array_map(function($input_array)use ($current_album_label, $parent_id)
		{
		   if ($current_album_label !=  $input_array["label"])
		   {
			   $output["label"] = $input_array["label"];
			   $output["name"] = $input_array["name"];
			   $output["siblings"] = NULL;
			  
			   if ($parent_id !== NULL && $input_array["id"] == $parent_id)
			   {
					$output["siblings"] = $this->get_sub_albums($parent_id);
			   }
			   
			   return $output;
		   }

		}, $data);


		$data = array_filter($data, function($key)
		{
			return $key!= NULL;
		});

		return $data;
	}

	private function get_sub_albums($album_id)
	{
		$data = $this->album_model->get_sub_album_by_parent_id($album_id);
		$data = array_map(function($input_array)
		{
			$output["label"] = $input_array["label"];
			$output["name"] = $input_array["name"];
			return $output;
		}, $data);

		return $data;

	}
}
