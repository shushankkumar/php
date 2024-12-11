<?php
$cookie_name = "event";
$cookie_value = "bhadoriya shivani ";
setcookie($cookie_name, $cookie_value, time() + 200, "/");
?>
<html>
<body>
<?php
if(!isset($_COOKIE[$cookie_name])) {
 echo "Cookie named '" . $cookie_name . "' Cookie not saved!";
}
else
{
 echo "Cookie '" . $cookie_name . "' Cookie saved   !<br>";
 echo "Value is: " . $cookie_value;
}
?>
</body>
</html>