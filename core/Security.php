<?php

namespace core;

class Security
{
    /**
     * @return array
     */
    public static function filterGetInput()
    {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * @return array
     */
    public static function filterPostInput()
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}
