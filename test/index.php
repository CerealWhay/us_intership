<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовая страница");
?>

<?php
$ms_login = 'admin@maxyambas';
$ms_password = 'KURkuma7821#$';

$parser = new ProductParser($ms_login, $ms_password);

$parser->addProducts();
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

