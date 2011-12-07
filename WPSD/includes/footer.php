		<footer>
		
			<!-- Feel free to change this to whatever you'd like! -->
			<span class="large">&copy;2010 &mdash; A MindCork Creation</span>
			<!-- -->
			
			<?php // Are you signed in? Bring in the popup forms!
			if (!isset($signedout) && isset($_SESSION['$signed_in']) && $_SESSION['$signed_in'] && !$demo_mode){ ?>
			
			<!-- UPDATE INFORMATION
			Leave this intact to have dashboard and plugin updates show up here -->
			<span class="version-updates">
				<?php
				if ($wpsd_available_version > $wpsd_version){ ?>
					WP Status Dashboard v<?php echo number_format($wpsd_version,2); ?><br />
					<strong>UPDATE:</strong> <a class="update-available" href="http://demos.mindcork.com/wpstatus/update_packs/v<?php echo number_format($wpsd_version,2); ?>-<?php echo $wpsd_available_version; ?>.zip">Download the v<?php echo $wpsd_available_version; ?> Update Pack!</a>
				<?php } else { ?>
					WP Status Dashboard v<?php echo number_format($wpsd_version,2);
				} ?>
				<br />
				WP Plugin v<?php echo $wpsd_plugin_version; ?>
				(<a href="http://wordpress.org/extend/plugins/wp-status-dashboard/" target="_blank">Download</a>)
			</span>
			<!-- END UPDATE INFORMATION -->
			
			<?php } ?>
			
		</footer>

		<?php // Are you signed in? Bring in the popup forms!
		if (!isset($signedout) && isset($_SESSION['$signed_in']) && $_SESSION['$signed_in']){ ?>
			
			<!-- The black transparent background behind the popups -->
			<div class="blackout"></div>
			
			<!-- ADD CLIENT popup -->
			<div class="popup-wrapper add-client">
				<div class="popup">
					<h2>Add Client</h2>
					<form action="<?php echo $wpstatus_url; ?>scripts/ajax_requests/addClient.php" method="post" id="addClient">
						<input id="client_name" type="text" class="text blink" name="client_name" title="Client Name" value="Client Name" />
						<input id="client_url" type="text" class="text" name="client_url" value="http://" />
						<input type="hidden" name="add" value="1" />
						<input type="hidden" name="action" value="1" />
						<input type="hidden" id="addClientWidth" name="width" value="250" />
						<a class="button left"><span class="cancel">Cancel</span></a>
						<a class="button right"><span class="add-client">Add Client</span></a>
						<div class="cl"></div>
					</form>
				</div>
			</div>
			
			<!-- DELETE CLIENT popup -->
			<div class="popup-wrapper delete-client">
				<div class="popup">
					<h2>Delete Client?</h2>
					<form action="<?php echo $wpstatus_url; ?>scripts/ajax_requests/deleteClient.php" method="post" id="deleteClient">
						<p>Are you sure you want to delete this client?</p>
						<a class="button left"><span class="cancel">Cancel</span></a>
						<a class="button right"><span class="delete">Delete</span></a>
						<input type="hidden" name="action" value="1" />
						<input type="hidden" name="delete" value="" id="delete_client_id" />
						<div class="cl"></div>
					</form>
				</div>
			</div>
			
			<!-- EDIT CLIENT popup -->
			<div class="popup-wrapper edit-client">
				<div class="popup">
					<h2>Edit Client</h2>
					<form action="<?php echo $wpstatus_url; ?>scripts/ajax_requests/editClient.php" method="post" id="editClient">
						<input id="edit_name" type="text" class="text blink" name="edit_name" title="Client Name" value="" />
						<input id="edit_url" type="text" class="text" name="edit_url" value="" />
						<input type="hidden" name="edit_id" value="" id="edit_id" />
						<input type="hidden" name="edit" value="1" />
						<input type="hidden" name="action" value="1" />
						<a class="button left"><span class="cancel">Cancel</span></a>
						<a class="button right"><span class="update">Update Client</span></a>
						<div class="cl"></div>
					</form>
				</div>
			</div>
			
			<?php if ($demo_mode){ ?>
				<p class="demo-mode-text">This &ldquo;WordPress Status Dashboard&rdquo; is in <em>demo mode</em>. Some features like Add, Edit and Delete are disabled. You can <a target="_blank" href="http://www.youtube.com/watch?v=wkTXlLZ9iOk">Watch an Overview</a>, <a target="_blank" href="http://codecanyon.net/item/wordpress-status-dashboard/143800/?ref=jscheetz">Purchase on CodeCanyon</a> or share it with your friends &amp; followers:
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://codecanyon.net/item/wordpress-status-dashboard/143800/?ref=jscheetz" data-text="Keep track of your WordPress-powered clients with the WordPress Status Dashboard!" data-count="horizontal" data-via="mindcork" data-related="desabol:Dave Sabol, co-creator">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcodecanyon.net%2Fitem%2Fwordpress-status-dashboard%2F143800%2F%3Fref%3Djscheetz&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=dark&amp;height=21" scrolling="no" frameborder="0" class="facebook-share-button" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
				</p>
			<?php } ?>
			
		<?php } ?>
		
		<!-- End of the page, bring in the jQuery magic! -->
		<script type="text/javascript">var wpsd_version = '<?php echo $wpsd_version; ?>'; var demo_mode = <?php if ($demo_mode){ echo $demo_mode; } else { ?>''<?php } ?>;</script>
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.form.js"></script>
		<script type="text/javascript" src="scripts/custom_js.js"></script>
		
		<div id="scriptResponses"></div>
		
	</body>
</html>