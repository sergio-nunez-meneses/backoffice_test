<?php

class AboutController extends Database
{

  public function display_about()
  {
    $about = (new AboutModel())->get_about();
    AboutView::about_view($about);
  }
}
