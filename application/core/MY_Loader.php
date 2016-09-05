<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/20/2016
 * Time: 9:45 AM
 */
class MY_Loader extends CI_Loader
{
    public function template_client($main_view_name, $template_name = "base", $data = array())
    {

        if ($template_name == "base")
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
                $data["meta_tags"] = "client/".$main_view_name."/meta_tags";
                $data["main_content_path"] = "client/home/main";
                $js_includes[] = "home.js";
            }
            else if ($main_view_name == "about")
            {
                $data["main_content_path"] = "client/about/main";
                $data["section"] = "section_about";
                $data["meta_tags"] = "client/".$main_view_name."/meta_tags";
                $js_includes[] = "about.js";
            }
            else if ($main_view_name == "coming_soon")
            {
                $data["main_content_path"] = "client/coming_soon/main";
                $data["section"] = "section_coming_soon";
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
            $data["js_includes"] = array(
                "album.js"
            );

            $data["meta_tags"] = "client/".$template_name."/meta_tags";

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