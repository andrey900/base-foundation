<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\BaseModel;
use Illuminate\Support\Collection;
use App\Models\Users as UsersEntity;

class Auth extends BaseController
{
	protected function indexAction()
	{
		if( $_COOKIE['authorize_hash'] ){
			$codeline = $_COOKIE['authorize_hash'];
			$solt = substr($codeline, 0, 16).substr($codeline, -16);
			$codePhrase = substr($codeline, 16, -16);

			$solt1 = base64_encode($solt);
			$arHash = str_split($codePhrase, 3);
			$nStrongHash = '';
			foreach ($arHash as $key => $val) {
				if( isset($solt1[$key]) )
					$nStrongHash .= substr($val, 1, 3);
				else
					$nStrongHash .= $val;
			}
			$jsonString = openssl_decrypt($nStrongHash, 'AES-128-ECB', $this->settings['app']['appKey']);

			if( $jsonString ){
				$data = json_decode($jsonString);

				if( $data ){
					$data = (array)$data;
				}

				if( $data && $data['u'] && $data['p'] && $data['e'] && $data['i'] && $data['e'] > time() ){
					$user = UsersEntity::where('login', $data['u'])->where('id', $data['i'])->where('password', $data['p'])->get()->first();
					if( $user && ($user->active || $user->id == 1 ) ){
						$_SESSION['auth'] = new Collection([
							'user.id' => $user->id,
							'user.login' => $user->login,
							'user.first_name' => $user->first_name,
							'user.last_name' => $user->last_name,
						]);
						if( $_SESSION['auth']->has('last_request') )
							return $this->response->withRedirect($_SESSION['auth']['last_request']);

						return $this->response->withRedirect('/admin/users');
					} else {
						// error: user not active
					}
				}
			}
		}

		if( $_SESSION['auth'] && $_SESSION['auth']->has('user.id') ){
			if( $_SESSION['auth']->has('last_request') )
				return $this->response->withRedirect($_SESSION['auth']['last_request']);

			return $this->response->withRedirect('/admin/users');
		}
	}

	protected function loginAction()
	{
		$data = $this->request->getParsedBody();
		$user = UsersEntity::where('login', $data['login'])->get()->first();

		if( $user && password_verify($data['password'], $user->password) && ($user->active || $user->id == 1 ) ){
			$_SESSION['auth'] = new Collection([
				'user.id' => $user->id,
				'user.login' => $user->login,
				'user.first_name' => $user->first_name,
				'user.last_name' => $user->last_name,
			]);

			if( $data['rememberme'] ){
				$d = [
					'i' => $user->id,
					'u' => $user->login,
					'p' => $user->password,
					'e' => time()+3600*24*7
				];

				$strongHash = openssl_encrypt(json_encode($d), 'AES-128-ECB', $this->settings['app']['appKey']); // шифруем данные
				$solt = md5($strongHash);
				$solt1 = base64_encode($solt); // генерим подставные символы
				$arHash = str_split($strongHash, 2);
				foreach ($arHash as $key => $val) { // подпихиваем символы в шифрованую строку
					$nStrongHash .= $solt1[$key].$val;
				}
				$codeAuthorizeString = substr($solt, 0, 16).$nStrongHash.substr($solt, 16);// склеиваем с солью

				setcookie("authorize_hash", $codeAuthorizeString, time()+3600*24*35, '/');
			}

			if( $_SESSION['auth']->has('last_request') )
				return $this->response->withRedirect($_SESSION['auth']['last_request']);

			return $this->response->withRedirect('/admin/users');
		} else {
			// error: user not active or not found
		}
	
		return $this->response->withRedirect('/admin/login');
	}

	protected function logoutAction()
	{
		unset($_SESSION['auth']);
		setcookie("authorize_hash", "", time() - 3600, "/");
		return $this->response->withRedirect('/admin/login');
	}

	protected function createAction()
	{
		return $this->render('pages/auth/index.html');
	}

	protected function storeAction()
	{
		$id = UsersEntity::create($this->request->getParsedBody());
		if( $id )
			return $this->response->withRedirect('/admin/users');
		else
			return $this->response->withRedirect('/admin/register');
	}
}