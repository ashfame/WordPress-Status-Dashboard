<?php

require_once('../../includes/config.php');
require_once('../../includes/mysql.php');

if (isset($_POST['add']) && $_POST['add']){

	$width = $_POST['width'];
	$client_name = $_POST['client_name'];
	$client_url = $_POST['client_url'];
	$client_name = addslashes($client_name);
	
	// Add Client to Database
	$sql = "INSERT INTO
				wpsd_clients
			SET
				client_name = '$client_name',
				client_url = '$client_url'
			";

	if (!$queryResource = mysql_query($sql)) {
		trigger_error('Query error ' . mysql_error() . ' SQL: ' . $sql);
	}
	
	$last_inserted_row = mysql_insert_id();

	?>
	<div id="client-<?php echo $last_inserted_row; ?>" style="width:<?php echo $width; ?>px;" class="block-wrapper loading">
		<div class="loading-area" id="loading-area-client-<?php echo $last_inserted_row; ?>"></div>
		<span class="hidden"><?php echo "<a id=\"subclient-".$last_inserted_row."\" href=\"".$client_url."\">".$client_name."</a>"; ?></span>
	</div>
	
	<script type="text/javascript">
	$('#client-<?php echo $last_inserted_row; ?>').each(function(){
		
		var minimum_panel_size = 220;
		var panel_margin = 10;
		var total_panel_width = minimum_panel_size + panel_margin;
			
		var clientID = this.id;
		clientID = clientID.split('-');
		clientID = clientID[1];
			
		var thisBlock = $(this);
	
		var contentwidth = $('.website-blocks').width();
		var toFit = Math.floor(contentwidth / total_panel_width);
		var currentPanelWidthTotal = toFit * total_panel_width;
		var newPanelWidth = contentwidth - currentPanelWidthTotal;
		var newPanelWidth = Math.floor(newPanelWidth / toFit);
		var newPanelWidth = minimum_panel_size + newPanelWidth;
		var newPanelWidth = newPanelWidth - 2;
		var subPanelWidth = newPanelWidth - 42;
		
		clientBlockID = this.id;
		var url = thisBlock.find('.hidden a').attr('href');
		var name = thisBlock.find('.hidden a').html();
		var client_id = thisBlock.find('.hidden a').attr('id');
		client_id = client_id.split('-');
		client_id = client_id[1];
		
		thisBlock.find('.block').hide();
		thisBlock.removeClass('green').removeClass('red').removeClass('yellow').addClass('loading');
		sortData = "client_id="+clientID+"&client_url="+url+"&client_name="+name+"&id="+clientBlockID+"&width="+subPanelWidth;
		thisBlock.load("get_data.php", sortData, function(){
			thisBlock.find('.block').fadeIn();
			thisBlock.removeClass('loading');
			if (thisBlock.find('.block').hasClass('green')){
				thisBlock.addClass('green');
			} else if (thisBlock.find('.block').hasClass('red')){
				thisBlock.addClass('red');
			} else if (thisBlock.find('.block').hasClass('yellow')){
				thisBlock.addClass('yellow');
			}
		});
	});
	</script><?
	
}

?>