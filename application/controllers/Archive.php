<?php
/**
 * Created by PhpStorm.
 * User: herbert
 * Date: 7/9/2016
 * Time: 3:21 PM
 */
class Archive extends CI_Controller
{
    function _remap($param)
    {
        $this->index($param);
    }

    public function index($album_label = NULL)
    {

        if ($album_label != Null)
        {
            redirect("http://www.herbertgraphy.com/archive/".$album_label.".php");
        }
        redirect("http://www.herbertgraphy.com/archive/index.php");
    }




}