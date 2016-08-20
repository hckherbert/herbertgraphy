<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/20/2016
 * Time: 9:45 AM
 */
class MY_Loader extends CI_Loader
{
    public function template_client($main_view_name, $template_name = "basic", $data = array())
    {
        if ($template_name == "basic")
        {
            $data["is_base"] = true;

            $js_includes = array(
                "base.js"
            );

            if ($main_view_name == "base")
            {
                $data["main_content_path"] = "client/base/main";
            }
            else if ($main_view_name == "home")
            {
                $js_includes[] = "home.js";
                $data["main_content_path"] = "client/home/main";
            }
            else if ($main_view_name == "about")
            {
                $data["main_content_path"] = "client/about/main";
                $data["section"] = "section_about";
            }

            $data["js_includes"] = $js_includes;
            $data["class_main_color"] = "bgBase";

            $this->view("client/templates/common_include", $data);
            $this->view("client/base", $data);
            $this->view("client/templates/footer", $data);
        }
        else if ($template_name == "album")
        {
            $data["class_main_color"] = "bgBrown";
            
            $this->view("client/templates/common_include", $data);
            $this->view("client/templates/partials/album_include", $data);
            $this->view("client/album", $data);
            $this->view("client/templates/footer", $data);
        }

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