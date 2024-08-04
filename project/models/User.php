<?php
	namespace Project\Models;
	use \Core\Model;
	
	class User extends Model
	{
		public function getById($id) {
			return $this->findOne("SELECT * FROM users WHERE id=$id");
		}

		public function getByLogin($login) {
			return $this->findOne("SELECT * FROM users WHERE login='$login'");
		}

		public function getByLoginId($login, $id) {
			return $this->findOne("SELECT * FROM users WHERE login='$login' and id <> $id");
		}
		
		public function create($data) {
			return $this->query("INSERT INTO `users`(`login`, `password`, `name`) VALUES ('{$data -> login}','{$data -> password}', '{$data -> name}')");
		}

		public function update($data) {
			$query = "UPDATE `users` SET `login`='{$data -> login}', `name`='{$data -> name}'";

			if (isset($data -> password) && $data -> password !== '') {
				$query .= ",`password`='{$data -> password}'";
			}
			
			$query .= " WHERE id = {$data -> id}";

			return $this->query($query);
		}

		public function destroy($id)
		{
			return $this->query("DELETE FROM `users`  WHERE id = $id");
		}
	}
