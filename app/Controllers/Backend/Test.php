<?php

namespace App\Controllers\Backend;

use App\Models\BaseModel;
use App\Models\Users as UsersEntity;

class Test extends BaseAdminController
{
	protected function indexAction()
	{
		return $this->render('mail/masterpage.html');
	}
}