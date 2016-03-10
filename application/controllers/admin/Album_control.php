<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Album_control extends CI_Controller 
{

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
			$insert_id  = $this->album_model->add_album($post_data);

			$data= array(
				"insert_id" => $insert_id
			);

			JSONAPI::echo_json_successful_response($data, TRUE);
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

			JSONAPI::echo_json_successful_response($data, TRUE);
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

}