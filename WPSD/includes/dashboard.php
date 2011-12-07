<?php include('header.php'); ?>

<div id="progressBar">
	<div class="progress-bar"><div class="bar"><span></span></div></div>
</div>

<header>
	<h1 class="logo">WordPress Status Dashboard</h1>
	<div class="signedin">Signed in as <?php echo ucwords($admin_user); ?> &mdash; <a href="?signout=1">Sign Out</a></div>
	<nav>
		<ul>
			<li><a class="button"><span class="add-client">Add Client</span></a></li>
			<li><a id="#refresh-all" class="button"><span class="refresh-all">Refresh All</span></a></li>
		</ul>
	</nav>
</header>

<?php if (isset($wpsd_active_message) && $wpsd_active_message){
	
	echo '<div id="wpsdMessages">';
		echo $wpsd_active_message;
		echo '<a id="message-'.$wpsd_active_message_id.'" class="hide">X</a>';
	echo '</div>';
	
} ?>

<div class="website-blocks">

	<?php
	$websites = array();
	$queryResource = mysql_query("SELECT * FROM wpsd_clients ORDER BY client_name ASC");
	while ($row = mysql_fetch_array($queryResource, MYSQL_ASSOC)) {
		$websites[] = array('client_id'=>$row['client_id'],'client_name'=>$row['client_name'],'client_url'=>$row['client_url']);
	}

	$temp_count = 0;
	
	foreach ($websites as $client){ $temp_count++;
		
		?>
		<div id="client-<?php echo $client['client_id']; ?>" class="block-wrapper loading">
			<div class="loading-area" id="loading-area-client-<?php echo $client['client_id']; ?>"></div>
			<span class="hidden"><?php echo "<a id=\"subclient-".$client['client_id']."\" href=\"".$client['client_url']."\">".$client['client_name']."</a>"; ?></span>
		</div><?
		
	} ?>

	<div class="cl"></div>
	
</div>

<?php include('footer.php'); ?>