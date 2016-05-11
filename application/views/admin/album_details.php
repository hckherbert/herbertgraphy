<?php $timestamp = time();?>
<?php $token = md5("unique_salt" . $timestamp);?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<title>HerbertGraphy Admin Control - Edit Album</title>
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
	<script src="<?php echo base_url('assets/js/album_control/OriginalPhotoData.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/album_control/Album_control.js'); ?>"></script>
	<script>

 var mAlbum_control = null;
 var mAlbum_id = "<?php echo $album_details->id ?>";
 var mParent_id = "<?php echo $album_details->parentId; ?>";

 $(document).ready
 (
	function()
	{
		mAlbum_control = new Album_control(mAlbum_id, mParent_id);

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
<div class="adminMain" id="page_album_details">
	<a class="menu_link" href="<?php echo site_url("admin/album_control"); ?>">Back to album list</a>
	<div class="section">
		<h1 class="pageHading">Album details</h1>
		<?php echo form_open('admin/album_control/update_album_info', 'class="formInfo" id="formUpdateAlbumInfo"'); ?>
		<table>
			<?php if (isset($album_details->parentName)) { ?>
			<tr>
				<td>Parent album:</td>
				<td>
					<div class="album_details_parent_album_name"><?php echo $album_details->parentName; ?></div>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td>Album name:</td>
				<td>
					<input name="name" type="text" placeholder="Enter the album name" value="<?php echo $album_details->name; ?>">
					<div class="error"></div>
				</td>
			</tr>
			<tr>
				<td>Album Label:</td>
				<td>
					<input name="label" type="text" placeholder="The url slug (letters, numbers and hyphens only)" value="<?php echo $album_details->label; ?>">
					<div class="error"></div>
				</td>
			</tr>
			<tr>
				<td>Album Intro:</td>
				<td>
					<textarea name="intro" placeholder="Type something to describe this album"><?php echo $album_details->intro; ?></textarea>
					<div class="error"></div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input name="submit" type="submit" value="Update">
				</td>
			</tr>
		</table>
		<input name="id" type="hidden" value="<?php echo $album_details->id; ?>">
		<?php echo form_close(); ?>
	</div>

	<?php if ($photo_data != NULL) { ?>
	<div class="section">
		<h1 class="pageHading">Photo list</h1>
		<?php echo form_open('admin/album_control/update_photo_data', 'class="formUploadPhotoData" id="formUploadPhotoData"'); ?>
		<?php foreach ($photo_data as $row) { ?>
		<div class="photo_data">
			<img class="uploadImgPreview" src="<?php echo  base_url("assets/photos/". $album_details->label."/".$row["hash_filename"]); ?>">
			<p class="original_filename"><?php echo $row["slug_filename"]; ?></p>
			<input name="original_filename[]" value="<?php echo $row["slug_filename"]; ?>" type="hidden">
			<input name="new_filename[]" value="<?php echo $row["slug_filename"]; ?>" type="text" placeholder="Rename me if possible" pattern="^[a-zA-Z0-9-_]+$" maxlength="50">
			<span class="error hide">Number, letters and hyphens only</span>
			<input name="title[]" value="<?php echo $row["title"]; ?>" type="text" placeholder="Give me a title if you wish" maxlength="100">
			<textarea name="desc[]"  placeholder="Say something about me if you wish" maxlength="500"><?php echo $row["desc"]; ?></textarea>
			<input name="del_id[]" type="checkbox" value="<?php echo $row["photoId"]; ?>">Remove
			<input name="photo_id[]" type="hidden" value="<?php echo $row["photoId"]; ?>">
		</div>
		<?php } ?>
		<div class="clear"></div>
		<input name="submit" type="submit" value="Update">
		<?php echo form_close(); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if ($album_details->parentId == NULL) { ?>
	<div class="section">
		<h1 class="pageHading">Sub-album List</h1>
		<?php
		echo form_open('admin/album_control/update_album_list', 'class="formAlbumList hide" id="formSubAlbumList"');
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
		<p class="hide label_no_album">There is no subalbum</p>
		<div class="clear"></div>
	</div>

	<div class="section">
		<h1 class="pageHading">Add a sub-album under <em><?php echo $album_details->name; ?></em></h1>
		<?php echo form_open('admin/album_control/add_subalbum', 'class="formInfo" id="formAddSubAlbum"'); ?>
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
			<tr>
				<td></td>
				<td>
					<input name="submit" type="submit" value="Add">
				</td>
			</tr>
		</table>
		<input name="parentId" value="<?php echo $album_details->id; ?>" type="hidden">
		<?php echo form_close(); ?>
	</div>
<?php } ?>

	<div class="section">
		<h1 class="pageHading">Delete album</h1>
		<?php echo form_open('admin/album_control/delete_album', 'class="formDeleteAlbum" id="formDeleteAlbum"'); ?>
		<p>Delete this album? <?php if ($album_details->parentId == NULL) { ?> All sub-albums will be removed also.<?php } ?></p>
		<input name="id" value="<?php echo $album_details->id; ?>" type="hidden">
		<input name="order" value="<?php echo $album_details->order; ?>" type="hidden">
		<input name="parentId" value="<?php echo $album_details->parentId; ?>" type="hidden">
		<input name="submit" type="submit" value="OK">
		<?php echo form_close(); ?>
		<div class="clear"></div>
	</div>
</div>
</body>
</html>
