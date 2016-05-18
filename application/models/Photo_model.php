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

    public function update_photo_data($data)
    {
       // $this->db->update_batch("photos", $data, "photoId");
    }

    public function delete_photo($data, $album_id)
    {
       $photo_base_dir = FCPATH."/assets/photos/";

       $this->db->select("label");
       $this->db->from("album");
       $this->db->where("id", $album_id);
       $query = $this->db->get();

       $album_label = $query->row()->label;

       $this->db->select("hash_filename");
       $this->db->from("photos");
       $this->db->where_in("photoId", $data);
       $query = $this->db->get();

       $files_to_delete_array = $query->result_array();

       foreach($files_to_delete_array as $row)
       {
           $file_name = $row["hash_filename"];
           $last_dot_pos = strrpos($file_name, ".");
           $file_name_without_ext = substr($file_name,0, $last_dot_pos);

           $resize_value = array("800", "1280", "1680");

           foreach ($resize_value as $value)
           {
               $resize_file_path = $photo_base_dir.$album_label."/".$file_name_without_ext."_".$value.".jpg";

               if (file_exists($resize_file_path))
               {
                    unlink($resize_file_path);
               }
           }

           unlink($photo_base_dir.$album_label."/".$file_name);

       }

       $this->db->where_in("photoId", $data);
       $this->db->delete('photos');
    }
}