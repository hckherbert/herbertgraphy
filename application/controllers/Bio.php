<?php

class Bio extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->getInfoPanelBaseData();
        $data["main_title"] = "Bio";
        $this->load->template_client("about", "base", $data);
    }
}