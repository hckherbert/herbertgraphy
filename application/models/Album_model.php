<?php
class Album_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_all_parent_albums()
	{
		$this->db->order_by("order");
		$query = $this->db->get("album");
        return $query->result_array();
	}
	
	public function update_album_list()
	{
		$del_id = $this->input->post("del_id");
		
		$query = $this->db->get("album");
		$this->db->where_in("id", $del_id);
		$this->db->delete("album");
	}

	public function update_album_order($album_id, $order)
	{
		$data = array
		(
			"order"=>$order
		);

		$this->db->where("id", $album_id);
		$result = $this->db->update("album", $data);

		return $result;

	}

	public function delete_albums($del_ids, $album_ids)
	{
		$this->db->where_in("id", $del_ids);
		$result = $this->db->delete("album");

		if ($result)
		{

			$order_count = 0;

			for ($i=0; $i<count($album_ids); $i++)
			{
				if (!in_array($album_ids[$i],$del_ids))
				{
					$data = array
					(
						"order"=>$order_count
					);

					$order_count++;

					$this->db->where("id", $album_ids[$i]);
					$result_update = $this->db->update("album", $data);

					if (!$result_update)
					{
						return;
					}

				}
			}
		}

		return $result;
	}

	public  function add_album($data)
	{
		$total_rows = $this->db->count_all("album");
		$data = array_merge($data, array("order" => $total_rows));
		$this->db->insert("album", $data);
		return $this->db->insert_id();
	}


}