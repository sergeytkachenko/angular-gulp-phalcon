<?

abstract class Text {

    /**
     * truncates the string to the last punctuation mark
     * @param $text
     * @param int $length
     * @param string $encoding
     * @return string
     */
    static public function substToDot($text, $length=300, $encoding='UTF-8') {
        $text = mbereg_replace('<pre>.*</pre>','', $text); // обрезаем код
        $text = mb_substr($text, 0, $length, $encoding);

        $data = self::substToSymbol($text, '.', $encoding);
        if($data) {
            return  $data . "..";
        }

        $data = self::substToSymbol($text, '!', $encoding);
        if($data) {
            return  $data;
        }

        $data = self::substToSymbol($text, '?', $encoding);
        if($data) {
            return  $data;
        }


        $data = self::substToSymbol($text, ';', $encoding);
        if($data) {
            return  $data ;
        }


        return $text;
    }

    static private function substToSymbol ($text, $symbol, $encoding) {
        $indexSymbol = mb_strrpos($text, $symbol, 0, $encoding);
        if($indexSymbol!==false) {
            return  mb_substr($text, 0, $indexSymbol+1, $encoding);
        }
        return false;
    }
}