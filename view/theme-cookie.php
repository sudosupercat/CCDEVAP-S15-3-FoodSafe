<?php
if(!isset($_COOKIE['theme'])){
    setcookie("theme", "light", time() + (86400 * 30), "/");
}
?>