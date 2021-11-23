<?php

class ProductParser {
    private $login;
    private $password;

    function __construct($login, $password) {
        $this->login = $login;
        $this->password = $password;
    }

    private function getProducts() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://online.moysklad.ru/api/remap/1.1/entity/product/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".base64_encode("{$this->login}:{$this->password}"),
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $json_response = json_decode($response);

        return $json_response->{'rows'};
    }

    private function addElements($rows) {
        foreach ($rows as &$value) {
            $this->addElementToInfoblock($value);
        }
    }

    private function addElementToInfoblock($element) {

        $el = new CIBlockElement;
        $props = array();
        $props['ARTICLE_PROPERTY_ID'] = $element->{'article'};

        $params = Array(
            "max_len" => "100", // обрезает символьный код до 100 символов
            "change_case" => "L", // буквы преобразуются к нижнему регистру
            "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
            "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
            "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
            "use_google" => "false", // отключаем использование google
        );

        $arLoadProductArray = Array(
            "IBLOCK_ID"      => 2,
            "PROPERTY_VALUES"=> $props,
            "NAME"           => $element->{'name'},
            "CODE"           => CUtil::translit($element->{'name'}, "ru" , $params),
            "ACTIVE"         => "Y",
        );

        $PRODUCT_ID = $el->Add($arLoadProductArray);

        $arFields = array(
            "ID" => $PRODUCT_ID,
            "QUANTITY" => $element->{'volume'}
        );

        CCatalogProduct::Add($arFields);

        $price = $element->{'salePrices'}[0]->{'value'};

        $arFields = Array(
            "PRODUCT_ID" => $PRODUCT_ID,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $price,
            "CURRENCY" => "RUB",
            "QUANTITY_FROM" => 0,
            "QUANTITY_TO" => 0
        );
        CPrice::Add($arFields);
    }

    public function addProducts() {
        $rows = $this->getProducts();
        $this->addElements($rows);
    }
}
