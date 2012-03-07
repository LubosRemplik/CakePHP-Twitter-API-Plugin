<?php
/**
 * Twitter utilities Class.
 *
 * This is contained some utilities for Twitter.
 *
 * @package twitter
 * @subpackage twitter.libs
 */
class TwitterUtils
{

    /**
     * Shortens a text to 140 characters for tweeting.
     *
     * URL contined the text is out when text shotening.
     *
     * @access public
     * @var string $text  Text for shortening.
     * @var string $tail  If text is shortend, $tail is added the text.
     * @return string
     */
    function shorten($text, $tail = '...')
    {
        $length = 140;
        if(mb_strlen($text) <= $length) {
            return $text;
        }

        $tailLen = mb_strlen($tail);
        if(!preg_match('/(http\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\/\S*)?)/', $text, $matches)) {
            return mb_substr($text, 0, $length - $tailLen).$tail;
        }
        $url = $matches[1];
        list($prev, $next) = split($url, $text);
        $url = ' '.$url;

        $length = $length - mb_strlen($url);
        if(mb_strlen($prev) >= $length) {
            $prev = mb_substr($prev, 0, $length - (2 + $tailLen)).$tail;
            if(!empty($next)) {
                $next = ' '.$tail;
            }
        }else{
            $next = mb_substr($next, 0, $length - mb_strlen($prev) - $tailLen).$tail;
        }

        return $prev.$url.$next;

    }

}
