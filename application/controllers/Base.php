<?php

class Base extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("album_model");
        $this->load->model("photo_model");
    }

    public function index()
    {
        $all_parent_albums = $this->album_model->get_all_parent_albums();
        $data["all_parent_albums"] = $all_parent_albums;
        $data["main_title"] = "Herbertgraphy";
        $this->load->template_client("base", "basic", $data);

    }
}