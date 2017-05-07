<?php
namespace core;

class Securety
{

    public static function filterGetInput()
    {
        return filter_input(INPUT_GET, $_GET);
    }

    public static function filterPostInput()
    {
        return filter_input_array(INPUT_POST, $_POST);
    }

    public static function checkUserInput($get)
    {
        return htmlspecialchars(trim($get));
    }

}
