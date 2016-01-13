<?php
class Album extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("album_model");
		$this->load->helper("url_helper");
	}

	public function index()
	{
		$data["parent_albums"] = $this->album_model->get_all_parent_albums();
		$this->load->view("admin/album_list", $data);
	}	

	public function view_all_parents()
	{
		$data["parent_albums"] = $this->album_model->get_all_parent_albums();
		$this->load->view("admin/album_list", $data);
	}
}