<?
namespace Phalcon\Di\Service;

abstract class ArraysService {

    /**
     * @param array $array
     * @param $needle - search value
     * @param $key - key by search value
     * @return bool
     */
    public static function inArrayRecursive (array $array, $needle, $key) {
        foreach($array as $data) {
            if(array_key_exists($key, $data) and $data[$key] == $needle) {
                return true;
            }
        }
        return false;
    }
}