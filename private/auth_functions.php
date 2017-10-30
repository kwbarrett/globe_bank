<?php

    // Performs all actions necessary to log in an admin
    function log_in_admin($admin) {
        // Renerating the ID protects the admin from session fixation.
        session_regenerate_id();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['last_login'] = time();
        $_SESSION['username'] = $admin['username'];
        return true;
    }

  function is_logged_in(){
      return isset($_SESSION['admin_id']);
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting access to the page.
  function require_login(){
      if(!is_logged_in()){
          redirect_to(url_for('/staff/login.php'));
      }else{
          // do nothing
      }
  }

  function log_out_admin(){
      unset($_SESSION['admin_id']);
      unset($_SESSION['last_login']);
      unset($_SESSION['username']);
      // session_destroy() works as well and destroys the whole session.
      return true;
  }

?>
