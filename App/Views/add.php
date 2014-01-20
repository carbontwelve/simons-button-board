<div class="wrap">
	<h2>
		Add New Button
	</h2>

	<?php if($flashMessages['success'] !== false){ ?>
	<div id="message" class="updated below-h2">
		<p><?php echo $flashMessages['success']; ?></p>
	</div>
	<?php } ?>
	<?php if($flashMessages['error'] !== false){ ?>
	<div id="message" class="error below-h2">
		<p><?php echo $flashMessages['error']; ?></p>
	</div>
	<?php } ?>


	<form method="post" action="<?php echo admin_url(); ?>admin.php?page=button_board_add?action=update">

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="banner_author">Banner Author</label></th>
					<td><input name="banner_author" type="text" id="banner_author" value="" class="regular-text" placeholder="Joe Blogs"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="banner_author_email">Author Email</label></th>
					<td><input name="banner_author_email" type="text" id="banner_author_email" value="" class="regular-text" placeholder="joe.blogs@example.com"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="banner_image_src">Banner Image Src</label></th>
					<td><input name="banner_image_src" type="text" id="banner_image_src" value="" class="regular-text" placeholder="http://www.example.com/banner.gif"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="banner_link_url">Banner Link URL</label></th>
					<td><input name="banner_link_url" type="text" id="banner_link_url" value="" class="regular-text" placeholder="http://www.example.com"></td>
				</tr>
			</tbody>
		</table>

	</form>

</div>