<?php
if(!empty($_COOKIE["first"]))
{
	echo "Coockie is nice:) ".$_COOKIE["first"];
	setcookie("first", md5(rand()), time()-(3600));
}
else
{
	echo "haven't coockie :(";
	setcookie("first", md5(rand()), time()+(31536000*5));
}

