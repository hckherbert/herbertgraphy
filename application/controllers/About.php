<?php

class About extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->getInfoPanelBaseData();
        $data["main_title"] = "Know <em>Her</em>";
        $this->load->template_client("about", "basic", $data);
    }
}