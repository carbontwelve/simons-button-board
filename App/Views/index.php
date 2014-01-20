<div class="wrap">
	<h2>
		Button Board
		<a href="<?php echo admin_url(); ?>admin.php?page=button_board_add" class="add-new-h2">Add New</a>
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

	<ul class="subsubsub">
		<li class="all">
			<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=all" <?php if ($type === 'all'){ ?>class="current"<?php } ?>>
				All
				<span class="count">(<?php echo $count['all']; ?>)</span>
			</a>
			|
		</li>
		<li class="archive">
			<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=archived" <?php if ($type === 'archived'){ ?>class="current"<?php } ?>>
				Archived
				<span class="count">(<?php echo $count['archived']; ?>)</span>
			</a>
			|
		</li>
		<li class="trash">
			<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=deleted" <?php if ($type === 'deleted'){ ?>class="current"<?php } ?>>
				Trash
				<span class="count">(<?php echo $count['trash']; ?>)</span>
			</a>
		</li>
	</ul>
	<table class="wp-list-table widefat fixed buttons" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" id="id">ID</th>
				<th scope="col" id="url">Url</th>
				<th scope="col" id="author">Author</th>
				<th scope="col" id="date">Created</th>
				<th scope="col" id="button">Button</th>
				<th scope="col" id="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $row){ ?>
			<tr>
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->link_url; ?></td>
				<td><?php echo $row->author; ?><br/><?php echo $row->email; ?></td>
				<td><?php echo date('Y/m/d', strtotime($row->created_at)); ?></td>
				<td><img src="<?php echo $row->button_src; ?>" width="88" height="31"></td>
				<td>
					<a href="<?php echo admin_url(); ?>admin.php?page=button_board_edit&amp;id=<?php echo $row->id; ?>">
					Edit
					</a>
					|
					<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=disable&amp;id=<?php echo $row->id; ?>">
						Disable
					</a>
					 |
					<?php if ( $row->archived < 1 ){ ?> 
					<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=archive&amp;id=<?php echo $row->id; ?>">
						Archive
					</a>
					<?php }else{ ?>
					<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=unarchive&amp;id=<?php echo $row->id; ?>">
						Unarchive
					</a>
					<?php } ?>
					 | 
					<a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=ban&amp;id=<?php echo $row->id; ?>">
						Ban
					</a>
					 |
					<?php if ( is_null($row->deleted_at) ){ ?> 
					<a class="submitdelete" href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=trash&amp;id=<?php echo $row->id; ?>">
						Trash
					</a>
					<?php }else{ ?>
					<a class="submitdelete" href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;action=untrash&amp;id=<?php echo $row->id; ?>">
						Untrash
					</a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

</div>