<?php
/**
 * Created by PhpStorm.
 * User: Nick Shek
 * Date: 12/2/2016
 * Time: 4:31 PM
 */
if (file_exists(FCPATH . "/public/css/rev-manifest.json")) {
    $css = file_get_contents(FCPATH . "/public/css/rev-manifest.json");
    $config["css_path"] = json_decode($css, true);
} else {
    $config["css_path"] = array();
}

if (file_exists(FCPATH . "/public/js/rev-manifest.json")) {
    $js = file_get_contents(FCPATH . "/public/js/rev-manifest.json");
    $config["js_path"] = json_decode($js, true);
} else {
    $config["js_path"] = array();
}

$config["base_assets_path"] = "public";