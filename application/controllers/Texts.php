<?php

class Texts extends MY_Common
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->getInfoPanelBaseData();
        $data["main_title"] = "HerbertGraphy Featured";
        $photo_base_dir = FCPATH."/assets/images/featured/";
        $image_list_data = array();

        for ($i=0; $i<=11; $i++)
        {
            list($width, $height) = getimagesize($photo_base_dir.$i.".jpg");
            $image_data = array();
            $image_data["width"] = $width;
            $image_data["height"] = $height;
            $image_list_data[] = $image_data;
        }

        $data["image_list_data"] = $image_list_data;

        if (ENVIRONMENT == "dev_cp")
        {
            $data["main_title"] = "Test Texts";
        }
        else
        {
            $data["main_title"] = "Herbertgraphy Texts";
        }
        
        $this->load->template_client("featured", "horizontal", $data);
    }
}