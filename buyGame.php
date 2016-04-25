<? 

// Pipedrive
$api_url = 'https://api.pipedrive.com/v1';
$api_key = '98f1219d17bb79464bf54ef12d4a4927dc426c78';
$sales_new = '1';

function makePost($url, $data){
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = json_decode(curl_exec( $ch ));
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    if($err) {
        echo ('Error: ' . $err . " - " . $errmsg);
        return false;
    }

    return $response;
}

echo('Create person.');
$person_url = $api_url . '/persons?api_token=' . $api_key;
$person_data = array('name' => $_POST['lead_name'], 'phone' => $_POST['lead_phone']);

$person_response = makePost( $person_url , $person_data);

if($person_response && $person_response->success){
    $person_id = $person_response->data->id;
    echo('Succesfull creation of Person:' . $person_id .'.');
    
    echo('Create deal.');
    $deal_url = $api_url . '/deals?api_token=' . $api_key;    
    $deal_data = array('title' => 'Игра Жизни - ' . $_POST['lead_phone'], 'person_id' => $person_id, 'stage_id' => $sales_new);
    
    $deal_response = makePost($deal_url, $deal_data);
} else {
    var_dump($person_response);
}

echo ' Finish! Have a good day.';


// Pipedrive

// ----------------------------конфигурация-------------------------- // 
 
$adminemail="teta28.com@gmail.com, eleven.krsk@gmail.com;";  // e-mail админа 

$email="teta28.com@gmail.com,"; // почта пользователя по умолчанию  
 
$date=date("d.m.y"); // число.месяц.год  
 
$time=date("H:i"); // часы:минуты:секунды 
 
$backurl="https://www.youtube.com/channel/UCKDcIwpDRFj3GYrtz2ranwg?sub_confirmation=1";  // На какую страничку переходит после отправки письма 
 
//---------------------------------------------------------------------- // 
 
  
 
// Принимаем данные с формы 
 
$name=$_POST['lead_name']; 
   
$phone=$_POST['lead_phone'];

$mail=$_POST['lead_email'];
  
$message=$_POST['lead_text'];
 
$msg=" 
Меня зовут $name и я хочу оплатить курс 'Игра жизни'.

Имя: $name
Телефон: $phone
"; 
 
  
 
 // Отправляем письмо админу  
 
mail("$adminemail", "$date $time Сообщение 
от $name", "$msg"); 
 
  
 
// Сохраняем в базу данных 
 
$f = fopen("message.txt", "a+"); 
 
fwrite($f," \n $date $time Регистрация на Игру Жизни - $name"); 
 
fwrite($f,"\n $msg "); 
 
fwrite($f,"\n ---------------"); 
 
fclose($f); 
 
  
 
// Выводим сообщение пользователю   
 
print "<script language='Javascript'>
 function reload() {location = \"$backurl\"}; setTimeout('reload()', 1000); 
</script> 

<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<div style=\"background: url(images/shattered.png); padding-top: 200px; height:100%;\">
<p style=\"font-family:'PT Sans'; font-size: 36px; font-weight:700; text-align:center;\">Спасибо! Мы сегодня с вами свяжемся</p>
</div>";  
exit; 
 
 
 
?>