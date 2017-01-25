<body>
<?php $this->load->partials("admin/templates/partials/common_body"); ?>
<div class="adminMain" id="page_add_subalbum">
	<?php $this->load->partials("admin/templates/partials/menu"); ?>
	<?php if (!isset($authUrl)) { ?>
	<div class="section" id="sectionAddAlbum">
		<h1 class="pageHeading">Add a sub-album</h1>
		<div class="hintArea">
			<p>Hints:</p>
			<p>- If you choose to remove the currently featured photo, the album will remain no featured photo.</p>
			<p>- Aspect ratio will apply to <em>every</em> photo of this album. Please </p>
		</div>
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
			<tr>
				<td>Aspect Ratio:</td>
				<td>
					<select name="aspect_ratio">
						<option value="1.5">4:3</option>
						<option value="1.0">1:1</option>
						<option value="1.77">16:9</option>
					</select>
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
	<?php } ?>
</div>
</body>
<script>

	var mAlbum_control = null;
	var mParent_id = "<?php echo $album_details->id; ?>";

	$(document).ready
	(
		function()
		{
			if ($("input[name='name']").val()!="")
			{
				location.href = GLOBAL_SITE_URL + "/admin/album_control/album_details/" + <?php echo $album_details->id; ?>
			}

			mAlbum_control = new Album_control(null, mParent_id);

		}
	);
</script>
</html>
