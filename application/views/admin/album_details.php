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
<link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/zindex.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.jscrollpane.css'); ?>" type="text/css" />
<!-- FONT -->
<link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
<!-- Javascript -->
<script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.jscrollpane.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/album_control/jquery.history.js'); ?>"></script>
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
<div class="adminMain">
	<div class="section">
		<h1 class="pageHading">Album details</h1>
		<?php echo form_open('admin/album_control/update_album_info', 'class="formInfo" id="formUpdateAlbumInfo"'); ?>
		<table>
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
		<input name="id" type="hidden" value="<?php echo $album_id; ?>">
		<?php echo form_close(); ?>
	</div>

	<div class="section">
		<h1 class="pageHading">Sub-album List</h1>
		<?php
		if (count($sub_albums)) {
			echo form_open('admin/album_control/update_album_list','id="formSubAlbumList"');
		?>
		<table class="albumList listing">
			<thead>
				<th width="25%">Album name</th>
				<th width="20%">Album Label</th>
				<th width="45%">Album Intro</th>
				<th width="5%">Delete</th>
				<th width="5%"></th>
			</thead>
			<tbody>
			<?php foreach ($sub_albums as $album): ?>
				<tr>
					<td><?php echo $album["name"]; ?></td>
					<td><?php echo $album["label"]; ?></td>
					<td><?php echo $album["intro"]; ?></td>
					<td align="center">
						<input name="id[]" type="hidden" value="<?php echo $album["id"]; ?>">
						<input name="del_id[]" type="checkbox" value="<?php echo $album["id"]; ?>">
						<input name="order[]" type="hidden" value="<?php echo $album["order"]; ?>">
					</td>
					<td align="center"><input name="edit[]" type="button" value="Edit"></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<input name="submit" type="submit" value="Update">
		<?php echo form_close(); ?>
		<?php
		}
		else
		{?>
		<p class="label_no_album">There is no subm-album</p>
			<div class="hide firstAdded">
				<?php echo form_open('admin/album_control/update_album_list', 'class="formAlbumList" id="formAlbumList"'); ?>
				<table class="albumList listing">
					<thead>
					<th width="25%">Album name</th>
					<th width="20%">Album Label</th>
					<th width="45%">Album Intro</th>
					<th width="5%">Delete</th>
					<th width="5%"></th>
					</thead>
					<tbody>
					</tbody>
				</table>
				<input name="submit" type="submit" value="Update">
				<?php echo form_close(); ?>
			</div>
		<?php } ?>
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
</div>
</body>
</html>
