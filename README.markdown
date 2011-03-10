Usage
======================

To ping the server
	
	$ping = $this->srcds_status->ping('127.0.0.1');
	echo $ping // Displays the servers ping in milliseconds
	
Get the server status and output all the information

	$server = $this->srcds_status->get_status('127.0.0.1');
	echo $server->hostname;
	echo $server->mapname;
	echo $server->game_dir; // eg. tf
	echo $server->game; // eg. Team Fortress
	echo $server->app_id;
	echo $server->players;
	echo $server->max_players;
	echo $server->bots;
	echo $server->dedicated; // l = Listen, d = Dedicated, p = SourceTV
	echo $server->os; // w = Windows, l = Linux
	echo $server->password; // 0 or 1
	echo $server->secure; // 0 or 1
	echo $server->version;
	
Get the player list and display the information for each player

	$players = $this->srcds_status->get_players('127.0.0.1');
	
	foreach($players as $player)
	{
		echo $player->name;
		echo $player->kills;
		echo $player->time; // Connection time in seconds
	}