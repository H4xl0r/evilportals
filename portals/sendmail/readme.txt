To use this Portal:

setup Smtp Settings for Your Pinapple (Readme).
setup Smtp & Mail Settings in MyPortal.php:

 $sub = "Wifi Access Token"; //Subject of the mail 
 $sender = "ENTER SENDER MAIL HERE"; //Sender of the mail
 $body = "Your Access Token: $token"; //body of the mail

eg:

 $sub = "Wifi Access Token"; //Subject of the mail 
 $sender = "wifiaccess@wifi.com"; //Sender of the mail
 $body = "Your Access Token: $token"; //body of the mail
