<!--

Weird file, I know.

We needed to have a javascript include file that had PHP variables injected in it, so this is our solution.
If anyone has a better one, please let us know!

-->

<script type="text/javascript">

// Demo mode stuff (this doesn't slow down anything, so just leave it be, unless you know what you're doing)
var demo_mode = '<?php echo $demo_mode; ?>';

$('#client-block-<?php echo $client_id; ?> .edit').click(function(){

	// In demo mode? Disable it.
	if (!demo_mode){
	
		var clientID = this.id;
		clientID = clientID.split('-');
		clientID = clientID[1];
			
		$('.popup-wrapper.edit-client').find('#edit_id').val(clientID);
		
		clientName = $('#client-block-<?php echo $client_id; ?>').find('h2 a').attr('title');
		$('.popup-wrapper.edit-client').find('#edit_name').val(clientName);
	
		clientURL = $('#client-block-<?php echo $client_id; ?>').find('h2 a').attr('href');
		$('.popup-wrapper.edit-client').find('#edit_url').val(clientURL);
		
		// Open the Edit popup
		$('.blackout').show();
		$('.popup-wrapper.edit-client').fadeIn('normal');
		$('.popup-wrapper.edit-client').addClass('client-id-<?php echo $client_id; ?>');
	  	
	} else { demo_alert(); }
		
});
	
$('#client-block-<?php echo $client_id; ?> .delete').click(function(){
	
	// In demo mode? Disable it.
	if (!demo_mode){
		var clientID = this.id;
		clientID = clientID.split('-');
		clientID = clientID[1];
		
		$('.delete-client').find('#delete_client_id').val(clientID);
		
		// Open the Delete popup
		$('.blackout').show();
		$('.popup-wrapper.delete-client').fadeIn('normal');
		$('.popup-wrapper.delete-client').addClass('client-id-<?php echo $client_id; ?>');
		
		var deleteClientPopup = $('.popup-wrapper.delete-client.client-id-<?php echo $client_id; ?>');
		deleteClientPopup.find('.delete').click(function(){
	  		deleteClientPopup.find('form').ajaxSubmit({
				success: deleteClientResponse
			});
	  	});
		
		initiate_blackout();	
	} else { demo_alert(); }
});
	
$('#client-block-<?php echo $client_id; ?> .refresh').click(function(){
		
	var minimum_panel_size = 220;
	var panel_margin = 10;
	var total_panel_width = minimum_panel_size + panel_margin;
		
	var clientID = this.id;
	clientID = clientID.split('-');
	clientID = clientID[1];
		
	var thisBlock = $(this).parent().parent().parent();

	var contentwidth = $('.website-blocks').width();
	var toFit = Math.floor(contentwidth / total_panel_width);
	var currentPanelWidthTotal = toFit * total_panel_width;
	var newPanelWidth = contentwidth - currentPanelWidthTotal;
	var newPanelWidth = Math.floor(newPanelWidth / toFit);
	var newPanelWidth = minimum_panel_size + newPanelWidth;
	var newPanelWidth = newPanelWidth - 2;
	var subPanelWidth = newPanelWidth - 42;
	
	clientBlockID = thisBlock.attr('id');
	var clientID = this.id;
	clientID = clientID.split('-');
	clientID = clientID[1];
		
	var name = $('#client-block-<?php echo $client_id; ?>').find('h2 a').attr('title');
	var url = $('#client-block-<?php echo $client_id; ?>').find('h2 a').attr('href');
	
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

// Demo mode alert function
function demo_alert(){
	alert('Not available in demo mode.');
}

</script>