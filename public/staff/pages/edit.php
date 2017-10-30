<?php

require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/pages/index.php'));
}

$id = $_GET['id'];


if (is_post_request()){
    $page = [];
    $page['id'] = $id;
    $page['menu_name'] = $_POST['menu_name'] ? $_POST['menu_name']:'';
    $page['subject_id'] = $_POST['subject_id'] ? $_POST['subject_id']:'';
    $page['position'] = $_POST['position'] ? $_POST['position']:'';
    $page['visible'] = $_POST['visible'] ? $_POST['visible']:'0';
    $page['content'] = $_POST['content'] ? $_POST['content']:'';
    //var_dump($page);

    $result = update_page($id,$page);
    if($result === true){
        $_SESSION['message'] = "Page updated successfully!";
        redirect_to(url_for('/staff/pages/show.php?id=' . $page['id']));
    }else{
        $errors = $result;
    }
}else{
    $page = find_page_by_id($id);

}
$page_count = count_pages_by_subject_id($page['subject_id']);

$subject_set = find_all_subjects();
mysqli_fetch_assoc($subject_set);

$page_title = "Edit Page";

?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>
<div id="content">
    <!-- <a class="back_link" href="<?= url_for('/staff/pages/index.php')?>">&laquo; Back to list</a> -->
    <a class="back-link" href="<?= url_for('staff/subjects/show.php?id=' . h(u($page['subject_id']))); ?>">&laquo; Back to Subject Page</a>
    <div class="page edit">
        <h1>Edit Page</h1>
        <?= display_errors($errors);?>

        <form action="<?= url_for('/staff/pages/edit.php?id=' . h(u($id)))?>" name="edit page" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?= $page['menu_name']; ?>" /></dd>
            </dl>
            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name="subject_id">
                        <?php
                            foreach ($subject_set as $subject) {?>
                                <option value="<?= $subject['id']; ?>" <?= $subject['id'] == $page['subject_id'] ? 'selected' : '';?>>
                                    <?= $subject['menu_name']; ?>
                                </option>
                            <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                            for ($i=1; $i <= $page_count; $i++) { ?>
                                <option value="<?= $i; ?>" <?= $i == $page['position'] ? 'selected':''; ?>><?= $i; ?></option>
                            <?php } ?>
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="" />
                    <input type="checkbox" name="visible" value="1" <?php if($page['visible'] == 1){echo "checked";} ?>/>
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content">
                        <?= h($page['content'])  ;?>
                    </textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Page" />
            </div>
        </form>
    </div>
</div>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>
