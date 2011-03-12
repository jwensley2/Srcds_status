<!DOCTYPE html>
<html>
	<head>
		<title>SRCDS Status Library Example</title>
		
		<meta charset="utf-8">
		
		<style type="text/css" media="screen">
			th,td{border:1px solid #000;font-size:14px;padding:5px;}
			th{background-color:#ccc;}
			.server-info th{text-align:right;}
		</style>
	</head>
	
	<body>
		<h1>SRCDS Library Example</h1>
		<h2>Server Information</h2>
		<table class="server-info">
			<tr>
				<th>Ping:</th>
				<td><?php echo $ping ?>ms</td>
			</tr>
			<tr>
				<th>Hostname:</th>
				<td><?php echo $server->hostname ?></td>
			</tr>
			<tr>
				<th>Mapname:</th>
				<td><?php echo $server->mapname ?></td>
			</tr>
			<tr>
				<th>Game Dir:</th>
				<td><?php echo $server->game_dir ?></td>
			</tr>
			<tr>
				<th>Game:</th>
				<td><?php echo $server->game ?></td>
			</tr>
			<tr>
				<th>Players:</th>
				<td><?php echo $server->players ?></td>
			</tr>
			<tr>
				<th>Max Players:</th>
				<td><?php echo $server->max_players ?></td>
			</tr>
			<tr>
				<th>Bots:</th>
				<td><?php echo $server->bots ?></td>
			</tr>
			<tr>
				<th>Dedicated:</th>
				<td><?php echo $server->dedicated ?></td>
			</tr>
			<tr>
				<th>OS:</th>
				<td><?php echo $server->os ?></td>
			</tr>
			<tr>
				<th>Password:</th>
				<td><?php echo $server->password ?></td>
			</tr>
			<tr>
				<th>Secure:</th>
				<td><?php echo $server->secure ?></td>
			</tr>
			<tr>
				<th>Version:</th>
				<td><?php echo $server->version ?></td>
			</tr>
		</table>
		
		<h2>Player List - Sorted by Kills</h2>
		<table class="player-list">
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
			<?php foreach ($players_kills as $player): ?>
				<tr>
					<td><?php echo $player->name ?></td>
					<td><?php echo $player->kills ?></td>
					<td><?php echo $player->time ?>s</td>
				</tr>
			<?php endforeach ?>
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
		</table>
		
		<h2>Player List - Sorted by Name</h2>
		<table class="player-list">
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
			<?php foreach ($players_name as $player): ?>
				<tr>
					<td><?php echo $player->name ?></td>
					<td><?php echo $player->kills ?></td>
					<td><?php echo $player->time ?>s</td>
				</tr>
			<?php endforeach ?>
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
		</table>
		
		<h2>Player List - Sorted by Time</h2>
		<table class="player-list">
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
			<?php foreach ($players_time as $player): ?>
				<tr>
					<td><?php echo $player->name ?></td>
					<td><?php echo $player->kills ?></td>
					<td><?php echo $player->time ?>s</td>
				</tr>
			<?php endforeach ?>
			<tr>
				<th>Name</th>
				<th>Kills</th>
				<th>Connected Time</th>
			</tr>
		</table>
	</body>
</html>