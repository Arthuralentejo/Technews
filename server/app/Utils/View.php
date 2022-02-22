<?php
namespace App\Utils;

/**
 * Class View
 *
 * @package App\Utils
 */
class View
{

    /**
     * @var array
     */
    private static array $vars = [];

    /**
     * @param array $vars
     *
     * @return void
     */
    public static function init(array $vars = []): void
    {
        self::$vars = $vars;
    }

    /**
     * @param $view
     * @param array $data
     *
     * @return string
     */
    public static function render($view, array $data = []): string
    {
        $contentView = self::getContentView($view);
        $data = array_merge(self::$vars, $data);
        $keys = array_keys($data);
        $keys = array_map(static function ($key) {
            return '{{' . $key . '}}';
        }, $keys);
        return str_replace($keys, array_values($data), $contentView);
    }

    /**
     * @param $view
     *
     * @return string
     */
    private static function getContentView($view): string
    {
        $file = dirname(__DIR__, 2) . '/resource/view/' . $view . '.html';


        return file_exists($file) ? file_get_contents($file) : '';
    }
}
