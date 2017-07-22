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
        $this->load->config("photo");
    }

    public function add_uploaded_file_records($data)
    {
        $this->db->insert("photos", $data);
        return $this->db->insert_id();
    }

    public function get_photo_data($album_id, $pIsShuffle)
    {
        $photo_base_dir = FCPATH."/assets/photos/";
        $album_label = $this->get_photo_folder($album_id);
        $this->load->config("photo");

		$this->db->select("photoId,slug_filename,hash_filename,title,desc,featured,highlighted");
		$this->db->where("albumId", $album_id);
		$this->db->order_by("featured", "DESC");
		$this->db->order_by("created_date", "DESC");
		$query = $this->db->get("photos");
        $highlight_factor = $this->config->item("photo_highlight_priority_factor");

		if ($pIsShuffle)
		{
			$featured_index = -1;
			$result = $query->result_array();
			//shuffle($result);

			foreach($result as $key=>$record)
			{

                $last_dot_pos = strrpos($record["hash_filename"], ".");
                $file_name_without_ext = substr($record["hash_filename"],0, $last_dot_pos);
                $result[$key]["hash_filename"] = $file_name_without_ext;

                if ($record["featured"] == "1")
                {
                    $featured_index = $key;

                    //if featured pic, use 1280
                    if (file_exists($photo_base_dir . $album_label . "/" . $file_name_without_ext . "_" . $this->config->item("photo_long_side")[2] . ".jpg"))
                    {
                        $result[$key]["file_thumb_path"] = $file_name_without_ext . "_" . $this->config->item("photo_long_side")[2] . ".jpg";
                    }
                    //if 1280 not found, use default (won't happen in normal case)
                    else
                    {
                        $result[$key]["file_thumb_path"] = $result[$key]["hash_filename"] . ".jpg";
                    }

                    $result[$key]["priority"] = $highlight_factor + 0.1;

                }
                else  if ($record["highlighted"] == "1")
                {
                    if (file_exists($photo_base_dir . $album_label . "/" . $file_name_without_ext . "_" . $this->config->item("photo_long_side")[1] . ".jpg"))
                    {
                        $result[$key]["file_thumb_path"] = $file_name_without_ext . "_" . $this->config->item("photo_long_side")[1] . ".jpg";
                    }
                    //if 1280 not found, use default (won't happen in normal case)
                    else
                    {
                        $result[$key]["file_thumb_path"] = $result[$key]["hash_filename"] . ".jpg";
                    }

                    $result[$key]["priority"] = $highlight_factor * (mt_rand() / mt_getrandmax());
                }
                else
                {
                    //if non-featured, use 320
                    if (file_exists($photo_base_dir . $album_label . "/" . $file_name_without_ext . "_" . $this->config->item("photo_long_side")[0] . ".jpg"))
                    {
                        $result[$key]["file_thumb_path"] = $file_name_without_ext . "_" . $this->config->item("photo_long_side")[0] . ".jpg";
                    }
                    //if 640 not found, use default (this unlikely happens because normally album will have one photo set featured)
                    else
                    {
                        $result[$key]["file_thumb_path"] = $result[$key]["hash_filename"] . ".jpg";
                    }

                    $result[$key]["priority"] = mt_rand() / mt_getrandmax();
                }

                list($width, $height, $type, $attr) = getimagesize($photo_base_dir . $album_label . "/" .$result[$key]["file_thumb_path"]);

                $result[$key]["width"] = $width;
                $result[$key]["height"] = $height;
                $result[$key]["file_zoom_size"] = "";

                foreach ($this->config->item("photo_long_side") as $value)
                {
                    if (file_exists($photo_base_dir.$album_label."/".$file_name_without_ext."_".$value.".jpg"))
                    {
                        $result[$key]["file_zoom_size"] = $value;
                    }
                }
			}


            $priority = array();

            foreach ($result as $item)
            {
                foreach ($item as $key=>$value)
                {
                    if ($key === "priority")
                    {
                        $priority[] = $value;
                    }
                }
            }

            array_multisort($priority, SORT_DESC,  $result);

			if ($featured_index>=0)
			{
				$featured_photo = $result[$featured_index];
				unset($result[$featured_index]);
				array_unshift($result, $featured_photo);
			}

			return $result;
		}
		else
		{
            $result = $query->result_array();
            $thumb_long_size = $this->config->item("photo_long_side")[0];
            $result = array_map(function($row) use ($thumb_long_size, $photo_base_dir, $album_label)
            {

                $last_dot_pos = strrpos($row["hash_filename"], ".");
                $file_name_without_ext = substr($row["hash_filename"],0, $last_dot_pos);

                if (file_exists($photo_base_dir . $album_label . "/" . $file_name_without_ext . "_" . $thumb_long_size . ".jpg")) {
                    $row["hash_filename"] = $file_name_without_ext . "_" .$thumb_long_size . ".jpg";
                }
                return $row;
            }, $result);

			return $result;
		}
		 
    }

    public function update_photo_data($data, $album_id)
    {
        if (ENVIRONMENT != "production")
        {
            error_reporting(0);
        }

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

                foreach ($this->config->item("photo_long_side") as $value)
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
                "desc"=> $data["desc"][0][$i],
                "featured"=>$data["featured"][0][$i],
                "highlighted"=>$data["highlighted"][0][$i]
            );
        }

        unset($data);

        $this->db->update_batch("photos", $batch_update_data_array, "photoId");

        if (ENVIRONMENT != "production")
        {
            error_reporting(-1);
        }

         if ($this->db->trans_status() === TRUE)
         {
             return TRUE;
         }
         else
         {
             return FALSE;
         }
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

           foreach ($this->config->item("photo_long_side") as $value)
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

    public function delete_photo_records_by_album_id($album_id_array)
    {
        $this->db->where_in("albumId",$album_id_array);
        $this->db->delete("photos");
    }
	
	public function unset_featured($id)
	{
		$data = array
		(
			"featured" => "0"
		);
		$this->db->where("photoId", $id);
		return $this->db->update("photos", $data);	
	}
}