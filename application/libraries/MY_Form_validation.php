<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 3/4/2016
 * Time: 3:03 PM
 */
class MY_Form_validation extends CI_Form_validation
{
    protected $CI;

    function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
    }

    function is_edit_unique()
    {
        $this->CI->load->model("album_model");
        $this->CI->form_validation->set_message('is_edit_unique', "album label must be unique.");
        $is_unique = $this->CI->album_model->is_current_label_unique_against_others($this->CI->input->post("label"), $this->CI->input->post("id"));
        return $is_unique;
    }

    function label_char_format($pInput)
    {
        if (!preg_match("/^[a-zA-Z0-9-_]+$/", $pInput))
        {
            $this->CI->form_validation->set_message("label_char_format", 'Album label should only contain letters, numbers or hyphens');
            return FALSE;
        }

        else
        {
            return TRUE;
        }
    }
}
