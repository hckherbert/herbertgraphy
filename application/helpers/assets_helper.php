<?php
/**
 * Created by PhpStorm.
 * User: Nick Shek
 * Date: 12/2/2016
 * Time: 4:38 PM
 */

if (!function_exists('javascript')) {
    function js($path)
    {
        $ci_instance =& get_instance();
        $ci_instance->config->load("assets");

        $js_path = $ci_instance->config->item("js_path");

        $base_assets_path = $ci_instance->config->item("base_assets_path");

        if (array_key_exists($path, $js_path)) {
            if ($base_assets_path) {
                return base_url($base_assets_path . "/js/" . $js_path[$path]);
            } else {
                return base_url("/js/" . $js_path[$path]);
            }
        } else {
            if ($base_assets_path) {
                return base_url($base_assets_path . "/js/" . $path);
            } else {
                return base_url("/js/" . $path);
            }
        }
    }
}

if (!function_exists('css')) {
    function css($path)
    {
        $ci_instance =& get_instance();
        $ci_instance->config->load("assets");

        $css_path = $ci_instance->config->item("css_path");

        $base_assets_path = $ci_instance->config->item("base_assets_path");

        if (array_key_exists($path, $css_path)) {
            if ($base_assets_path) {
                return base_url($base_assets_path . "/css/" . $css_path[$path]);
            } else {
                return base_url("/css/" . $css_path[$path]);
            }
        } else {
            if ($base_assets_path) {
                return base_url($base_assets_path . "/css/" . $path);
            } else {
                return base_url("/css/" . $path);
            }
        }
    }
}

if (!function_exists('css_source')) {
    function css_source($path)
    {
        $full_path = FCPATH . "assets/css/" . $path;

        if (!file_exists($full_path)) {
            log_message("error", "file $full_path does not exists!");
            if (ENVIRONMENT === "development") {
                throw new Exception("file $full_path does not exists!");
            } else {
                return "";
            }
        }

        return file_get_contents($full_path);
    }
}

if (!function_exists('js_source')) {
    function js_source($path)
    {
        $full_path = FCPATH . "assets/js/" . $path;

        if (!file_exists($full_path)) {
            log_message("error", "file $full_path does not exists!");
            if (ENVIRONMENT === "development") {
                throw new Exception("file $full_path does not exists!");
            } else {
                return "";
            }
        }

        return file_get_contents(FCPATH . "assets/js/" . $path);
    }
}

if (!function_exists('assets_image')) {
    function assets_image($path)
    {
        return base_url(sprintf(join("/", array(
            "public",
            "images",
            $path
        ))));
    }
}