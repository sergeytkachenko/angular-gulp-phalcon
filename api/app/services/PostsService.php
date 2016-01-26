<?
namespace Phalcon\Di\Service;

abstract class PostsService {
    /**
     * Возвращает список должностей диллера
     * @param $params -- набор параметров поиска диллера
     * @return array -- список должностей
     */
    public static function getPostsByDealer($params) {
        $dealer = \Dealers::findFirst($params);
        $stafflists = \Stafflist::find("stafflist_group=".$dealer->stafflist_group_id);
        $posts = array();
        foreach($stafflists as $stafflist) {
            $posts[]=$stafflist->Posts;
        }
        return $posts;
    }
}