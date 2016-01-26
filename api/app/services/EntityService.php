<?
namespace Phalcon\Di\Service;

abstract class EntityService {

    /**
     * @param $entities
     * @param $needle
     * @param $key
     * @return bool
     */
    public static function inEntityRecursive ($entities, $needle, $key) {
        foreach($entities as $entity) {
            if($entity->$key == $needle) {
                return true;
            }
        }
        return false;
    }
}