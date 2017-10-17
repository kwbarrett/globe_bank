<?php require_once('../private/initialize.php');
    $preview = false;
    if(isset($_GET['preview'])){
        $preview = $_GET['preview'] == 'true' ? true : false;
    }
    $visible = !$preview;
?>

<?php
    if(isset($_GET['id'])){
        $page_id = $_GET['id'];
        $page = find_page_by_id($page_id, ['visible' => $visible]);
        if(!$page){
            //exit;
            redirect_to(url_for('/index.php'));
        }
        $subject_id = $page['subject_id'];
        $subject = find_subject($subject_id,['visible' => $visible]);
        if(!$subject){
            redirect_to(url_for('/index.php'));
        }
    }elseif(isset($_GET['subject_id'])){
        $subject_id = $_GET['subject_id'];
        $subject = find_subject($subject_id,['visible' => $visible]);
        //exit;
        if(!$subject){
            //echo 'aaa';
            //exit;
            redirect_to(url_for('/index.php'));
        }else{
            //echo 'ccc';
            //exit;
        }
        $page_set = find_pages_by_subject_id($subject_id, ['visible' => $visible]);
        $page = mysqli_fetch_assoc($page_set);
        mysqli_free_result($page_set);
        if(!$page){
            redirect_to(url_for('/index.php'));
        }
        $page_id = $page['id'];
    }else{
        //nothing, show the home page
    }
?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">
    <?php include(SHARED_PATH . '/public_navigation.php'); ?>
    <div id="page">
        <?php
            if(isset($page)){
                //show the page from the db
                //TODO add html excaping back in
                $allowed_tags = '<div><img><p><h1><h2><br /><strong><ul><li>';
                echo strip_tags($page['content'],$allowed_tags);
            }else{
                //show the homepage
                //the homepage content could:
                // * be static content ( here or in a shared file)
                // * show the first page from the nav
                // * be in the db but add code to hide in the nav
                include(SHARED_PATH . '/static_homepage.php');
            }
        ?>
    </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
