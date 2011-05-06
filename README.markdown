Usage
=====

Initialize Configuration
------------------------
You can alter the default config values by passing an array of options to the initialize method

	$config = array(
		$timeout				= 2;
		$ping_timeout			= 1;
		$enable_cache			= TRUE; // Enable caching
		$cache_bad_responses	= TRUE; // Should we cache invalid reponses (timeouts/errors)
		$cache_time				= 30; // Time to cache server responses for
	)
	$this->srcds_stats->initialize($config);

Pinging a Server
----------------
The ping method lets you quickly check to see if a server is responding
	
	// function ping($host, $port = '27015');
	$ping = $this->srcds_status->ping('127.0.0.1');
	echo $ping // Displays the servers ping in milliseconds
	
	
Server Status
-------------
You can use this method to get all the information available from a server

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
	
	
Player List
-----------
This method lets you retrieve a list of all players on the server and sort them by kills, name or connection time

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
	
You can sort by name, kills or connection time
