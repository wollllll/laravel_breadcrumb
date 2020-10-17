<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * パンくずを生成するクラス
 *
 * Class Breadcrumb
 * @package App\Utils
 */
class Breadcrumb
{
    /**
     * @var self|null
     */
    public static $instance;

    /**
     * @var string
     */
    private $template;
    /**
     * @var array
     */
    private $data;

    /**
     * Breadcrumb constructor.
     * @param string $template
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function __construct(string $template)
    {
        $this->template = $template;
        $this->data = json_decode(Storage::disk('resource')->get(config('breadcrumb.file')), true);
    }

    /**
     * singleton
     *
     * @param string $template
     * @return static
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function instance(string $template): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($template);
        }

        return self::$instance;
    }

    /**
     * @param string $template
     * @param array $params
     * @return View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function current(string $template = '', array $params = []): View
    {
        $instance = self::instance($template);

        return $instance->generateHtml(Route::currentRouteName(), $params);
    }

    /**
     * HTML出力
     *
     * @param string $name
     * @param array $params
     * @return View
     */
    private function generateHtml(string $name, array $params): View
    {
        $data = $this->breadcrumbData($name, $params);

        return view($this->template, compact('data'));
    }

    /**
     * パンくずリストの生成
     *
     * @param string $name
     * @param array $params
     * @return array|null
     * @throws Exception
     */
    private function breadcrumbData(string $name, array $params): ?array
    {
        $results = [];

        while ($data = $this->getBreadcrumbsByName($name)) {
            $results[] = array_merge($data, [
                'url' => $this->generateUrl($name, $params)
            ]);

            $name = Arr::get($data, 'parent');

            if (is_null(Arr::get($data, 'parent'))) break;
        }

        return array_reverse($results);
    }

    /**
     * 対象のパンくずを取得
     *
     * @param string $name
     * @return array
     */
    private function getBreadcrumbsByName(string $name): ?array
    {
        return Arr::get($this->data, $name, null);
    }

    /**
     * url生成
     *
     * @param string $name
     * @param array $params
     * @return string
     * @throws Exception
     */
    private function generateUrl(string $name, array $params): string
    {
        return url(Arr::get(parse_url(route($name, $params)), 'path'));
    }
}
