<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use \Project\Models\User;
	use \Project\Controllers\ErrorController;
	
	class UserController extends Controller
	{
		public function create() {
			$data = json_decode(file_get_contents('php://input'));
			$error = new ErrorController;

			if (!isset($data -> login) || !isset($data -> name) || isset($data -> password)) {
				$error -> badRequest("incorrect data");
				return;
			}

			if (!preg_match('/^[a-zA-Z0-9-0_\.]{3,20}$/',$data -> login)) {
				$error -> badRequest("incorrect login");
				return;
			}

			$user = new User;
			$is_user = $user -> getByLogin($data -> login);
			if ($is_user) {
				$error -> badRequest("user already exists");
				return;
			}
			
			if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,}$/',$data -> password)) {
				$error -> badRequest("incorrect password");
				return;
			}
			$data -> password = password_hash($data -> password,  PASSWORD_BCRYPT);

			if (!preg_match('/^[А-Яа-яA-Za-z]{2,}$/',$data -> name)) {
				$error -> badRequest("incorrect name");
				return;
			}
			
			$user -> create($data);

			$data = [
				"code" => 200,
				"message"=> "successful"
			];

			echo(json_encode($data, JSON_UNESCAPED_UNICODE));
		}
		
		public function update() {
			$data = json_decode(file_get_contents('php://input'));
			$error = new ErrorController;

			if (!isset($data -> login) || !isset($data -> name) || !isset($data -> password) || !isset($data -> id)) {
				$error -> badRequest("incorrect data");
				return;
			}

			if (!preg_match('/^[a-zA-Z0-9-0_\.]{3,20}$/',$data -> login)) {
				$error -> badRequest("incorrect login");
				return;
			}
			
			if (!preg_match('/^\d+$/',$data -> id)) {
				$error -> badRequest("incorrect id");
				return;
			}

			$user = new User;
			$is_user = $user -> getByLoginId($data -> login, $data -> id);
			if ($is_user) {
				$error -> badRequest("login already exists");
				return;
			}

			if ($data -> password !== ''){
				if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,}$/',$data -> password)) {
					$error -> badRequest("incorrect password");
					return;
				} 
				$data -> password = password_hash($data -> password,  PASSWORD_BCRYPT);
			}

			if (!preg_match('/^[А-Яа-яA-Za-z]{2,}$/',$data -> name)) {
				$error -> badRequest("incorrect name");
				return;
			}
			
			$user = new User;
			$user -> update($data);

			$data = [
				"code" => 200,
				"message"=> "successful"
			];

			echo(json_encode($data, JSON_UNESCAPED_UNICODE));
		}

		public function destroy() {
			$data = json_decode(file_get_contents('php://input'));
			$error = new ErrorController;

			if (!preg_match('/^\d+$/',$data -> id)) {
				$error -> badRequest("incorrect id");
				return;
			}

			$user = new User;
			$user -> destroy($data -> id);

			$data = [
				"code" => 200,
				"message"=> "successful"
			];

			echo(json_encode($data, JSON_UNESCAPED_UNICODE));
		}

		public function auth() {
			$data = json_decode(file_get_contents('php://input'));

			if (!isset($data -> login) || !isset($data -> password)) {
				$error -> badRequest("incorrect data");
				return;
			}

			$login = $data -> login;
			$pass = $data -> password;

			$user = new User;
			$is_user = $user -> getByLogin($data -> login);
			if (!$is_user || count($is_user) == 0) {
				$error -> badRequest("user not found");
				return;
			}

			if (!password_verify($pass, $is_user['password'])) {
				$error -> badRequest("user not found");
				return;
				
			} 

			session_start();
			$_SESSION['id_user'] = $is_user['id'];
			$id_session = session_id(); 
			$data = [
				"code" => 200,
				"message"=> "successful", 
				'data' => [
					"id_user" => $is_user['id'],
					"id_session" => $id_session
				]
			];

			echo(json_encode($data, JSON_UNESCAPED_UNICODE));
		}

		public function get($params) {
			$id = $params['id'];
			$user = new User;
			$user = $user -> getById($id);
			$data = [
				"code" => 200,
				"message"=> "successful", 
				'data' => $user
			];
			echo(json_encode($user, JSON_UNESCAPED_UNICODE));
		}
	}
