$(document).ready( function (){
			
	// References
	var loading = $(".loading");
	var siteBlockID = '';
	
	var minimum_panel_size = 220;
	var panel_margin = 10;
	var total_panel_width = minimum_panel_size + panel_margin;
	var initiated_buttons = false;
	var blocksTotal = $('.block-wrapper').size();
	var blocksLoaded = 0;
	
	$('.refresh-all').parent().animate({'opacity':0.4},200);
	
	updateProgressBar(0,blocksTotal);
	
	var minimum_panel_size = 220;
	var panel_margin = 10;
	var total_panel_width = minimum_panel_size + panel_margin;
	var blocksTotal = $('.block-wrapper').size();
	var blocksLoaded = 0;
	
	$('.block-wrapper').each(function(){
		
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
		sortData = "client_id="+client_id+"&client_url="+url+"&client_name="+name+"&width="+subPanelWidth;
		thisBlock.html('<span class="loading-name">Loading '+name+'...</span>');
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
			blocksLoaded++;
			updateProgressBar(blocksLoaded,blocksTotal);
			if (blocksLoaded == blocksTotal) { $('.refresh-all').parent().animate({'opacity':1},200); }
				
		});
		
	});

	
 	panelresize(); // Triggers when document first loads    

 	$(window).bind("resize", function(){ // Adjusts image when browser resized
 		panelresize();
 	});
 	
 	/* Navigation Buttons */
 	$('nav .button').click(function(){
 		var buttonName = $(this).find('span').attr('class');
 		switch(buttonName){
 			case 'add-client':
 				if (!demo_mode){
 					// Open the Add Client popup
 					$('.blackout').show();
 					$('.popup-wrapper.add-client').fadeIn('normal');
 				} else { demo_alert(); }
 			break;
 			case 'refresh-all':
 			
 				updateProgressBar(0,blocksTotal);
 				
 				if (blocksTotal == blocksLoaded) {
		  			blocksLoaded = 0;
		  			$('.refresh-all').parent().animate({'opacity':0.4},200);
			  		$('.block-wrapper').removeClass('green').removeClass('red').removeClass('yellow');
			  		$('.block-wrapper').addClass('loading');
			  		$('.block').hide();
					$('.block-wrapper').each(function(){
					
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
						var url = thisBlock.find('h2 a').attr('href');
						var name = thisBlock.find('h2 a').attr('title');
						var client_id = thisBlock.attr('id');
						client_id = client_id.split('-');
						client_id = client_id[1];
						sortData = "client_id="+client_id+"&client_url="+url+"&client_name="+name+"&id="+clientBlockID+"&width="+subPanelWidth;
						thisBlock.html('<span class="loading-name">Loading '+name+'...</span>');
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
							blocksLoaded++;
							updateProgressBar(blocksLoaded,blocksTotal);
							if (blocksTotal == blocksLoaded) { $('.refresh-all').parent().animate({'opacity':1},200); }
						});
						
					});
				}
 			break;
 		}
 	});
 	
 	/* Popup Buttons */
 	$('.popup .button').click(function(){
 		var buttonName = $(this).find('span').attr('class');
 		switch(buttonName){
 			case 'cancel':
 				// Cancel and close window
 				$('.popup-wrapper').fadeOut('fast',function(){
 					$('.blackout').fadeOut('fast');
 				});
 			break;
 			case 'add-client':
 				// Add Client
 			break;
 		}
 	});
 	
 	/* Add Client Button */
 	var addClientPopup = $('.popup-wrapper.add-client');
 	addClientPopup.find('.add-client').click(function(){
 		var client_name = addClientPopup.find('#client_name').val();
 		var client_url = addClientPopup.find('#client_url').val();
 		if (client_name != 'Client Name' && client_name != ''){
 			if (client_url != 'http://' && client_url != ''){
 				addClientPopup.find('form').ajaxSubmit({
					success: addClientResponse
				});
 			} else {
 				alert('Client URL is a required field.');
 			}
 		} else {
 			alert('Client Name is a required field.');
 		}
  	});
  	
  	addClientPopup.find('input.text').keypress(function(e){
  		if(e.which == 13){
  			var client_name = addClientPopup.find('#client_name').val();
	 		var client_url = addClientPopup.find('#client_url').val();
	 		if (client_name != 'Client Name' && client_name != ''){
	 			if (client_url != 'http://' && client_url != ''){
	 				addClientPopup.find('form').ajaxSubmit({
						success: addClientResponse
					});	
	 			} else {
	 				alert('Client URL is a required field.');
	 			}
	 		} else {
	 			alert('Client Name is a required field.');
	 		}
	 		return false;
	 		e.preventDefault();
   		}
  	});
  	
  	/* Sign-In Form Button */
  	$('.signin').click(function(){
  		$(this).parent().parent().submit();
  	});
  	
  	$('#signIn').find('input.text').keypress(function(e){
  		if(e.which == 13){
  			$(this).parent().submit();
	 		return false;
	 		e.preventDefault();
   		}
  	});
 
	/* Textbox "text clear" Functionality */
	$('.blink').focus(function () {
		if ($(this).val() == $(this).attr('title')) {
			$(this).val('');
		}
	}).blur(function () {
		if ($(this).val() == '') {
			$(this).val($(this).attr('title'));
		}
	});
	
	var cookieID = $('#wpsdMessages a.hide').attr('id');
	
	if (getCookie('hideMessage_id'+cookieID) != 'true'){
		$('#wpsdMessages').slideDown('normal');
	}
	
	$('#wpsdMessages a.hide').click(function(){
		var cookieID = this.id;
		setCookie('hideMessage_id'+cookieID,'true',30);
		$(this).parent().slideUp('normal');
	});
	
	initiate_blackout();
	
	// Edit Client Popup Functions
	var editClientPopup = $('.popup-wrapper.edit-client');
	editClientPopup.find('.update').click(function(){
  		var client_name = editClientPopup.find('#edit_name').val();
 		var client_url = editClientPopup.find('#edit_url').val();
 		if (client_name != 'Client Name' && client_name != ''){
 			if (client_url != 'http://' && client_url != ''){
 				editClientPopup.find('form').ajaxSubmit({
					success: editClientResponse
				});
 			} else {
 				alert('Client URL is a required field.');
 			}
 		} else {
 			alert('Client Name is a required field.');
 		}
  	});
  	
  	// This is a function that allows the "enter" key to be pressed within the field to submit
  	$('input.text').keypress(function(e){
  		if(e.which == 13){
  			var client_name = editClientPopup.find('#edit_name').val();
	 		var client_url = editClientPopup.find('#edit_url').val();
	 		if (client_name != 'Client Name' && client_name != ''){
	 			if (client_url != 'http://' && client_url != ''){
	 				editClientPopup.find('form').ajaxSubmit({
						success: editClientResponse
					});
	 			} else {
	 				alert('Client URL is a required field.');
	 			}
	 		} else {
	 			alert('Client Name is a required field.');
	 		}
	 		return false;
	 		e.preventDefault();
   		}
  	});

});

function panelresize() {
	
	var minimum_panel_size = 220;
	var panel_margin = 10;
	var total_panel_width = minimum_panel_size + panel_margin;

	var contentwidth = $('.website-blocks').width();
	var toFit = Math.floor(contentwidth / total_panel_width);
	var currentPanelWidthTotal = toFit * total_panel_width;
	var newPanelWidth = contentwidth - currentPanelWidthTotal;
	var newPanelWidth = Math.floor(newPanelWidth / toFit);
	var newPanelWidth = minimum_panel_size + newPanelWidth;
	var newPanelWidth = newPanelWidth - 2;
	var subPanelWidth = newPanelWidth - 42;
	
	$('.block-wrapper').css({'width':newPanelWidth+'px'});
	$('.block').css({'width':subPanelWidth+'px'});
	$('#addClientWidth').val(newPanelWidth);
	
	var newContentwidth = $('.website-blocks').width();
	if (newContentwidth > contentwidth) {
		panelresize();
	}
}

/* Clicking the Blackout */
function initiate_blackout(){
	$('.blackout').click(function(){
		// Cancel and close window
		$('.popup-wrapper').fadeOut('fast',function(){
			$('.blackout').fadeOut('fast');
		});
	});
}

function updateProgressBar(blocksLoaded,blocksTotal){
	barWidth = Math.floor((blocksLoaded / blocksTotal) * 100);
	$('.progress-bar').fadeIn('fast');
	$('.bar').show().width(barWidth+'%');
	$('.bar span').html('Loaded '+blocksLoaded+' of '+blocksTotal+'...');
	if (blocksLoaded == blocksTotal){
		$('.progress-bar').fadeOut('slow');
	}
}

function demo_alert(){
	alert('Not available in demo mode.');
}

function setCookie(c_name,value,expiredays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
}

function getCookie(c_name){
	if (document.cookie.length>0){
  		c_start=document.cookie.indexOf(c_name + "=");
  		if (c_start!=-1){
   			c_start=c_start + c_name.length+1;
    		c_end=document.cookie.indexOf(";",c_start);
    		if (c_end==-1) c_end=document.cookie.length;
    		return unescape(document.cookie.substring(c_start,c_end));
    	}
  	}
	return "";
}

function reloadAfterEdit(client_info){
	
	var client_info = client_info.split(',');
	var client_id = client_info[0];
	var client_name = client_info[1];
	var client_url = client_info[2];

	var clientBlock = $('#client-block-'+client_id);
					
	var minimum_panel_size = 220;
	var panel_margin = 10;
	var total_panel_width = minimum_panel_size + panel_margin;

	clientID = client_id;
		
	var thisBlock = clientBlock.parent();

	var contentwidth = $('.website-blocks').width();
	var toFit = Math.floor(contentwidth / total_panel_width);
	var currentPanelWidthTotal = toFit * total_panel_width;
	var newPanelWidth = contentwidth - currentPanelWidthTotal;
	var newPanelWidth = Math.floor(newPanelWidth / toFit);
	var newPanelWidth = minimum_panel_size + newPanelWidth;
	var newPanelWidth = newPanelWidth - 2;
	var subPanelWidth = newPanelWidth - 42;
	
	clientBlockID = thisBlock.attr('id');
	
	var name = client_info[1];
	var url = client_info[2];
	
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
}

function addClientResponse(responseText, statusText, xhr, $form) {
	$('.website-blocks').prepend(responseText);
	$('.popup-wrapper').fadeOut('fast',function(){
		$('.blackout').fadeOut('fast');
	});
}

function deleteClientResponse(responseText, statusText, xhr, $form) {
	$('#scriptResponses').html(responseText);
	$('.popup-wrapper').fadeOut('fast',function(){
		$('.blackout').fadeOut('fast');
	});
}

function editClientResponse(responseText, statusText, xhr, $form) {
	reloadAfterEdit(responseText);
	$('.popup-wrapper').fadeOut('fast',function(){
		$('.blackout').fadeOut('fast');
	});
}