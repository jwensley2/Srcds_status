<?php defined('BASEPATH') or exit('No direct script access allowed');


class Srcds_status_example extends CI_Controller {
	public function index()
	{
		$this->load->spark('srcds_status');
		$this->load->library('srcds_status');
		
		$host = '67.228.59.146';
		$port = '27015';
		
		$config = array(
			'srcds_cache_time' => 5
		);
		
		$this->srcds_status->initialize($config);
		
		$data->ping = $this->srcds_status->ping($host, $port);
		$data->server = $this->srcds_status->get_status($host, $port);
		$data->players_kills = $this->srcds_status->get_players($host, $port, 'kills', 'desc');
		$data->players_name = $this->srcds_status->sort_players($data->players_kills, 'name', 'asc');
		$data->players_time = $this->srcds_status->sort_players($data->players_kills, 'time', 'desc');
		
		$this->load->view('srcds_status_example', $data);
	}
}