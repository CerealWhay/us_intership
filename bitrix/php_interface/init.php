<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/vendor/autoload.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/vendor/autoload.php");
}

class Foo {
    function aMemberFunc() {
        print_r("privet");
    }
}

?>
