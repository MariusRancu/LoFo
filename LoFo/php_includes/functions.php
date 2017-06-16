<?php
    function filter_tags($tag){
        if(strlen($tag) > 1 && ($tag !="sau" || $tag != "cum" || $tag != "pai" || $tag !="sunt" || $tag !="in" || $tag !="pe"))
            return true;
        else
            return false;    
    }

    function sanitize_tag($tag){
        return strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $tag));
    }
?>