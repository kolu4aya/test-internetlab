<b>POST</b> /user/create <br>
Создает нового пользователя <br>
Параметры: email, password, name
Возвращает JSON формата 
`$data = {
				"code" => 200,
				"message"=> "successful"
			}`

<b>POST</b> /user/update <br>
Обновляет данные пользователя <br>
Параметры: login, email, password, name, id


<b>POST</b> /user/destroy <br>
Удаляет указанного пользователя <br>
Параметры: id <br>

<b>POST</b> /user/auth <br>
Авторизация пользователя <br>
Параметры: login, password
Возвращает JSON формата 
`$data = {
				"code" => 200,
				"message"=> "successful", 
				'data' => {
					"id_user" => $is_user['id'],
					"id_session" => $id_session
				}
			}`
<b>GET</b> /user/get/{id} <br>
Возвращает данные указанного пользователя <br>
Параметры: id
Возвращает JSON формата 
`$data = {
				"code" => 200,
				"message"=> "successful", 
				'data' => {
            "id": 32,
            "login": "ivanov6",
            "password": {пароль},
            "name": "Иван"
            }
			}`

В случае успеха возвращает JSON
`$data = {
				"code" => 200,
				"message"=> "successful"
			}`

В случае неудачи возвращает JSON
   `$data = {
				"code" => 200,
				"message"=> [текст ошибки]
			}`
