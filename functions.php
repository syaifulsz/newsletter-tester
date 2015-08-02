<?php

class TextHelper {

    function slugify($string)
    {
        $slug = preg_replace('/[\s]+/', '-', $string);
        $slug = str_replace('[-]+', '-', $slug);
        $slug = preg_replace('/[^\da-z-]/i', '', $slug);
        $slug = strtolower($slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}