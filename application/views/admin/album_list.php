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


 $(document).ready
 (
	function()
	{
		mAlbum_control = new Album_control();

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
<div class="adminMain" id="page_album_list">
	<div class="section">
		<h1 class="pageHading">Album List</h1>
		<?php

			echo form_open('admin/album_control/update_album_list', 'class="formAlbumList hide" id="formAlbumList"');
		?>
		<table class="albumList listing">
			<thead>
				<th width="25%">Album name</th>
				<th width="20%">Album Label</th>
				<th width="45%">Album Intro</th>
				<th width="5%">Delete</th>
				<th width="5%"></th>
			</thead>
			<tbody></tbody>
		</table>
		<input name="submit" type="submit" value="Update">
		<?php echo form_close(); ?>
		<p class="hide label_no_album">There is no album</p>
		<div class="clear"></div>
	</div>
	<div class="section">
		<h1 class="pageHading">Add New Album</h1>
		<?php echo form_open('admin/album_control/add_album', 'class="formInfo" id="formAddAlbum"'); ?>
		<table>
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

		<div id="uploaderWrapper">
			<form>
				<div id="queue"></div>
				<input id="file_upload" name="file_upload" type="file" multiple="true">
				<a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a>
				<div class="clear"></div>
			</form>
		</div>

		<script type="text/javascript">

			var mQueueItemCount = 0;
			var mUploadedCount = 0;

			<?php $timestamp = time();?>
			$(function() {
				$('#file_upload').uploadifive({
					'auto'             : false,
					'buttonText'		: "drop files to me or click me",
					'buttonClass'		:  "dropButton",
					//'checkScript'      : 'check-exists.php',
					//'checkScript'      : '<?php echo site_url(); ?>admin/album_control/check_exist',
					'formData'         : {
						'timestamp' : '<?php echo $timestamp;?>',
						'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
					},
					'queueID'          : 'queue',
					//'uploadScript'     : 'uploadifive.php',
					'uploadScript'     : '<?php echo site_url(); ?>admin/album_control/upload',
					'dnd': true,
					'itemTemplate'	   : "<div class='uploadifive-queue-item'><span class='filename'></span><span class='fileinfo'></span><div class='close'></div><div class='progress'><div class='progress-bar'></div></div></div>",
					'onAddQueueItem'       : function(file)
					{
						$("#uploadifive-file_upload-file-" + mQueueItemCount).attr("data-filename", file.name);

						mQueueItemCount++;

						var reader = new FileReader();
						reader.onload = function(e)
						{
							$(".uploadifive-queue-item[data-filename='" + e.target.filename + "']").append("<img class='uploadImgPreview' src='" + e.target.result + "' /></p>");
						}

						reader.filename = file.name
						reader.readAsDataURL(file);

					},
					'onUploadComplete' : function(file, data)
					{
						mUploadedCount++;

						if (mQueueItemCount == mUploadedCount)
						{
							$('#file_upload').uploadifive('clearQueue');

							mUploadedCount = 0;
							mQueueItemCount = 0;
						};
					}
				});
			});
		</script>

		<input name="submit" type="submit" value="Add">
		<div class="clear"></div>
		<?php echo form_close(); ?>
	</div>
</div>
</body>
</html>
