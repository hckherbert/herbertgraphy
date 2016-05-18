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

    public function update_photo_data($data, $album_id)
    {
        $photo_base_dir = FCPATH."/assets/photos/";
        $album_label = $this->get_photo_folder($album_id);
        $batch_update_data_array = array();
        $original_file_names_array = $data["original_filename"][0];
        $original_slug_array = $data["original_slug"][0];
        $new_file_names_array = $data["slug_filename"][0];
        $record_count =  count($original_file_names_array);

        for ($i = 0; $i < $record_count; $i++ )
        {
            if (strtolower(trim($new_file_names_array[$i]))!= strtolower(trim($original_slug_array[$i])) && trim($new_file_names_array[$i])!="" )
            {
                $last_dot_pos = strrpos($original_file_names_array[$i], ".");
                $original_filename_without_ext = substr($original_file_names_array[$i],0, $last_dot_pos);
                $extension = substr($original_file_names_array[$i], $last_dot_pos+1);
                $hash = hash("sha256", $new_file_names_array[$i] .time()."herbertgraphyalbumadmin");
                $new_filename = $new_file_names_array[$i]."-".$hash.".".$extension;
                $data["hash_filename"][0][$i] = $new_filename;

                $original_file_path =  $photo_base_dir.$album_label."/".$original_file_names_array[$i];
                $new_filename_path =  $photo_base_dir.$album_label."/".$new_filename;

                rename($original_file_path, $new_filename_path);

                $resize_value = array("800", "1280", "1680");

                foreach ($resize_value as $value)
                {
                    $original_resize_filename = $original_filename_without_ext."_".$value.".jpg";
                    $new_resize_filename = $new_file_names_array[$i]."-".$hash."_".$value.".jpg";

                    $original_resize_file_path = $photo_base_dir.$album_label."/".$original_resize_filename;
                    $new_resize_filename = $photo_base_dir.$album_label."/".$new_resize_filename;

                    if (file_exists($original_resize_file_path))
                    {
                        rename($original_resize_file_path, $new_resize_filename);
                    }
                }
            }
            else
            {
                $data["hash_filename"][0][$i] = $original_file_names_array[$i];
            }
        }

        for ($i=0; $i< $record_count; $i++)
        {
            $batch_update_data_array[] = array(
                "photoId"=> $data["photoId"][0][$i],
                "slug_filename"=> $data["slug_filename"][0][$i],
                "hash_filename"=>  $data["hash_filename"][0][$i],
                "title"=> $data["title"][0][$i],
                "desc"=> $data["desc"][0][$i]
            );
        }

        unset($data);

        $this->db->update_batch("photos", $batch_update_data_array, "photoId");
    }

    public function delete_photo($data, $album_id)
    {
       $photo_base_dir = FCPATH."/assets/photos/";

       $album_label = $this->get_photo_folder($album_id);

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

    public function get_photo_folder($album_id)
    {
        $this->db->select("label");
        $this->db->from("album");
        $this->db->where("id", $album_id);
        $query = $this->db->get();

        $album_label = $query->row()->label;

        return $album_label;
    }
}