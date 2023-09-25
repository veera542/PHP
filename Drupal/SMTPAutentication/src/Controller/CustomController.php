<?php

namespace Drupal\custom\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomController extends ControllerBase {

  function send_email($name = null, $to_email = null, $email = null, $subject = null, $message = null) {
    $langcode = 'fr';
     $to = $to_email;
  
     $mailManager = \Drupal::service('plugin.manager.mail');
     $module = 'custom';
     $key = 'contact';
     $params = array(
      'message' => $message,
      'subject' => $subject,
      'email' => $email,
      'name' => $name
      );
     $send = true;
  
     $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send); 
     return true;
  }
}
