<?php

namespace RapidSpike\Utils;

/**
 * Class for handling mime types.
 */
class MimeTypes
{

    /**
     * Get the mime type's 'parent' type
     *
     * @param string $mime_type
     *
     * @return string
     */
    public static function getType(string $mime_type): string
    {
        $mimes = array(
            'hqx' => 'application/mac-binhex40',
            'cpt' => 'application/mac-compactpro',
            'csv' => array(
                'text/x-comma-separated-values',
                'text/comma-separated-values',
                'application/octet-stream',
                'application/vnd.ms-excel',
                'application/x-csv',
                'text/x-csv',
                'text/csv',
                'application/csv',
                'application/excel',
                'application/vnd.msexcel'
            ),
            'bin' => 'application/macbinary',
            'dms' => 'application/octet-stream',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'exe' => array('application/octet-stream', 'application/x-msdownload'),
            'class' => 'application/octet-stream',
            'psd' => 'application/x-photoshop',
            'so' => 'application/octet-stream',
            'sea' => 'application/octet-stream',
            'dll' => 'application/octet-stream',
            'oda' => 'application/oda',
            'pdf' => array('application/pdf', 'application/x-download'),
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'mif' => 'application/vnd.mif',
            'xls' => array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
            'ppt' => array('application/powerpoint', 'application/vnd.ms-powerpoint'),
            'wbxml' => 'application/wbxml',
            'wmlc' => 'application/wmlc',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'dxr' => 'application/x-director',
            'dvi' => 'application/x-dvi',
            'gtar' => 'application/x-gtar',
            'gz' => 'application/x-gzip',
            'php' => 'application/x-httpd-php',
            'php4' => 'application/x-httpd-php',
            'php3' => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps' => 'application/x-httpd-php-source',
            'js' => array('application/x-javascript', 'application/javascript', 'text/javascript'),
            'swf' => 'application/x-shockwave-flash',
            'sit' => 'application/x-stuffit',
            'tar' => 'application/x-tar',
            'tgz' => array('application/x-tar', 'application/x-gzip-compressed'),
            'xhtml' => 'application/xhtml+xml',
            'xht' => 'application/xhtml+xml',
            'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mpga' => 'audio/mpeg',
            'mp2' => 'audio/mpeg',
            'mp3' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
            'aif' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'ram' => 'audio/x-pn-realaudio',
            'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin',
            'ra' => 'audio/x-realaudio',
            'ogg' => 'audio/ogg',
            'webm' => array('audio/webm', 'video/webm'),
            'rv' => 'video/vnd.rn-realvideo',
            'wav' => array('audio/x-wav', 'audio/wave', 'audio/wav'),
            'bmp' => array('image/bmp', 'image/x-windows-bmp'),
            'gif' => 'image/gif',
            'jpeg' => array('image/jpeg', 'image/pjpeg'),
            'jpg' => array('image/jpeg', 'image/pjpeg', 'image/jpg'),
            'jpe' => array('image/jpeg', 'image/pjpeg'),
            'png' => array('image/png', 'image/x-png'),
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'ico' => array('image/x-icon', 'image/vnd.microsoft.icon'),
            'webp' => 'image/webp',
            'css' => 'text/css',
            'html' => 'text/html',
            'htm' => 'text/html',
            'shtml' => 'text/html',
            'txt' => 'text/plain',
            'text' => 'text/plain',
            'log' => array('text/plain', 'text/x-log'),
            'rtx' => 'text/richtext',
            'rtf' => 'text/rtf',
            'xml' => array('text/xml', 'application/xml'),
            'xsl' => 'text/xml',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mp4' => 'video/mp4',
            'mpe' => 'video/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie',
            'doc' => 'application/msword',
            'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'),
            'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'),
            'word' => array('application/msword', 'application/octet-stream'),
            'xl' => 'application/excel',
            'eml' => 'message/rfc822',
            'json' => array('application/json', 'text/json', ': application/json', 'application-json'),
            'svg' => 'image/svg+xml',
            'ttf' => array('font/ttf', 'application/x-font-ttf'),
            'woff' => array('font/woff', 'font/woff2', 'font/x-woff', 'application/x-woff', 'application/x-font-woff', 'application/font-woff', 'application/font-woff2', 'application/x-font-woff2'),
            'opentype' => 'font/opentype',
            'otf' => 'font/otf',
            'sfnt' => 'application/font-sfnt'
        );

        // Recursively look through the mimes and search out
        // the parent type based on the supplied mime_type
        foreach ($mimes as $main_type => $types) {
            if (is_array($types)) {
                foreach ($types as $type) {
                    if ($type === $mime_type) {
                        // Return the parent type here
                        return $main_type;
                    }
                }
            } else {
                if ($types === $mime_type) {
                    // Return the parent type here
                    return $main_type;
                }
            }
        }

        return 'unknown';
    }

}
