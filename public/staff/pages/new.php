<?php
require_once('../../../private/initialize.php');
require_login();
if(is_post_request()){
    $page = [];
    $page['menu_name'] = $_POST['menu_name'];
    $page['subject_id'] = $_POST['subject_id'];
    $page['position'] = $_POST['position'];
    $page['visible'] = $_POST['visible'];
    $page['content'] = $_POST['content'];

    $result = insert_page($page);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "Page created successfully!";
        redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
    }else{
        $errors = $result;
    }
}else{
    //redirect_to(url_for('/staff/pages/new.php'));
    $page = [];
    $page['menu_name'] = '';
    $page['subject_id'] = isset($_GET['subject_id']) ? $_GET['subject_id'] : '1';
    $page['visible'] = '';
    $page['position'] = '';
}

$page_count = count_pages_by_subject_id($page['subject_id']) + 1;

$subjects = find_all_subjects();
mysqli_fetch_assoc($subjects);


$page_title = "New Page";

?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <a class="back_link" href="<?= url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id'])))?>">&laquo; Back to list</a>

    <div class="page new">
        <h1>New Page</h1>
        <?= display_errors($errors);?>
        <form action="<?= url_for('/staff/pages/new.php')?>" name="new page" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name"  value="<?= $page['menu_name']; ?>"/></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                            for ($i=1; $i <= $page_count ; $i++) { ?>
                                <option value="<?= $i ;?>" <?= $i == $page_count ? 'selected':'' ; ?>>
                                    <?= $i ;?>
                                </option>
                            <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name="subject_id">
                        <option value="">--select one--</option>
                        <?php
                            foreach ($subjects as $subject) {?>
                                <option value="<?= $subject['id']; ?>" <?= $subject['id'] == $page['subject_id'] ? 'selected' : ''; ?>>
                                    <?= $subject['menu_name'] ;?>
                                </option>
                        <?php    } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1"/>
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content"></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Page" />
            </div>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
