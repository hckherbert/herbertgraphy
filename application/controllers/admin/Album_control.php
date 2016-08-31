<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Album_control extends CI_Controller 
{
	private $config_validation_add_album;
	private $auth_data;

	public function __construct()
	{
		parent::__construct();

		require_once 'vendor/autoload.php';

		$this->load->model("album_model");
		$this->load->model("photo_model");
		$this->load->helper("url_helper");
		$this->load->helper('security');
		$this->load->helper('form');
		$this->load->library("EXIFReader");
		$this->load->library("JSONAPI");
		$this->load->library("JSONAPIEnum");
		$this->load->library("form_validation");
		$this->load->library("DateUtils");
		$this->load->config("photo");
		$this->load->config("auth");

		session_start();

		$client_id = $this->config->item("auth_client_id");
		$client_secret =  $this->config->item("auth_client_secret");
		$redirect_uri =  $this->config->item("auth_redirect_uri");

		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setScopes('email');

		$objOAuthService = new Google_Service_Oauth2($client);

		if ($this->input->get("code"))
		{
			if (!isset($_SESSION['access_token']))
			{
				$client->authenticate($this->input->get("code"));
				$_SESSION['access_token'] = $client->getAccessToken();
			}
		}

		if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
		{
			$client->setAccessToken($_SESSION['access_token']);
			$userData = $objOAuthService->userinfo->get();
			$this->auth_data["userData"] = $userData;

			if ($userData->email != $this->config->item("auth_admin_email"))
			{
				$authUrl = $client->createAuthUrl();
				$this->auth_data["is_invalid_user"] = true;
				$this->auth_data["authUrl"] = $authUrl;
			}
		}
		else
		{
			$authUrl = $client->createAuthUrl();
			$this->auth_data["authUrl"] = $authUrl;
		}

		$this->config_validation_add_album =  array(
			array(
				'field'   => 'name',
				'label'   => 'Album name',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'label',
				'label'   => 'Album label',
				'rules'   => 'trim|required|is_unique[album.label]|label_char_format'
			)
		);

		$this->config_validation_edit_album= array(
			array(
				'field'   => 'name',
				'label'   => 'Album name',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'label',
				'label'   => 'Album label',
				'rules'   => 'trim|required|is_edit_unique|label_char_format'
			)
		);

	}

	public function index()
	{
		$this->load->template_admin("admin/album_list", $this->auth_data);
	}

	public function logout()
	{
		$logout_url = $this->config->item("auth_logout_url");

		if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
		{
			unset($_SESSION['access_token']);
		}

		redirect($logout_url);
	}


	public function get_all_parent_albums()
	{
		$data = $this->album_model->get_all_parent_albums();

		if ($data === FALSE)
		{
			JSONAPI::echo_json_error_response();
		}
		else
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
	}
	
	public function update_album_list()
	{
		$del_ids = $this->input->post("del_id[]");
		$album_ids = $this->input->post("id");
		$is_query_success = true;

		if ($del_ids === NULL)
		{
			for ($i = 0; $i < count($album_ids); $i++)
			{
				if (!$this->album_model->update_album_order($album_ids[$i], $i))
				{
					$is_query_success = false;
				}
			}
		}
		else
		{

			$this->photo_model->delete_photo_records_by_album_id($del_ids);
			$this->delete_photo_folders($del_ids);

			if (!$this->album_model->delete_albums_and_reorder($del_ids, $album_ids))
			{
				$is_query_success = false;
			}
		}

		if ($is_query_success)
		{

			JSONAPI::echo_json_successful_response(NULL, FALSE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function add_album()
	{
		$post_data = $this->input->post(NULL, TRUE);
		$post_data["label"] =  trim(strtolower($post_data["label"]));
		$insert_id  = $this->album_model->add_album($post_data);

		$data= array(
			"insert_id" => $insert_id
		);

		if ($insert_id)
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}

	}

	public function validate_add_album()
	{
		$this->form_validation->set_rules($this->config_validation_add_album);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
				"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			JSONAPI::echo_json_successful_response();
		}
	}


	public function go_add_subalbum()
	{
		$album_id = $this->input->post("albumId");
		$data = $this->album_model->get_album_details($album_id, false);
		$data = array_merge($data, $this->auth_data);
		$this->load->template_admin("admin/add_subalbum", $data);
	}

	public function do_add_subalbum()
	{
		$this->form_validation->set_rules($this->config_validation_add_album);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
				"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			$post_data = $this->input->post(NULL, TRUE);
			$post_data["label"] =  trim(strtolower($post_data["label"]));
			$insert_id  = $this->album_model->add_subalbum($post_data);

			$data= array(
				"insert_id" => $insert_id
			);

			if ($insert_id)
			{
				JSONAPI::echo_json_successful_response($data, TRUE);
			}
			else
			{
				JSONAPI::echo_json_error_response();
			}
		}
	}

	public function update_album_info()
	{
		$this->form_validation->set_rules($this->config_validation_edit_album);

		if ($this->form_validation->run() == FALSE)
		{
			$data_error = array(
				"validation_error" => true
			);
			$data_error = array_merge($data_error, $this->form_validation->error_array());

			JSONAPI::echo_json_error_response($data_error);
		}
		else
		{
			$album_id = $this->input->post("id");
			$post_data = $this->input->post(NULL, TRUE);
			$post_data["label"] = trim(strtolower($post_data["label"]));
			$original_label = $this->album_model->get_album_label($album_id);
			$original_folder = FCPATH . "/assets/photos/" . $original_label;
			$new_folder = FCPATH . "/assets/photos/" . $post_data["label"];

			if (file_exists($original_folder))
			{
				if ($original_label!=$new_folder)
				{
					rename($original_folder, $new_folder);
				}
			}

			$result =  $this->album_model->update_album_info($post_data);

			if ($result)
			{
				JSONAPI::echo_json_successful_response();
			}
			else
			{
				JSONAPI::echo_json_error_response();
			}
		}
	}

	public function album_details($pAlbum_id)
	{
		$data= $this->album_model->get_album_details($pAlbum_id, false);

		if ($data["album_details"]=== NULL)
		{
			show_404();
		}

		$data = array_merge($data, $this->auth_data);
		$this->load->template_admin("admin/album_details", $data);
	}

	public function delete_album()
	{

		$del_id = $this->input->post("id");
		$order =  $this->input->post("order");
		$parent_id =  $this->input->post("parentId");
		if ($parent_id !== "")
		{
			$this->delete_photo_folders(array($del_id));
			$this->photo_model->delete_photo_records_by_album_id(array($del_id));
		}
		else
		{
			$this->delete_photo_folders(array($del_id, $parent_id));

			$all_del_ids = array();
			$sub_album_ids = $this->album_model->get_sub_album_by_parent_id($del_id);

			$all_del_ids = array_map(function($input_array)
			{
				return $input_array["id"];
			}, $sub_album_ids);

			$all_del_ids[] = $del_id;

			$this->photo_model->delete_photo_records_by_album_id($all_del_ids);
		}
		$result =  $this->album_model->delete_single_album($del_id, $order, $parent_id);

		if ($result)
		{
			JSONAPI::echo_json_successful_response();
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}

	}

	public function get_subalbum_list($pAlbum_id)
	{
		$data= $this->album_model->get_sub_album_by_parent_id($pAlbum_id);

		if ($data!== FALSE)
		{
			JSONAPI::echo_json_successful_response($data, TRUE);
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function update_photo_data($album_id)
	{
		$featuredId = $this->input->post("featured")[0];
		$del_data = array();
		$update_data = array();
		$update_data["slug_filename"] = array();
		$update_data["original_filename"] = array();
		$update_data["original_slug"] = array();
		$update_data["title"] = array();
		$update_data["desc"] = array();
		$update_data["photoId"] = array();
		$update_data["featured"] = array();
		$featured_array = array();

		foreach($this->input->post() as $key=>$value)
		{
			if ($key == "del_id")
			{
				$del_data[] = $value;
			}
			else if ($key == "new_filename")
			{
				array_push($update_data["slug_filename"], $value);
			}
			else if ($key == "title")
			{
				array_push($update_data["title"], $value);
			}
			else if ($key == "desc")
			{
				array_push($update_data["desc"], $value);
			}
			else if ($key == "photo_id")
			{
				array_push($update_data["photoId"], $value);

				foreach($value as $photoId)
				{
					if ($photoId == $featuredId)
					{
						array_push($featured_array, "1");
					}
					else
					{
						array_push($featured_array, "0");
					}
				}

				array_push($update_data["featured"], $featured_array);

			}
			else if ($key == "original_filename")
			{
				array_push($update_data["original_filename"], $value);
			}
			else if ($key == "original_slug")
			{
				array_push($update_data["original_slug"], $value);
			}
		}


		if (count($del_data))
		{
			$this->photo_model->delete_photo($del_data[0], $album_id);
		}


		$this->photo_model->update_photo_data($update_data, $album_id);
 
		if ($this->photo_model->update_photo_data($update_data, $album_id))
		{
			JSONAPI::echo_json_successful_response();
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}

	public function unset_featured()
	{
		if ($this->photo_model->unset_featured($this->input->post("id")))
		{
			JSONAPI::echo_json_successful_response();
		}
		else
		{
			JSONAPI::echo_json_error_response();
		}
	}
	
	public function upload()
	{

		$upload_base_dir = FCPATH."/assets/photos/";

		if ($_POST["album_label"])
		{
			$uploadDir = $upload_base_dir.strtolower($_POST["album_label"]);

			if (!file_exists($uploadDir))
			{
				if (!mkdir($uploadDir, 0777, true))
				{
					JSONAPI::echo_json_error_response("CANNOT_CREATE_UPLOAD_DIRECTORY");
				}
			}

			$uploadDir.="/";

		}
		else
		{
			JSONAPI::echo_json_error_response("NO_UPLOAD_DIRECTORY_SPECIFIED");
		}

		$photo_user_data = json_decode($_POST["photo_user_data"], true);
		$fileTypes = array('jpg', 'gif', 'png');
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken && $photo_user_data )
		{
			$post_data_index = -1;
			$slug_filename_only = "";
			$desc = "";
			$title = "";

			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$extension = strtolower($fileParts['extension']);
			$tempFile   = $_FILES['Filedata']['tmp_name'];
			$exif = JSONAPI::encode(EXIFReader::getData($_FILES['Filedata']['tmp_name']));


			foreach($photo_user_data["original_filename"] as $index=>$value)
			{
				if ($value ==  $_FILES['Filedata']['name'])
				{
					$post_data_index = $index;
				}
			}

			if ($photo_user_data["new_filename"][$post_data_index] == "")
			{
				$slug_filename_only =  pathinfo($_FILES['Filedata']['name'], PATHINFO_FILENAME);
				$slug_filename_only = preg_replace('/\s+/', '-', $slug_filename_only);
				$slug_filename_only = strtolower($slug_filename_only);
			}
			else
			{
				$slug_filename_only = $photo_user_data["new_filename"][$post_data_index];
				$slug_filename_only = strtolower($slug_filename_only);
			}

			$desc = $photo_user_data["desc"][$post_data_index];
			$title = $photo_user_data["title"][$post_data_index];
			$featured = $photo_user_data["featured"][$post_data_index];
			$hash = hash("sha256", $slug_filename_only .time()."herbertgraphyalbumadmin");
			$hash_filename = $slug_filename_only."-".$hash.".".$extension;
			$target_file = $uploadDir.$hash_filename;

			if (in_array($extension, $fileTypes))
			{
				if (move_uploaded_file($tempFile, $target_file))
				{
					foreach($this->config->item("photo_long_side") as $value)
					{
						$this->resize_photo($value, $target_file);
					}

					JSONAPI::echo_json_successful_response();
				}
				else
				{

					JSONAPI::echo_json_error_response("CANNOT_MOVE_FILE");
				}

				$data = array(
					"albumId" => $_POST["albumId"],
					"photo_code"=>DBCodeGenerator::generate_db_code("p", true),
					"slug_filename" => $slug_filename_only,
					"hash_filename" => $hash_filename,
					"title" => $title,
					"desc" => $desc,
					"featured" => $featured,
					"created_date" => DateUtils::current_db_datetime(),
					"exif"=>$exif
				);

				$this->photo_model->add_uploaded_file_records($data);

			}
			else
			{
				JSONAPI::echo_json_error_response("INVALID_FILE_TYPE");

			}
		}
	}

	private function resize_photo($long_side, $target_file)
	{
		$this->load->library('image_lib');

		list($width, $height) = getimagesize($target_file);

		$config['image_library'] = 'gd2';
		$config['source_image'] = $target_file;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['quality'] = '100%';

		if ($width < $this->config->item("photo_long_side")[0] &&  $height < $this->config->item("photo_long_side")[0])
		{
			return;
		}

		if ($width >= $long_side || $height >= $long_side)
		{
			$config['thumb_marker'] = "_".$long_side;
			$config['width'] = $long_side;
			$config['height'] = $long_side;
			$this->image_lib->initialize($config);
			if (!($this->image_lib->resize()))
			{
				JSONAPI::echo_json_error_response("RESIZE_PHOTO_ERROR");
			}
			$this->image_lib->clear();
		}

	}

	private function delete_photo_folders($album_ids)
	{
		$album_labels = $this->album_model->get_all_albums_and_subalbums_labels($album_ids);

		foreach ($album_labels as $value)
		{
			$folder =  FCPATH."/assets/photos/".$value["label"]."/";

			if (file_exists($folder))
			{
				foreach (glob($folder . '*.*') as $obj)
				{
					unlink($obj);
				}
				rmdir($folder);
			}
		}

	}

}