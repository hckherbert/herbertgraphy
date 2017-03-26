<?php

class Album extends MY_Common
{
	public function __construct()
	{
		parent::__construct();
	}

	public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		else
		{
			//$method is actually the album name; note that $params will be of type array.
			$this->index($method, $params);
		}
	}

	//public function index($album_label, $direct_photo_slug = NULL)
	public function index($method, $params)
	{
		$data = array();
		$album_label = trim(strtolower($method));

		if ($params)
		{
			$data["direct_photo_slug"] = trim(strtolower($params[0]));
		}

		$data["album_path"] = base_url()."album/".$method;
		$album_id = $this->album_model->get_album_id($album_label);

		if ($album_id === FALSE || count($params)>1)
		{
			$this->not_found();
			return;
		}

		$data["featured_photo"] = "";
		$parent_id = $this->album_model->get_parent_album_id($album_id);
		$data["current_album_data"] = $this->album_model->get_album_details($album_id);
		$data["subalbum_data"] = $this->get_sub_albums($album_id);
		$has_photos = count($data["current_album_data"]["photo_data"]) ? true : false;

		if (!$has_photos && count($data["subalbum_data"]))
		{
			redirect("/album/".$data["subalbum_data"][0]["label"]);
			return;
		}

		foreach ($data["current_album_data"]["photo_data"] as $photo)
		{
			if ($photo["featured"] == "1")
			{
				$data["featured_photo"]= base_url()."assets/photos/".$data["current_album_data"]["album_details"]->label."/".$photo["file_thumb_path"];
			}

			if (array_key_exists("direct_photo_slug", $data ))
			{
				if (strtolower($photo["slug_filename"]) == $data["direct_photo_slug"])
				{
					$data["direct_photo_path"]= base_url()."assets/photos/".$data["current_album_data"]["album_details"]->label."/".$photo["file_thumb_path"];
				}
			}

		}

		if ($data["featured_photo"] == "" && $has_photos)
		{
			$data["featured_photo"] = base_url()."assets/photos/".$data["current_album_data"]["album_details"]->label."/".$data["current_album_data"]["photo_data"][0]["file_thumb_path"];
		}

		$data["all_other_albums_data"] = $this->get_all_other_albums_data($data["current_album_data"]["album_details"]->label, $parent_id);

		if ($has_photos)
		{
			$this->load->template_client("album", "album", $data);
		}
		else
		{
			$this->load->template_client("coming_soon", "base", $data);
		}


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
