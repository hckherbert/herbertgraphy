<?php

class About extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->template_client("about", "basic");
    }
}