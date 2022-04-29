<html>
<head>
    <meta charset="UTF-8">
    <link href="../var/www/html/FileRead_chat/img/icon.png" rel="icon" type="image/x-icon">
    <title>CHAT</title>
</head>
</html>


<form class="log" action='/' method='GET'>
    <div class="text">Войдите, чтобы отправить сообщение:  </div>
		<input  name='login'>
		<input name='password' type='password'>
		<input class="botton" type='submit' value='Авторизироваться'>
	</form>

<?php
echo"<style>
*, *::before, *::after {
  box-sizing: border-box;
}

.log{
  font-family: inherit; 
  font-size: inherit; 
  line-height: inherit;
}

.in {
  display: block;
  width: 25%;
  height: calc(2.25rem + 2px);
  padding: 0.375rem 0.75rem;
  font-family: inherit;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #bdbdbd;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.botton {border-radius: 4px;}
.botton:hover {
    background-color: #4CAF50; /* Green */
    color: white;
}
</style>";

date_default_timezone_set('Asia/Vladivostok');
$login_successful = false; 
show_messages(); 
if (isset($_GET['login'])&&isset($_GET['password'])) {
    setcookie('login', $_GET['login']);
    $usr = $_GET['login'];
    $pwd = $_GET['password'];
 //список: логины и пароли   
     if ($usr == 'admin' && $pwd == '000' || 
         $usr == 'mary' && $pwd == '111'  || 
         $usr == 'den' && $pwd == '222'   || 
         $usr == 'sofa' && $pwd == '333'  ||          
         $usr == 'default')
         {
        $login_successful = true; 
        echo ("Авторизирован как   ");
        echo($_GET['login']);
    }
    else {
        ?>
        Неверный логин или пароль!
        <?php
    }
}

if ($login_successful){
 ?>    
    <form class="sms" action="/" method="GET">
    <input class="in" placeholder="Сообщение" name="message">
    <input class="botton" type="submit" name="send" value="Отправить">
    </form>
<?php
}

function add_message_to_file($message, $log){
 $content = json_decode(file_get_contents("mes.json"));
        $message_object = (object) [
            'date' => date('d.m.Y H:i'),
            'login' => $log,
            'message' => $message];
        $content->messages[] = $message_object;
        file_put_contents("mes.json", json_encode($content));   
       
}

 if (isset($_GET['message'])){
    add_message_to_file($_GET['message'], $_COOKIE['login']) ; 
    header('Refresh: 0; url=index.php');    
   } 

function show_messages(){ 
     $content = json_decode(file_get_contents("mes.json"));
        foreach($content->messages as $message){
            echo "<p>";
            echo "$message->date      $message->login:     <b>$message->message</b>";
            echo "</p>";        }
    }

?>
