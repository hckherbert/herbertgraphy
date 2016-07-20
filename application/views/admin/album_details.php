<body>
<?php $this->load->partials("admin/templates/partials/common_body"); ?>
<div class="adminMain" id="page_album_details">
	<?php $this->load->partials("admin/templates/partials/menu"); ?>
	<div class="section">
		<h1 class="pageHeading">Album details</h1>
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
		<h1 class="pageHeading">Photo list</h1>
		<div class="hintArea">
			<p>Hints:</p>
			<p>If you choose to remove the currently featured photo, the album will remain no featured photo.</p>
		</div>
		<?php echo form_open('admin/album_control/update_photo_data', 'class="formUpdatePhotoData" id="formUpdatePhotoData"'); ?>
		<?php foreach ($photo_data as $row) { ?>
		<div class="photo_data<?php if ($row["featured"] == "1"){ ?> featured<?php }?>" data-photoId="<?php echo $row["photoId"]; ?>">
			<img class="uploadImgPreview" src="<?php echo  base_url("assets/photos/". $album_details->label."/".$row["hash_filename"]); ?>">
			<p class="original_filename"><?php echo $row["slug_filename"]; ?></p>
			<input name="original_filename[]" value="<?php echo $row["hash_filename"]; ?>" type="hidden">
			<input name="original_slug[]" value="<?php echo $row["slug_filename"]; ?>" type="hidden">
			<input name="new_filename[]" value="<?php echo $row["slug_filename"]; ?>" type="text" placeholder="Rename me if possible" pattern="^[a-zA-Z0-9-_]+$" maxlength="50">
			<span class="error hide">Number, letters and hyphens only</span>
			<input name="title[]" value="<?php echo $row["title"]; ?>" type="text" placeholder="Give me a title if you wish" maxlength="100">
			<textarea name="desc[]"  placeholder="Say something about me if you wish" maxlength="500"><?php echo $row["desc"]; ?></textarea>
			<label><input name="del_id[]" type="checkbox" value="<?php echo $row["photoId"]; ?>">Remove</label>
			<br>
			<label><input name="featured[]" type="radio" value="<?php echo ($row["featured"] == "1") ? $row["photoId"] : "0" ?>" <?php if ($row["featured"] == 1) { ?>checked<?php } ?>>Featured</label>
			<input name="photo_id[]" type="hidden" value="<?php echo $row["photoId"]; ?>">
		</div>
		<?php } ?>
		<div class="clear"></div>
		<input name="submit" type="submit" value="Update">
		<?php echo form_close(); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="section" id="sectionAddAlbum">
		<?php if ($photo_data != NULL) { ?>
		<h1 class="pageHeading">Add more photos</h1>
		<div class="hintArea">
		<p>Hints:</p>
			<p>1. Setting any additional featured will remove the current assignment of the featured photo, if any, and vise versa.</p>
			<p>2. If you choose to remove the currently featured photo, the album will remain no featured photo.</p>
		</div>
		<?php } else {?>
		<h1 class="pageHeading">Upload photos</h1>
		<?php } ?>
		<div id="uploaderWrapper">
			<form>
				<div id="queue"></div>
				<input type="hidden" name="existing_label" value="<?php echo $album_details->label; ?>">
				<input type="hidden" name="albumId" value="<?php echo $album_details->id; ?>">
				<input id="file_upload" name="file_upload" type="file" multiple="true" accept="image/png, image/gif, image/jpg">
				<input name="photo_user_data" type="hidden" value="">
				<div class="clear"></div>
			</form>
		</div>
		<input name="submit" type="button" value="Add">
		<div class="clear"></div>
	</div>

	<?php if ($album_details->parentId == NULL) { ?>
	<div class="section">
		<h1 class="pageHeading">Sub-album List</h1>
		<div class="hintArea">
			<p>Drag the row upper to make the album positioned higher in the client side.</p>
		</div>
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
		<?php echo form_open('admin/album_control/go_add_subalbum', 'class="formInfo" id="formGoAddSubAlbum"'); ?>
		<h1 class="pageHeading">Add a sub-album under <em><?php echo $album_details->name; ?></em></h1>
		<input type="hidden" name="albumId" value="<?php echo $album_details->id; ?>">
		<input name="submit" type="submit" value="Go">
		<?php echo form_close(); ?>
		<div class="clear"></div>
	</div>
<?php } ?>

	<div class="section">
		<h1 class="pageHeading">Delete album</h1>
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
<script>

	var mAlbum_control = null;
	var mAlbum_id = "<?php echo $album_details->id ?>";
	var mParent_id = "<?php echo $album_details->parentId; ?>";
	var mParentLabel = "<?php echo $album_details->name; ?>";

	$(document).ready
	(
		function()
		{
			mAlbum_control = new Album_control(mAlbum_id, mParent_id, mParentLabel);

		}
	);
</script>
</html>
