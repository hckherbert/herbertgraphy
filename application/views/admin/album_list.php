<body>
<?php $this->load->partials("admin/templates/partials/common_body");?>
<div class="adminMain" id="page_album_list">
	<?php $this->load->partials("admin/templates/partials/menu"); ?>
	<?php if (!isset($authUrl)) { ?>
	<div class="section">
		<h1 class="pageHeading">Album List</h1>
		<div class="hintArea">
			<p>Drag the row upper to make the album positioned higher in the client side.</p>
		</div>
		<?php echo form_open('admin/album_control/update_album_list', 'class="formAlbumList hide" id="formAlbumList"'); ?>
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
	<div class="section" id="sectionAddAlbum">
		<h1 class="pageHeading">Add New Album</h1>
		<div class="hintArea">
			<p>Hints:</p>
			<p>If you choose to remove the currently featured photo, the album will remain no featured photo.</p>
		</div>
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
	<?php } ?>
</div>
</body>
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
</html>
