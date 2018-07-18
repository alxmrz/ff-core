<?php

namespace core;
/**
 * Класс для фильтрации данных
 */
class Security
{
  /**
   * Возвращает отфильтрованные данные $_GET
   * @return array
   */
  public static function filterGetInput()
  {
    return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
  }
  /**
   * Возвращает отфильтрованные данные $_POST
   * @return array
   */
  public static function filterPostInput()
  {
    return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
  }

}
