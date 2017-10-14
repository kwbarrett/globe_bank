<?php require_once('../../../private/initialize.php'); ?>

<?php
    $page_title = 'Show Page';
    include(SHARED_PATH . '/staff_header.php');

    $id = isset($_GET['id']) ? $_GET['id']:'1';

    $page = find_page_by_id($id);
?>

<div id="content">
    <div class="page show">
        <a class="back-link" href="<?= url_for('staff/pages/index.php'); ?>">&laquo; Back to List</a>

        <h1>Page: <?= h($page['menu_name']);?></h1>
        <div class="attributes">
            <dl>
                <dt>
                    Menu Name
                </dt>
                <dd>
                    <?= h($page['menu_name']); ?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Subject
                </dt>
                <dd>
                    <?= h($page['subject']);?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Position
                </dt>
                <dd>
                    <?= h($page['position']);?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Visible
                </dt>
                <dd>
                    <?= h($page['visible']) == 1 ? 'true':'false'; ?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Content
                </dt>
                <dd>
                    <?= h($page['content']); ?>
                </dd>
            </dl>
        </div>
    </div>
</div>
<?php include(SHARED_PATH.'/staff_footer.php');
