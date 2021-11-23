<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/vendor/autoload.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/vendor/autoload.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."bitrix/php_interface/include/mysclad-api/product_parser.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "bitrix/php_interface/include/mysclad-api/product_parser.php");
}

?>
