<?php

class Featured extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->getInfoPanelBaseData();
        $data["main_title"] = "HerbertGraphy Featured";
        $this->load->template_client("featured", "horizontal", $data);
    }
}