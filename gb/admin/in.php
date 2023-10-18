<?php
$title = 'Вход в админку';
include 'head.php';

echo '<div class="head">Вход в панель управления</div>';
echo '<div class="menu"><form action="index.php" method="get">
Пароль:<br/>
<input type="password" name="pass"/><br/>
<input type="submit" value="Вход"/></form></div>';
echo '<div class="menu"><a href="/">На главную</a></div>';

include 'foot.php';
?>