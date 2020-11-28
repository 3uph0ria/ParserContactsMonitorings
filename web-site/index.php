<?php
require_once '../Class/Database.php';
$Database = new Database();
$contacts = $Database->GetAllContacts();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pars Contacts Monitorings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Контакт</th>
      <th scope="col">Веб-сайт</th>
    </tr>
  </thead>
  <tbody>
	<?for($i = 0; $i < Count($contacts); $i++):?>
    <tr>
      <th scope="row"><?=$i + 1?></th>
      <td><a href="<?=$contacts[$i]['contacts']?>" target="_blank"><?=$contacts[$i]['contacts']?></a></td>
      <td><a href="<?=$contacts[$i]['web_site']?>" target="_blank"><?=$contacts[$i]['web_site']?></a></td>
		</tr>
	<?endfor;?>
  </tbody>
</table>
</body>
</html>