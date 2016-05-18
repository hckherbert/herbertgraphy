<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 5/18/2016
 * Time: 9:36 AM
 */
class Photo_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add_uploaded_file_records($data)
    {
        $this->db->insert("photos", $data);
        return $this->db->insert_id();
    }

    public function get_photo_data($album_id)
    {
        $this->db->select("photoId,slug_filename,hash_filename,title,desc");
        $this->db->where("albumId", $album_id);
        $query = $this->db->get("photos");

        return $query->result_array();
    }
}