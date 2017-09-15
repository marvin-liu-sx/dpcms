<?php
/**
 * 统计字符串数量 只支持UTF-8
 * @param  string $str 要统计的字符串
 * @return integer     字符串数量
 */
if (!function_exists('string_length')) {
    function string_length($str)
    {
        $str = htmlspecialchars_decode($str);   // 将特殊的 HTML 实体转换回普通字符后再计算
        return mb_strlen($str, 'utf-8');
    }
}
/**
 * 字符截取 只支持UTF-8
 * @param $string
 * @param $length
 * @param $dot
 * @return string     字符串
 */
if (!function_exists('string_cut')) {
    function string_cut($string, $length, $dot = '...')
    {
        $len = string_length($string);
        $string = htmlspecialchars_decode($string); // 将特殊的 HTML 实体转换回普通字符后再截取
        $string = mb_substr($string, 0, $length, 'utf-8');
        $string = htmlspecialchars($string);    // 把一些预定义的字符转换为 HTML 实体
        if ($len <= $length) {
            $dot = '';
        }
        return $string . $dot;
    }
}

