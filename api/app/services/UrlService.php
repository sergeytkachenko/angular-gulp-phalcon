<?
namespace Phalcon\Di\Service;

abstract class UrlService {

    /**
     * Добавляет параметр в url адрес, проверяя его наличие
     * @param $name - param name
     * @param $value - param value
     * @return mixed|string - url with added param
     */
    public static function addParamToUrl ($name, $value) {
       $url = $_SERVER["REQUEST_URI"];
       $url = preg_replace("/&?$name=[a-zA-Zа-яА-Я0-9-_]+/", "", $url);
       $url = preg_match("/\\?/", $url)? $url."&".$name."=".$value : $url."?".$name."=".$value;

       return $url;
   }
}