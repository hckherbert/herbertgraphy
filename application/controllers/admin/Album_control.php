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
		//Validation is called once by ajax, before adding album
		/*
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
			$post_data = $this->input->post(NULL, TRUE);
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
		*/

		$post_data = $this->input->post(NULL, TRUE);
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

	public  function validate_add_album()
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
		$uploadDir = '/photos/';

// Set the allowed file extensions



		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile   = $_FILES['Filedata']['tmp_name'];
			$uploadDir  = FCPATH . 'assets/'.$uploadDir;
			$targetFile = $uploadDir . $_FILES['Filedata']['name'];

			// Validate the filetype
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

				// Save the file
				if (move_uploaded_file($tempFile, $targetFile))
				{

					list($width, $height) = getimagesize($targetFile);

					$this->load->library('image_lib');

					if ($width >= 1680 || $height >= 1680)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "1680";
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
						$config['source_image'] = $targetFile;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "1280";
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
						$config['source_image'] = $targetFile;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = "800";
						$config['width'] = 800;
						$config['height'] = 800;
						$config['quality'] = '100%';

						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}

					echo 1;
				}
				else
				{
					echo "can't move file";
				}

			} else {

				// The file type wasn't allowed
				echo 'Invalid file type.';

			}
		}
	}

}