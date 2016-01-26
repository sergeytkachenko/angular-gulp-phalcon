<?
class MenuHelper {

    /**
     * Строим дерево для подменю
     * @param $tree
     * @param $parent
     * @return array
     */
    static public function formatTree(array $tree, $parent){
        $parent = $parent == 0? NULL : $parent;
        $tree2 = array();
        foreach($tree as $i => $item){
            $item['parent_id'] = $item['parent_id'] == 0? NULL : $item['parent_id'];
            if($item['parent_id'] === $parent){
                $tree2[$item['id']] = $item;
                $tree2[$item['id']]['submenu'] = self::formatTree($tree, $item['id']);
            }
        }

        return $tree2;
    }

    public static function menuFromTree ($data, $first=true) {
        if (empty($data)) {
            return '';
        }
        $style = $first? "display:block" : "";
        $out = '<ul> ';
        foreach ($data as $name => $children) {
            $dropDown = self::menuFromTree($children['submenu'], false);
            $li = '<li>';
            $url = $children['url'];
            $a = '<a href="'.$url.'">'.$children['title'].'</a>';
            $out .= $li. $a . $dropDown . '</li>';
        }
        $out .= '</ul>';
        return $out;
    }

    public static function menuLeftCollapse ($data, $first=false) {
        return self::menuLeft($data, $first);
    }

    public static function menuTop ($data) {
        $menu = self::menuFromTree(self::formatTree($data, null));
        return $menu;
    }

}

