<div class="wrap">
    <h2>
        Add New Button
    </h2>

    <?php include('elements/flash_messages.php'); ?>

    <form method="post" action="<?php echo admin_url(); ?>admin.php?page=button_board_add&amp;action=save">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="author">Banner Author</label></th>
                    <td>
                        <input name="author" type="text" id="author"
                               value="<?php echo(isset($flashMessages['inputs']['author']) ? $flashMessages['inputs']['author'] : ''); ?>"
                               class="regular-text" placeholder="Joe Blogs">
                        <?php if (array_key_exists('author', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['author'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="email">Author Email</label></th>
                    <td>
                        <input name="email" type="text" id="email"
                               value="<?php echo(isset($flashMessages['inputs']['email']) ? $flashMessages['inputs']['email'] : ''); ?>"
                               class="regular-text" placeholder="joe.blogs@example.com">
                        <?php if (array_key_exists('email', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['email'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="button_src">Banner Image Src</label></th>
                    <td>
                        <input name="button_src" type="text" id="button_src"
                               value="<?php echo(isset($flashMessages['inputs']['button_src']) ? $flashMessages['inputs']['button_src'] : ''); ?>"
                               class="regular-text" placeholder="http://www.example.com/banner.gif">
                        <?php if (array_key_exists('button_src', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['button_src'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="link_url">Banner Link URL</label></th>
                    <td>
                        <input name="link_url" type="text" id="link_url"
                               value="<?php echo(isset($flashMessages['inputs']['link_url']) ? $flashMessages['inputs']['link_url'] : ''); ?>"
                               class="regular-text" placeholder="http://www.example.com">
                        <?php if (array_key_exists('link_url', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['link_url'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Create">
        </p>
    </form>
</div>
