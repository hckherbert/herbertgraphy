<?php $timestamp = time();?>
<?php $token = md5("unique_salt" . $timestamp);?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<title>HerbertGraphy Admin Control - Album List</title>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta name="keywords" content="">
<title></title>
<!-- ICON -->
<link href="apple-touch-icon.png" rel="apple-touch-icon" />
<link href="apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
<link href="apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
<link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
<link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
<link href="android-icon-192x192.png" rel="icon" sizes="192x192" />
<link href="android-icon-128x128.png" rel="icon" sizes="128x128" />
<!-- CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.jscrollpane.css'); ?>" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/uploadifive.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/zindex.css'); ?>" type="text/css" />
<!-- FONT -->
<link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
<!-- Javascript -->
<script>
	GLOBAL_SITE_URL = "<?php echo site_url(); ?>";
	var mTimeStamp = "<?php echo $timestamp;?>";
	var mToken = "<?php echo md5('unique_salt' . $timestamp);?>";
</script>
<script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.jscrollpane.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/album_control/jquery.uploadifive.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/album_control/Album_control.js'); ?>"></script>
<script>

 var mAlbum_control = null;
 var mParent_id = "<?php echo $album_details->id; ?>";

 $(document).ready
 (
	function()
	{
		mAlbum_control = new Album_control(null, mParent_id);

	}
  );
</script>
</head>
<body>
<div class="ajaxSuccessDisplay hide">
	<div class="bg"></div>
	<p>Ajax Response success</p>
</div>
<div class="ajaxFailDisplay hide">
	<div class="bg"></div>
	<p>Ajax Response Failed</p>
</div>
<div class="adminMain" id="page_add_subalbum">
	<a class="menu_link" href="<?php echo site_url("admin/album_control"); ?>">Back to album list</a>
	<a class="menu_link" href="<?php echo site_url("admin/album_control/album_details/$album_details->id"); ?>">Back to parent album (<?php echo $album_details->name; ?>)</a>
	<div class="section" id="sectionAddAlbum">
		<h1 class="pageHeading">Add a sub-album</h1>
		<?php echo form_open('admin/album_control/do_add_subalbum', 'class="formInfo" id="formAddAlbum"'); ?>
		<table>
			<tr>
				<td>Parent album:</td>
				<td>
					<div class="album_details_parent_album_name"><?php echo $album_details->name; ?></div>
				</td>
			</tr>
			<tr>
				<td>Album name:</td>
				<td>
					<input name="name" type="text" placeholder="Enter the album name">
					<div class="error"></div>
				</td>
			</tr>
			<tr>
				<td>Album Label:</td>
				<td>
					<input name="label" type="text" placeholder="The url slug (letters, numbers and hyphens only)">
					<div class="error"></div>
				</td>
			</tr>
			<tr>
				<td>Album Intro:</td>
				<td>
					<textarea name="intro" placeholder="Type something to describe this album"></textarea>
					<div class="error"></div>
				</td>
			</tr>
		</table>
		<input type="hidden" name="parentId" value="<?php echo $album_details->id; ?>">
		<?php echo form_close(); ?>
		<div id="uploaderWrapper">
			<form>
				<div id="queue"></div>
				<input type="hidden" name="albumId" value="">
				<input id="file_upload" name="file_upload" type="file" multiple="true" accept="image/png, image/gif, image/jpg">
				<input name="photo_user_data" type="hidden" value="">
				<div class="clear"></div>
			</form>
		</div>

		<input name="submit" type="button" value="Add">
		<div class="clear"></div>

	</div>
</div>
</body>
</html>
