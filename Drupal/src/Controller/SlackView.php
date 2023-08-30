<?php

namespace Drupal\ecd_custom\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\block_content\Entity;
/**
 * Class slackController.
 */
class SlackChannelView extends ControllerBase {
  /*Get slack messages*/
  function get_latest_msgs() {
     $top = get_top_conv($slack=0, $channel['Cname']);
      foreach ($top as $message) {
        $slack_apis_data .= render_message($message);
     }
  }
}
  
  
