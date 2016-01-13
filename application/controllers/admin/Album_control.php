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
		$data["parent_albums"] = $this->album_model->get_all_parent_albums();
		$this->load->view("admin/album_list", $data);
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
			if (!$this->album_model->delete_albums($del_ids, $album_ids))
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
			JSONAPI::echo_json_error_response(NULL, FALSE);
		}
	}

	public function add_album()
	{
		$config_validation = array(
			array(
				'field'   => 'name',
				'label'   => 'Album name',
				'rules'   => 'trim|required|is_unique[album.name]'
			),
			array(
				'field'   => 'label',
				'label'   => 'Album label',
				'rules'   => 'trim|required|is_unique[album.label]|callback_is_validate_album_label'
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


	public function is_validate_album_label($pInput)
	{
		if (!preg_match("/^[a-zA-Z0-9-]+$/", $pInput))
		{
			$this->form_validation->set_message("is_validate_album_label", 'Album label should only contain letters, numbers or hyphens');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}