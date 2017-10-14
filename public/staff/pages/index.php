<?php require_once('../../../private/initialize.php'); ?>

<?php

    $page_set = find_all_pages();

    $page_title = 'Pages';
?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>
<div id="content">
    <div class="pages listing">
        <h1>Pages</h1>
        <div class="actions">
            <a class="action" href="<?= url_for('/staff/pages/new.php'); ?>">Create New Page</a>
        </div>
        <table class="list">
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Position</th>
                    <th>Visible</th>
                    <th>Name</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                <?php while($page = mysqli_fetch_assoc($page_set)) { ?>
                    <tr>
                        <td><?= h($page['id']); ?></td>
                        <td><?= h($page['subject']);?></td>
                        <td><?= h($page['position']);?></td>
                        <td><?= $page['visible'] == 1 ? 'true':'false';?></td>
                        <td><?= h($page['menu_name']);?></td>
                        <td><a href="<?= url_for('/staff/pages/show.php?id='.h(u($page['id']))); ?>">View</a></td>
                        <td><a href="<?= url_for('/staff/pages/edit.php?id='.h(u($page['id']))); ?>">Edit</a></td>
                        <td><a href="<?= url_for('/staff/pages/delete.php?id='.h(u($page['id']))); ?>">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
            mysqli_free_result($page_set);
        ?>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
