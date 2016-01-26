<?

abstract class Code {

    /**
     * @example {{ javascript:path-to-file }}
     * @param $text
     * @return string
     */
    static public function replaceCode ($text) {
        return mb_ereg_replace_callback('{{\\s*([a-zA-Z]+):([a-zA-Z0-9_\\/-]+)\\s*}}', 'Code::rep', $text);
    }

    static public function rep ($a) {
        if(isset($a[1]) and $a[2]) {
            $leng = $a[1];
            $path = $a[2];
            $file = PUBLIC_PATH.'/attach/js/'.$path.'.js';
            if (file_exists($file)) {
                return "<pre><code data-language='".$leng."'>".file_get_contents($file)."</code></pre>";
            }
        }
    }
}
