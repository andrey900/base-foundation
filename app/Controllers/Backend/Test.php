<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\BaseModel;
use App\Models\Users as UsersEntity;

class Test extends BaseController
{
	protected function indexAction()
	{
		return $this->render('mail/masterpage.html');
	}
}