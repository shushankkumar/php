<!-- Count Cookies -->
<?php
$cookie_name = "event";
$cookie_value = "Saurav kumar ";
setcookie($cookie_name, $cookie_value, time() + 200, "/");
?>

<html>
<body>
<?php
if(count($_COOKIE[$cookie_name])>0) {
//  echo "Cookie named '" . $cookie_name . "' Cookie not saved!";
echo "Cookie named '" . $cookie_name . "' is saved!";
}
else    
{
 echo "Cookie '" . $cookie_name . "' Cookie saved   !<br>";
 echo "Value is: " . $cookie_value;
}
?>
</body>
</html>



<!-- Set cookies -->
<?php
$cookie_name = "event";
$cookie_value = "Saurav kumar ";
setcookie($cookie_name, $cookie_value, time() + 200, "/");
$cookie_name2 = "Event2";
$cookie_value2 = "Shushank kumar ";
setcookie($cookie_name2, $cookie_value2, time() + 200, "/");

?>
<html>
<body>
<?php
if(!isset($_COOKIE[$cookie_name,$cookie_name2])) {
 echo "Cookie named '" . $cookie_name . "' Cookie not saved!";
// echo "Cookie named '" . $cookie_name . "' is saved!";
}
else    
{
 echo "Cookie '" . $cookie_name . "' Cookie saved   !<br>";
 echo "Value is: " . $cookie_value;
}
?>
</body>
</html>


<!-- Delete Cookies -->
<?php
$cookie_name = "event";
$cookie_value = "Saurav kumar ";
setcookie($cookie_name, $cookie_value, time() - 200, "/");
$cookie_name2 = "Event2";
$cookie_value2 = "Shushank kumar ";
setcookie($cookie_name2, $cookie_value2, time() - 200, "/");

?>
<html>
<body>
<?php
if(!isset($_COOKIE[$cookie_name,$cookie_name])) {
 echo "Cookie named '" . $cookie_name . "' Cookie Deleted Succefully";
// echo "Cookie named '" . $cookie_name . "' is saved!";
}
else    
{
 echo "Cookie '" . $cookie_name . "' Cookie saved   !<br>";
 echo "Value is: " . $cookie_value;
}
?>
</body>
</html>