<?php

require_once('../../includes/config.php');
require_once('../../includes/mysql.php');

if (isset($_POST['delete']) && $_POST['delete']){
	
	$delete = $_POST['delete'];
	$sql = "DELETE FROM wpsd_clients WHERE client_id = $delete ";
	if (!$queryResource = mysql_query($sql)) { trigger_error('Query error ' . mysql_error() . ' SQL: ' . $sql); }
	
}

?><script type="text/javascript">
	$('#client-<?php echo $delete; ?>').fadeOut('normal');
</script>