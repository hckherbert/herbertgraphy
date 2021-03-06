<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 8/8/2016
 * Time: 9:56 AM
 */

class MY_Common extends CI_Controller
{
    protected  $all_parent_albums;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("album_model");
        $this->load->model("photo_model");
        $this->all_parent_albums = $this->album_model->get_all_parent_albums();
    }

    public function getInfoPanelBaseData()
    {
        $data ["all_parent_albums"] = $this->all_parent_albums;
        return $data;
    }

    public function not_found()
    {
        $data["all_parent_albums"] = $this->all_parent_albums;

        $data["main_title"] = "Opps";

        $this->load->template_client("base", "base", $data);
        return;
    }
}