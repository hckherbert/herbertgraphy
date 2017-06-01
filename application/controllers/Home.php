<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Common
{
	public function __construct()
	{
		parent::__construct();
	}

	public function _remap($param)
	{
		if (!function_exists($param) && $param!=="index")
		{
			$this->not_found();
		}
		else
		{
			$this->index();
		}
	}

	public function index()
	{
		$data = $this->getInfoPanelBaseData();

		if (ENVIRONMENT == "dev_cp")
		{
			$data["main_title"] = "Test<span class='graphy'></span>";
		}
		else
		{
			$data["main_title"] = "Herbert<span class='graphy'>Graphy</span>";
		}

		$this->load->template_client("home", "base", $data);
	}


}