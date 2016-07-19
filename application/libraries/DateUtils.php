<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/19/2016
 * Time: 11:57 AM
 */

/*
use DateTime;
use DateInterval;
use DateTimeZone;
*/

class DateUtils
{
    public static function default_db_date_time_format()
    {
        return "Y-m-d H:i:s";
    }

    public static function default_db_date_format()
    {
        return "Y-m-d";
    }

    public static function current_datetime($format = NULL)
    {
        $ci_instance =& get_instance();
        $ci_instance->load->helper("date");
        $time = now();

        if ($format === NULL) {
            $format = self::default_db_date_time_format();
        }

        return date($format, $time);
    }

    public static function get_future_datetime($date_internal_string,$format = NULL)
    {
        $ci_instance =& get_instance();
        $timezone = $ci_instance->config->item("time_reference");
        $datetime = new DateTime('now', new DateTimeZone($timezone));
        $datetime->add(new DateInterval($date_internal_string));

        if ($format === NULL) {
            $format = self::default_db_date_time_format();
        }

        return $datetime->format($format);
    }

    public static function to_db_date($time = NULL)
    {
        if (!isset($time)) {
            $ci_instance =& get_instance();
            $ci_instance->load->helper("date");
            $time = now();
        }
        return date(self::default_db_date_format(), $time);
    }

    public static function to_db_datetime($time = NULL)
    {
        if (!isset($time)) {
            $ci_instance =& get_instance();
            $ci_instance->load->helper("date");
            $time = now();
        }
        return date(self::default_db_date_time_format(), $time);
    }

    public static function current_db_date()
    {
        return self::to_db_date();
    }

    public static function current_db_datetime()
    {
        return self::to_db_datetime();
    }

    public static function get_current_date_time(){
        $ci_instance =& get_instance();
        $timezone = $ci_instance->config->item("time_reference");
        $datetime = new DateTime('now', new DateTimeZone($timezone));
        return $datetime;
    }
}
