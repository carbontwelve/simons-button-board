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
            <th scope="col" id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                <input id="cb-select-all-1" type="checkbox">
            </th>
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
        <?php if (count($data) > 0 ){ foreach ($data as $row) {  ?>
            <tr id="button-<?php echo $row->id; ?>" class="button-<?php echo $row->id; ?>">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-93">Select Tutorials and Guides Test</label>
                    <input id="cb-select-<?php echo $row->id; ?>"" type="checkbox" name="post[]" value="<?php echo $row->id; ?>"">
                </th>
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
                        echo round($row->clicks / $row->views, 2) . '%';
                    }
                    ?>
                </td>
                <td style="vertical-align:middle;">

                    <?php if (is_null($row->deleted_at)) { ?>

                    <a href="<?php echo admin_url(); ?>admin.php?page=button_board_edit&amp;id=<?php echo $row->id; ?>">
                        Edit
                    </a>
                    |
                    <?php if ($row->enabled < 1) { ?>
                    <a href="<?php echo admin_url(
                    ); ?>admin.php?page=button_board_index&amp;action=enable&amp;id=<?php echo $row->id; ?>">
                        Enable
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo admin_url(
                    ); ?>admin.php?page=button_board_index&amp;action=disable&amp;id=<?php echo $row->id; ?>">
                        Disable
                    </a>
                    <?php } ?>
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
                    <?php }else{ ?>
                        Edit | Disable | Archive |
                    <?php } ?>

                    <?php if ($row->archived < 1) { ?>
                        <a href="<?php echo admin_url(
                        ); ?>admin.php?page=button_board_index&amp;action=ban&amp;id=<?php echo $row->id; ?>">
                            Ban
                        </a>
                    <?php }else{?>
                        Ban
                    <?php } ?>
                    |

                    <?php if ($row->archived < 1) { ?>
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
                    <?php }else{ ?>
                        Trash
                    <?php } ?>
                </td>
            </tr>
        <?php } }else{ ?>
        <tr><td colspan="9">No Results found.</td></tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="tablenav bottom">

        <div class="alignleft actions bulkactions">
            <select name="action2">
                <option value="-1" selected="selected">Bulk Actions</option>
                <option value="disable" class="hide-if-no-js">Archive</option>
                <option value="ban" class="hide-if-no-js">Ban</option>
                <option value="disable" class="hide-if-no-js">Disable</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" name="" id="doaction2" class="button action" value="Apply">
        </div>
        <div class="alignleft actions">
        </div>
        <div class="tablenav-pages one-page"><span class="displaying-num">17 items</span>
            <span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="http://dev.photogabble.local/wp-admin/edit.php">«</a>
                <a class="prev-page disabled" title="Go to the previous page" href="http://dev.photogabble.local/wp-admin/edit.php?paged=1">‹</a>
                <span class="paging-input">1 of <span class="total-pages">1</span></span>
                <a class="next-page disabled" title="Go to the next page" href="http://dev.photogabble.local/wp-admin/edit.php?paged=1">›</a>
                <a class="last-page disabled" title="Go to the last page" href="http://dev.photogabble.local/wp-admin/edit.php?paged=1">»</a>
            </span>
        </div>
        <br class="clear">
    </div>

</div>
