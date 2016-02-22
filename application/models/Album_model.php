<?php
class Album_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_all_parent_albums()
	{
		$this->db->where("parentId", NULL);
		$this->db->order_by("order");
		$query = $this->db->get("album");
        return $query->result_array();
	}

	public function get_sub_album_by_parent_id($parent_id)
	{
		$this->db->where("parentId", $parent_id);
		$this->db->order_by("order");
		$query = $this->db->get("album");
		return $query->result_array();
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
		$this->db->where("parentId", NULL);
		$total_rows = $this->db->count_all_results("album");
		$data = array_merge($data, array("order" => $total_rows));
		$this->db->insert("album", $data);
		return $this->db->insert_id();
	}

	public  function add_subalbum($data)
	{
		$order = 0;
		$this->db->select("order");
		$this->db->order_by("order", "desc");
		$this->db->where('parentId', $data["parentId"]);
		$this->db->limit(1);
		$query = $this->db->get('album');
		$result_get_order = $query->result_array();

		if (count($result_get_order) > 0)
		{
			$order = $query->row()->order + 1;

		}

		$data = array_merge($data, array("order" => $order));
		unset($data["submit"]);
		$this->db->insert("album", $data);
		return $this->db->insert_id();
	}

	public function get_album_details($pAlbum_id)
	{
		$data = array();
		$this->db->select("id, parentId, name, label, intro");
		$this->db->where("id", $pAlbum_id);
		$query = $this->db->get("album");

		$data["album_details"] = $query->row();
		return $data;
	}
}