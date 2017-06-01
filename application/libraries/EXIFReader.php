<?php
/**
 * Created by PhpStorm.
 * User: HerbertHo
 * Date: 7/19/2016
 * Time: 10:56 AM
 */
class EXIFReader
{
    public static function getData($path)
    {
        $exif_ifd0 = read_exif_data($path ,'IFD0' ,0);
        $exif_exif = read_exif_data($path ,'EXIF' ,0);

        $exif_array = array();

        // Make
        if (@array_key_exists('Make', $exif_ifd0)) {
            $exif_array["make"] = $exif_ifd0['Make'];
        }

        // Model
        if (@array_key_exists('Model', $exif_ifd0)) {
            $exif_array["model"] = $exif_ifd0['Model'];
        }

        // Exposure
        if (@array_key_exists('ExposureTime', $exif_ifd0)) {
            $exif_array["exposure"]  = $exif_ifd0['ExposureTime'];
        }

        // Aperture
        if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
            $exif_array["aperture"]  = $exif_ifd0['COMPUTED']['ApertureFNumber'];
        }

        //Focal length
        if (@array_key_exists('FocalLength', $exif_ifd0)) {
            $exif_array["focalLength"]  = $exif_ifd0['FocalLength'];
        }

        //Exposure time
        if (@array_key_exists('ExposureTime', $exif_ifd0['COMPUTED'])) {
            $exif_array["exposureTime"]  = $exif_ifd0['COMPUTED']['ExposureTime'];
        }

        //Flash
        if (@array_key_exists('Flash', $exif_ifd0)) {
            $exif_array["flash"]  = $exif_ifd0['Flash'];
        }

        // Date
        if (@array_key_exists('DateTime', $exif_ifd0)) {
            $exif_array["datetime"]  = $exif_ifd0['DateTime'];
        }

        // ISO
        if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
            $exif_array["iso"]  = $exif_exif['ISOSpeedRatings'];
        }

        //White balance
        if (@array_key_exists('WhiteBalance',$exif_exif)) {
            $exif_array["whiteBalance"]  = $exif_exif['WhiteBalance'];
        }

        //GPS lAT ref
        if (@array_key_exists('GPSLatitudeRef',$exif_exif)) {
            $exif_array["gpsLatitudeRef"]  = $exif_exif['GPSLatitudeRef'];
        }

        //GPS LAT
        if (@array_key_exists('GPSLatitude',$exif_exif)) {
            $exif_array["GPSLatitude"]  = $exif_exif['GPSLatitude'];
        }

        //GPS LNG ref
        if (@array_key_exists('GPSLongitudeRef',$exif_exif)) {
            $exif_array["GPSLongitudeRef"]  = $exif_exif['GPSLongitudeRef'];
        }

        //GPS LNG
        if (@array_key_exists('GPSLongitude',$exif_exif)) {
            $exif_array["GPSLongitude"]  = $exif_exif['GPSLongitude'];
        }

        return $exif_array;

    }
}