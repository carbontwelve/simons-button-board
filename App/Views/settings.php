<div class="wrap">
    <h2>
        Settings
    </h2>

    <?php include('elements/flash_messages.php'); ?>

    <form method="post" action="<?php echo admin_url(); ?>admin.php?page=button_board_settings&amp;action=save">

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="author">Email Validation</label></th>
                    <td>
                        <input name="users_can_register" type="checkbox" id="users_can_register" value="1"> Users must validate their email address, before button is published.
                        <p class="description">If checked, before a button is accepted the submitter must validate their email address.</p>
                        <?php if (array_key_exists('author', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['author'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="author"># Buttons to show</label></th>
                    <td>
                        <input name="author" type="text" id="author"
                               value="<?php echo(isset($flashMessages['inputs']['author']) ? $flashMessages['inputs']['author'] : '6'); ?>"
                               class="regular-text" placeholder="6">
                        <p class="description">How many buttons to display by default when <code>simons_button_board();</code> is used in a template.</p>
                        <?php if (array_key_exists('author', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['author'][0]; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="author">Button Layout</label></th>
                    <td>
                        <input name="author" type="text" id="author"
                               value="<?php echo(isset($flashMessages['inputs']['author']) ? $flashMessages['inputs']['author'] : '6'); ?>"
                               class="regular-text" placeholder="6">
                        <p class="description">Choose which layout you want your buttons formatted in.</p>
                        <?php if (array_key_exists('author', $flashMessages['errors'])) { ?>
                            <br/>
                            <span><?php echo $flashMessages['errors']['author'][0]; ?></span>
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
