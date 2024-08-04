<?php
	namespace Project\Controllers;
	use \Core\Controller;
	
	class ErrorController extends Controller
	{
		public function notFound() {
			$data = [
				"code" => 404,
				"message"=> "Page not found"
			];
			echo(json_encode($data, true));
		}
		public function badRequest($message) {
			$data = [
				"code" => 400,
				"message"=> $message
			];
			echo(json_encode($data, true));
		}
	}
