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
			"order" => $order
		);

		$this->db->where("id", $album_id);
		$result = $this->db->update("album", $data);

		return $result;

	}


	public function delete_albums_and_reorder($del_ids, $album_ids)
	{
		$this->db->where_in("id", $del_ids);
		$this->db->or_where_in("parentId", $del_ids);
		$result = $this->db->delete("album");

		if ($result) {

			$order_count = 0;

			for ($i = 0; $i < count($album_ids); $i++)
			{
				if (!in_array($album_ids[$i], $del_ids))
				{
					$data = array
					(
						"order" => $order_count
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

	public function delete_single_album($id, $order, $parent_id)
	{
		$this->db->where_in("id", $id);
		$this->db->or_where_in("parentId", $id);
		$result = $this->db->delete("album");

		if ($result) {

			if ($parent_id !== NULL && $parent_id !== "" )
			{
				$this->db->where("parentId", $parent_id);
				$this->db->order_by("order");
				$query = $this->db->get("album");
				$sub_album_count = $query->num_rows();

				if ($sub_album_count > 0)
				{

					for ($i = $order+1; $i <= $sub_album_count; $i++)
					{
						$data = array
						(
							"order" => $i-1
						);

						$this->db->where("order", $i);
						$this->db->where("parentId", $parent_id);
						$result_update = $this->db->update("album", $data);


						if (!$result_update)
						{
							return;
						}
					}

					return true;
				}
				else
				{
					return true;
				}

			}
			else
			{
				return true;
			}

		}
	}

	public function add_album($data)
	{

		$this->db->trans_start();

		$this->db->where("parentId", NULL);
		$total_rows = $this->db->count_all_results("album");
		$data = array_merge($data, array("order" => $total_rows));
		$this->db->insert("album", $data);

		$insert_id = $this->db->insert_id();
		$data = array
		(
			"albumId"=>$insert_id
		);
		$this->db->where("albumId", 0);
		$this->db->update("photos", $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return;
		}

		return $insert_id;

	}

	public function add_subalbum($data)
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

		$insert_id = $this->db->insert_id();
		$data = array
		(
			"albumId"=>$insert_id
		);
		$this->db->where("albumId", 0);
		$this->db->update("photos", $data);

		return $insert_id;

	}

	public function get_album_details($pAlbum_id)
	{
		$data = array();
		$this->db->select("id, parentId, order, name, label, intro");
		$this->db->where("id", $pAlbum_id);
		$query = $this->db->get("album");

		if ($query->num_rows() == 0)
		{
			show_404();
		}

		$this->load->model("photo_model");

		$album_details = $query->row();

		if ($album_details->parentId !== NULL)
		{
			$this->db->select("name AS parentName");
			$this->db->where("id", $query->row()->parentId);
			$query = $this->db->get("album");

			if ($query->row())
			{
				$album_details->parentName = $query->row()->parentName;
			}
		}

		$data["photo_data"] = $this->photo_model->get_photo_data($pAlbum_id);
		$data["album_details"] = $album_details;

		return $data;
	}

	public function get_album_label($pAlbum_id)
	{
		$this->db->select("label");
		$this->db->where("id",$pAlbum_id);
		$query = $this->db->get("album");

		$result = $query->row();
		return $result->label;
	}

	public function get_all_albums_and_subalbums_labels($pAlbum_ids)
	{
		$this->db->select("label");
		$this->db->where_in("id", $pAlbum_ids);
		$this->db->or_where_in("parentId", $pAlbum_ids);
		$query = $this->db->get("album");

		return $query->result_array();
	}

	public function update_album_info($data)
	{
		$this->db->where("id", $data["id"]);
		$result = $this->db->update("album", $data);

		if ($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function is_current_label_unique_against_others($pAlbum_label, $pAlbum_id)
	{
		$this->db->where("label", $pAlbum_label);
		$this->db->where("id!=$pAlbum_id");
		$query = $this->db->get("album");

		if ($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

}