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
        $this->load->template_client("base", "basic");

    }
}