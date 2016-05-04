<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Album_control extends CI_Controller 
{
	private $config_validation_add_album;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("album_model");
		$this->load->helper("url_helper");
		$this->load->helper('security');
		$this->load->helper('form');
		$this->load->library("JSONAPI");
		$this->load->library("JSONAPIEnum");
		$this->load->library("form_validation");

		$this->config_validation_add_album =  array(
			array(
				'field'   => 'name',
				'label'   => 'Album name',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'label',
				'label'   => 'Album label',
				'rules'   => 'trim|required|is_unique[album.label]|label_char_format'
			)
		);
	}

	public function index()
	{
		$this->load->view("admin/album_list");
	}

	public function get_all_parent_albums()
	{
		$data = $this->album_model->get_all_parent_albums();

		if ($data)
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}
	
	public function update_album_list()
	{
		$del_ids = $this->input->post("del_id[]");
		$album_ids = $this->input->post("id");
		$is_query_success = true;

		if ($del_ids === NULL)
		{
			for ($i = 0; $i < count($album_ids); $i++)
			{
				if (!$this->album_model->update_album_order($album_ids[$i], $i))
				{
					$is_query_success = false;
				}
			}
		}
		else
		{

			if (!$this->album_model->delete_albums_and_reoder($del_ids, $album_ids))
			{
				$is_query_success = false;
			}
		}

		if ($is_query_success)
		{
			JSONAPI::echo_json_successful_response(NULL, FALSE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function add_album()
	{
		$post_data = $this->input->post(NULL, TRUE);
		$post_data["label"] =  strtolower($post_data["label"]);
		$insert_id  = $this->album_model->add_album($post_data);

		$data= array(
			"insert_id" => $insert_id
		);

		if ($insert_id)
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}

	}

	public function validate_add_album()
	{
		$this->form_validation->set_rules($this->config_validation_add_album);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
				"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			JSONAPI::echo_json_successful_response();
		}
	}


	public function add_subalbum()
	{
		$config_validation = array(
				array(
						'field'   => 'name',
						'label'   => 'Album name',
						'rules'   => 'trim|required'
				),
				array(
						'field'   => 'label',
						'label'   => 'Album label',
						'rules'   => 'trim|required|is_unique[album.label]|label_char_format'
				)
		);

		$this->form_validation->set_rules($config_validation);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
					"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			$post_data = $this->input->post(NULL, TRUE);
			$post_data["label"] =  strtolower($post_data["label"]);
			$insert_id  = $this->album_model->add_subalbum($post_data);

			$data= array(
				"insert_id" => $insert_id
			);

			if ($insert_id)
			{
				JSONAPI::echo_json_successful_response($data, TRUE);
			}
			else
			{
				JSONAPI::echo_json_error_response();
			}
		}
	}

	public function update_album_info()
	{
		$config_validation = array(
			array(
				'field'   => 'name',
				'label'   => 'Album name',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'label',
				'label'   => 'Album label',
				'rules'   => 'trim|required|is_edit_unique|label_char_format'
			)
		);

		$this->form_validation->set_rules($config_validation);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
				"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			$post_data = $this->input->post(NULL, TRUE);
			$post_data["label"] =  strtolower($post_data["label"]);
			$result =  $this->album_model->update_album_info($post_data);

			if ($result)
			{
				JSONAPI::echo_json_successful_response();
			}
			else
			{
				JSONAPI::echo_json_error_response();
			}
		}
	}


	public function album_details($pAlbum_id)
	{
		$data= $this->album_model->get_album_details($pAlbum_id);

		if ($data["album_details"]=== NULL)
		{
			show_404();

		}

		$this->load->view("admin/album_details", $data);
	}

	public function delete_album()
	{

		$del_id = $this->input->post("id");
		$album_id =  $this->input->post("order");
		$parent_id =  $this->input->post("parentId");

		$result =  $this->album_model->delete_single_album($del_id, $album_id, $parent_id);

		if ($result)
		{
			JSONAPI::echo_json_successful_response();
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function get_subalbum_list($pAlbum_id)
	{
		$data= $this->album_model->get_sub_album_by_parent_id($pAlbum_id);

		if ($data!== FALSE)
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function check_exist()
	{
		if (file_exists(FCPATH .'/assets/photos/' . $_POST['filename'])) {
			echo 1;
		} else {
			echo 0;
		}

	}

	public function upload()
	{

		$upload_base_dir = FCPATH."/assets/photos/";

		if ($_POST["album_label"])
		{
			$uploadDir = $upload_base_dir.strtolower($_POST["album_label"]."/");

			if (!file_exists($uploadDir))
			{
				if (!mkdir($uploadDir, 0777, true))
				{
					JSONAPI::echo_json_error_response("CANNOT_CREATE_UPLOAD_DIRECTORY");
				}
			}

		}
		else
		{
			JSONAPI::echo_json_error_response("NO_UPLOAD_DIRECTORY_SPECIFIED");
		}

		$photo_user_data = json_decode($_POST["photo_user_data"], true);
		$fileTypes = array('jpg', 'gif', 'png');
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken &&$photo_user_data )
		{
			$post_data_index = -1;
			$slug_filename = "";
			$desc = "";
			$title = "";

			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$extension = strtolower($fileParts['extension']);
			$tempFile   = $_FILES['Filedata']['tmp_name'];


			foreach($photo_user_data["original_filename"] as $index=>$value)
			{
				if ($value ==  $_FILES['Filedata']['name'])
				{
					$post_data_index = $index;
				}
			}


			if ($photo_user_data["new_filename"][$post_data_index] == "")
			{
				$slug_filename_only =  pathinfo($_FILES['Filedata']['name'], PATHINFO_FILENAME);
				$slug_filename_only = preg_replace('/\s+/', '-', $slug_filename_only);
				$slug_filename_only = strtolower($slug_filename_only);
				$slug_filename = $slug_filename_only.".".$extension;
			}
			else
			{
				$slug_filename_only = $photo_user_data["new_filename"][$post_data_index];
				$slug_filename_only = strtolower($slug_filename_only);
				$slug_filename = $slug_filename_only.".".$extension;
			}

			$desc = $photo_user_data["desc"][$post_data_index];
			$title = $photo_user_data["title"][$post_data_index];
			$hash = hash("sha256", $slug_filename .time()."herbertgraphyalbumadmin");
			$hash_filename = $slug_filename_only ."-".$hash.".".$extension;
			$target_file = $uploadDir.$hash_filename;

			if (in_array($extension, $fileTypes)) {

				// Save the file
				if (move_uploaded_file($tempFile, $target_file))
				{
					list($width, $height) = getimagesize($target_file);

					$this->load->library('image_lib');

					if ($width >= 1680 || $height >= 1680)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = $target_file;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "_1680";
						$config['width'] = 1680;
						$config['height'] = 1680;
						$config['quality'] = '100%';

						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}

					if ($width >= 1280 || $height >= 1280)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = $target_file;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "_1280";
						$config['width'] = 1280;
						$config['height'] = 1280;
						$config['quality'] = '100%';

						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}


					if ($width >= 800 || $height >= 800)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = $target_file;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "_800";
						$config['width'] = 800;
						$config['height'] = 800;
						$config['quality'] = '100%';

						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}

					JSONAPI::echo_json_successful_response();
				}
				else
				{

					JSONAPI::echo_json_error_response("CANNOT_MOVE_FILE");
				}

				$data = array(
					"albumId" => 0,
					"slug_filename" => $slug_filename,
					"hash_filename" => $hash_filename,
					"title" => $title,
					"desc" => $desc,
					"create_date" => date('Y-m-d H:i:s')
				);

				$this->album_model->add_uploaded_file_records($data);

			} else {

				JSONAPI::echo_json_error_response("INVALID_FILE_TYPE");

			}
		}
	}

	public  function remove_failed_uploads()
	{

	}

}