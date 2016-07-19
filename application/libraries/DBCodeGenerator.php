<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/19/2016
 * Time: 11:34 AM
 */
class DBCodeGenerator
{
    public static function generate_db_code_until_not_duplicated($prefix = "pk", callable $is_duplicated)
    {
        $ci_instance =& get_instance();
        $ci_instance->load->helper("date");
        $primaryKey = sprintf("%s%s%s", $prefix, now(), self::create_random_pattern(4));

        if ($is_duplicated($primaryKey)) {
            self::generate_db_code_until_not_duplicated($prefix, $is_duplicated);
        } else {
            return $primaryKey;
        }
    }

    public static function generate_db_code($prefix = "hg", $large_data_insert = FALSE)
    {
        $ci_instance =& get_instance();
        $ci_instance->load->helper("date");
        $primaryKey = sprintf("%s%s%s", $prefix, now(), self::create_random_pattern(4, $large_data_insert));
        return $primaryKey;
    }
    
    public static function create_random_pattern($length, $more_random_code = FALSE)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";

        if ($more_random_code) {
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        }

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[rand(0, strlen($codeAlphabet) - 1)];
        }
        return $token;
    }
}