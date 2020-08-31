<?php

class AboutController
{

  public static function process_data()
  {
    $about = (new AboutModel())->get_about();
    $paragraphs = explode("\n", $about['about_text']);
    $formatted_text = '';

    foreach ($paragraphs as $paragraph) {
      $formatted_text .= '<p>' . $paragraph . '</p>';
    }
    require ABS_PATH . 'templates/aboutView.php';
  }
}
