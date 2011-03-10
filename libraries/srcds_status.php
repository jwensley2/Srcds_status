<?php

/**
 * Contains functions for retrieving the status of a Source Dedicated Server(SRCDS)
 *
 * @author Joseph Wensley
 */

class Srcds_status {

	// Socket timeouts
	private $timeout		= 2;
	private $ping_timeout	= 1;
	
	// http://developer.valvesoftware.com/wiki/Server_queries
	const PACKET_SIZE					= 1248;
	const A2S_INFO						= "\xFF\xFF\xFF\xFFTSource Engine Query\0"; // Get the server info
	const A2S_SERVERQUERY_GETCHALLENGE	= "\xFF\xFF\xFF\xFF\x55\xFF\xFF\xFF\xFF"; // Get a challenge key
	const A2S_PLAYER					= "\xFF\xFF\xFF\xFF\x55"; // Get the player list
	
	function __construct()
	{
		log_message('debug', 'Srcds_status library loaded');
	}
	
	/**
	 * Ping the server
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @return bool
	 * @author Joseph Wensley
	 */
	public function ping($host, $port = '27015')
	{
		// Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		stream_set_timeout($socket, $this->ping_timeout);
		
		$start_time = microtime(TRUE);
		
		// Send the command to get the player list
		fwrite($socket, self::A2S_INFO);
	
		$response = fread($socket, self::PACKET_SIZE); // Read a packet

		$end_time = microtime(TRUE);

		if(empty($response))
		{
			return FALSE; // No response
		}
		else
		{
			$ping = number_format(($end_time - $start_time) * 1000, 2); // Calculate the ping to the server in milliseconds
			return $ping; // Return the ping time
		}
		
	}
	
	/**
	 * Get the server info
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @return mixed
	 * @author Joseph Wensley
	 */
	public function get_status($host, $port = '27015')
	{
		$server = new StdClass();
	
		// Open a socket to the server and set the timeout
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str);
		stream_set_timeout($socket, $this->timeout);
		
		// Send the command to get the player list
		fwrite($socket, self::A2S_INFO);
	
		$response = fread($socket, self::PACKET_SIZE);
		$response = substr($response, 6);

		if(!empty($response))
		{
			$server->hostname 		= $this->get_string($response);
			$server->mapname 		= $this->get_string($response);
			$server->game_dir		= $this->get_string($response);
			$server->game			= $this->get_string($response);
			$server->app_id			= $this->get_short_unsigned($response);
			$server->players 		= $this->get_byte($response);
			$server->max_players 	= $this->get_byte($response);
			$server->bots 			= $this->get_byte($response);
			$server->dedicated 		= $this->get_char($response);
			$server->os				= $this->get_char($response);
			$server->password		= $this->get_byte($response);
			$server->secure			= $this->get_byte($response);
			$server->version		= $this->get_string($response);
			
			return $server;
		}
		
		return FALSE;
	}
	
	/**
	 * Get a list of the players on the server
	 *
	 * @param string $host The hostname/ip of the server
	 * @param string $port The port of the server
	 * @param string $sort How we should sort the players
	 * @return mixed
	 * @author Joseph Wensley
	 */
	public function get_players($host, $port = '27015', $sort_type = NULL)
	{	
		// Open a socket to the server
		$socket = fsockopen('udp://'.$host, $port, $err_num, $err_str, $this->timeout);
		stream_set_timeout($socket, $this->timeout);
		
		// Send the Challenge command
		fwrite($socket, self::A2S_SERVERQUERY_GETCHALLENGE);
		
		// Discard the junk from the response and read the challenge number
		fread($socket, 5);
		$challenge = fread($socket, 4);
		
		// Send the command to get the player list
		$command = self::A2S_PLAYER.$challenge;
		fwrite($socket, $command);
	
		$response = fread($socket, self::PACKET_SIZE);
		$response = substr($response, 6);
		
		fclose($socket);
		
		$players = new StdClass();
		if(ord(substr($response, 0, 1)) === 0)
		{
			$id = 0;
			while($response !== false){
				$this->get_byte($response); // First byte is supposed to be an id but seems to always be 0
				
				$players->$id->name		= $this->get_string($response);
				$players->$id->kills	= $this->get_long($response);
				$players->$id->time		= $this->get_float($response);
				
				$id++;
			}
		}
		

		
		return $players;
	}

	public function sort_players($players, $sort_type = 'kills')
	{
		usort($players, array(__CLASS__, 'sort_players_cmp'));
		
		return $players;
	}

	private function sort_players_cmp($a, $b)
	{
		switch ($this->sort_type)
		{
			case 'kills':
				if($a->kills == $b->kills){ return 0; }
				if($a->kills > $b->kills)
				{
					return 1;
				}
				else
				{
					return -1;
				}
				break;
			
			case 'name':
				return strcmp($b->name, $a->name);
				break;
			
			default:
				return 0;
				break;
		}
	}
	
	private function get_char(&$string)
	{
		return chr($this->get_byte($string));
	}
	
	private function get_byte(&$string)
	{
		$data = substr($string, 0, 1);
		$string = substr($string, 1);
		$data = unpack('Cvalue', $data);

		return $data['value'];
	}
	
	private function get_short_unsigned(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('nvalue', $data);

		return $data['value'];
	}

	private function get_short_signed(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('svalue', $data);

		return $data['value'];
	}

	private function get_long(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$data = unpack('Vvalue', $data);

		return $data['value'];
	}

	private function get_float(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$array = unpack("fvalue", $data);

		return $array['value'];
	}

	private function get_string(&$string)
	{
		$data = "";
		$byte = substr($string, 0, 1);
		$string = substr($string, 1);

		while (ord($byte) != "0"){
			$data .= $byte;
			$byte = substr($string, 0, 1);
			$string = substr($string, 1);
		}

		return $data;
	}
}

/* End of file Srcds_status.php */
/* Location: ./application/libraries/Srcds_status.php */