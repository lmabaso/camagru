<?php

class Redirect {

  public static function to($location = null) {
    if ($location) {
      if (is_numeric($location)) {
        if ($location === 404)
        {
          header('HTTP/1.0 404 Not Found');
          include 'Control/Includes/Errors/404.php';
          exit();
        }
      }
      header('Location: '. $location);
      exit();
    }
  }
}

?>
