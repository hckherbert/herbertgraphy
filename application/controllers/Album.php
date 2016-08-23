<?php

class Album extends MY_Common
{
	public function __construct()
	{
		parent::__construct();
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
			$this->not_found();
			return;
		}

		$data["featured_photo"] = "";
		$parent_id = $this->album_model->get_parent_album_id($album_id);
		$data["current_album_data"] = $this->album_model->get_album_details($album_id);

		foreach ($data["current_album_data"]["photo_data"] as $photo)
		{
			if ($photo["featured"] == "1")
			{
				$data["featured_photo"]= base_url()."assets/photos/".$data["current_album_data"]["album_details"]->label."/".$photo["file_thumb_path"];
			}
		}

		if ($data["featured_photo"] == "")
		{
			$data["featured_photo"] = base_url()."assets/photos/".$data["current_album_data"]["album_details"]->label."/".$data["current_album_data"]["photo_data"][0]["file_thumb_path"];
		}

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

		$item_with_parent_and_siblings = array();

		foreach ($data as $key=>$value)
		{
			if ($data[$key]["siblings"]!=NULL)
			{
				$item_with_parent_and_siblings = $data[$key];
				unset($data[$key]);
			}
		}

		if (!empty($item_with_parent_and_siblings)) {
			array_unshift($data, $item_with_parent_and_siblings);
		}

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
