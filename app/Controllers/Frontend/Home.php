<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function home($request, $response, $args) {
      $this->request($request, $response);

      return $this->render('profile.html');
    }
}