<?php
namespace core;

class Securety
{

    public static function filterGetInput()
    {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public static function filterPostInput()
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}
