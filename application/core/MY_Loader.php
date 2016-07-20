<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/20/2016
 * Time: 9:45 AM
 */
class MY_Loader extends CI_Loader
{
    public function template_client($main_view_name, $data = array())
    {
        $this->view("templates/header", $data);
        $this->view($main_view_name, $data);
        $this->view("templates/footer", $data);
    }

    public function template_admin($main_view_name, $data = array())
    {
        $this->view("admin/templates/common_include", $data);
        $this->view($main_view_name, $data);
    }

    public function partials($partial, $data = array())
    {
        $this->view($partial, $data);
    }
}