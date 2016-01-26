<?

class LibFunction {

    public static function trimToDot ($str, $maxLen) {
        $string = mb_substr($str, 0, $maxLen, 'UTF-8');
        $dotIndex = mb_strrpos($string, ".");
        $s1Index = mb_strrpos($string, "!");
        $s2Index = mb_strrpos($string, "?");
        $s3Index = mb_strrpos($string, ";");
        if($dotIndex !== false) {
            return mb_substr($str, 0, $dotIndex+1, 'UTF-8');
        }
        if($s1Index !== false) {
            return mb_substr($str, 0, $s1Index+1, 'UTF-8');
        }
        if($s2Index !== false) {
            return mb_substr($str, 0, $s2Index+1, 'UTF-8');
        }
        if($s3Index !== false) {
            return mb_substr($str, 0, $s3Index+1, 'UTF-8');
        }
        return $string;
    }
}