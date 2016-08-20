<?php

class About extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data["main_title"] = "All About HerbertGraphy";
        $this->load->template_client("about", "basic", $data);
    }
}