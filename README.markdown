Usage
======================

To ping the server
	
	// function ping($host, $port = '27015');
	$ping = $this->srcds_status->ping('127.0.0.1');
	echo $ping // Displays the servers ping in milliseconds
	
	
Get the server status and output all the information
	
	// function get_status($host, $port = '27015')
	$server = $this->srcds_status->get_status('127.0.0.1');
	echo $server->hostname;
	echo $server->mapname;
	echo $server->game_dir; // eg. tf
	echo $server->game; // eg. Team Fortress
	echo $server->app_id;
	echo $server->players; // player count
	echo $server->max_players;
	echo $server->bots;
	echo $server->dedicated; // l = Listen, d = Dedicated, p = SourceTV
	echo $server->os; // w = Windows, l = Linux
	echo $server->password; // 0 or 1
	echo $server->secure; // 0 or 1
	echo $server->version;
	
	
Get the player list and display the information for each player

	// function get_players($host, $port = '27015', $sort_type = NULL, $sort = NULL)
	$players = $this->srcds_status->get_players('127.0.0.1', '27015', 'kills, 'desc');
	
	foreach($players as $player)
	{
		echo $player->name;
		echo $player->kills;
		echo $player->time; // Connection time in seconds
	}


You can also sort the player list using the sort_players() method

	// function sort_players($players, $sort_type = 'kills', $sort = 'desc')
	$players = $this->srcds_status->get_players('127.0.0.1', '27015');
	$sorted_players = $this->srcds_status->sort_players($players, 'kills', 'asc');
	
You can sort by name or kills