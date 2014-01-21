<div class="wrap">
    <h2>
        Button Board
        <a href="<?php echo admin_url(); ?>admin.php?page=button_board_add" class="add-new-h2">Add New</a>
    </h2>

    <?php if ($flashMessages['success'] !== false) { ?>
        <div id="message" class="updated below-h2">
            <p><?php echo $flashMessages['success']; ?></p>
        </div>
    <?php } ?>
    <?php if ($flashMessages['error'] !== false) { ?>
        <div id="message" class="error below-h2">
            <p><?php echo $flashMessages['error']; ?></p>
        </div>
    <?php } ?>

    <ul class="subsubsub">
        <li class="all">
            <a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=all"
               <?php if ($type === 'all'){ ?>class="current"<?php } ?>>
                All
                <span class="count">(<?php echo $count['all']; ?>)</span>
            </a>
            |
        </li>
        <li class="archive">
            <a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=archived"
               <?php if ($type === 'archived'){ ?>class="current"<?php } ?>>
                Archived
                <span class="count">(<?php echo $count['archived']; ?>)</span>
            </a>
            |
        </li>
        <li class="trash">
            <a href="<?php echo admin_url(); ?>admin.php?page=button_board_index&amp;type=deleted"
               <?php if ($type === 'deleted'){ ?>class="current"<?php } ?>>
                Trash
                <span class="count">(<?php echo $count['trash']; ?>)</span>
            </a>
        </li>
    </ul>
    <table class="wp-list-table widefat fixed buttons" cellspacing="0">
        <thead>
        <tr>
            <th scope="col" id="id" style="width:20px;text-align: center;">ID</th>
            <th scope="col" id="url" style="width:200px">Url</th>
            <th scope="col" id="author">Author</th>
            <th scope="col" id="date">Created</th>
            <th scope="col" id="button" style="width:88px;">Button</th>
            <th scope="col" id="views" style="width:50px;text-align: center;">Views</th>
            <th scope="col" id="hits" style="width:50px;text-align: center;">Clicks</th>
            <th scope="col" id="ctr" style="width:50px;text-align: center;">CTR</th>
            <th scope="col" id="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td style="text-align: center;vertical-align:middle;"><?php echo $row->id; ?></td>
                <td style="vertical-align:middle;"><?php echo $row->link_url; ?></td>
                <td><?php echo $row->author; ?><br/><?php echo $row->email; ?></td>
                <td style="vertical-align:middle;"><?php echo date('Y/m/d', strtotime($row->created_at)); ?></td>
                <td style="text-align: center;"><img src="<?php echo $row->button_src; ?>" width="88" height="31"></td>
                <td style="text-align: center;vertical-align:middle;"><?php echo $row->views; ?></td>
                <td style="text-align: center;vertical-align:middle;"><?php echo $row->clicks; ?></td>
                <td style="text-align: center;vertical-align:middle;">
                    <?php
                    if ($row->views == 0)
                    {
                        echo '&ndash;';
                    }else{
                        echo round($row->clicks / $row->views) . '%';
                    }
                    ?>
                </td>
                <td style="vertical-align:middle;">
                    <a href="<?php echo admin_url(); ?>admin.php?page=button_board_edit&amp;id=<?php echo $row->id; ?>">
                        Edit
                    </a>
                    |
                    <a href="<?php echo admin_url(
                    ); ?>admin.php?page=button_board_index&amp;action=disable&amp;id=<?php echo $row->id; ?>">
                        Disable
                    </a>
                    |
                    <?php if ($row->archived < 1) { ?>
                        <a href="<?php echo admin_url(
                        ); ?>admin.php?page=button_board_index&amp;action=archive&amp;id=<?php echo $row->id; ?>">
                            Archive
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo admin_url(
                        ); ?>admin.php?page=button_board_index&amp;action=unarchive&amp;id=<?php echo $row->id; ?>">
                            Unarchive
                        </a>
                    <?php } ?>
                    |
                    <a href="<?php echo admin_url(
                    ); ?>admin.php?page=button_board_index&amp;action=ban&amp;id=<?php echo $row->id; ?>">
                        Ban
                    </a>
                    |
                    <?php if (is_null($row->deleted_at)) { ?>
                        <a class="submitdelete" href="<?php echo admin_url(
                        ); ?>admin.php?page=button_board_index&amp;action=trash&amp;id=<?php echo $row->id; ?>">
                            Trash
                        </a>
                    <?php } else { ?>
                        <a class="submitdelete" href="<?php echo admin_url(
                        ); ?>admin.php?page=button_board_index&amp;action=untrash&amp;id=<?php echo $row->id; ?>">
                            Untrash
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>
