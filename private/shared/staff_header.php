<?php
    if(!isset($page_title)){
        $page_title = 'Staff Area';
    }
?>
<!doctype html>

<html lang="en">
<head>
    <title>GBI - <?= $page_title ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<? echo url_for('/stylesheets/staff.css')?>">
</head>

<body>
    <header>
        <h1>GBI Staff Area</h1>
    </header>
    <navigation>
        <ul>
            <?php if(is_logged_in()){ ?>
                <li>User: <?= isset($_SESSION['username']) ? $_SESSION['username'] : ''  ;?></li>
            <?php } ?>
            <li><a href="<? echo url_for('staff/index.php');?>">Menu</a></li>
            <?php
                if(isset($_SESSION['username'])){?>
                    <li><a href="<? echo url_for('staff/logout.php');?>">Logout</a></li>
            <?php }?>
        </ul>
    </navigation>
    <?= display_message();?>
