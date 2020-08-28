<?php

class AboutModel extends Database
{

  public function get_about()
  {
    $stmt = $this->run_query('SELECT * FROM about');
    $about = $stmt->fetch();
    return $about;
  }
}
