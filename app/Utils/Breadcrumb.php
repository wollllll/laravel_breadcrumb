<?php

namespace App\Utils;

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
     * @return View
     */
    public static function current(string $template = ''): View
    {
        $instance = self::instance($template);

        return $instance->generateHtml(Route::currentRouteName());
    }

    /**
     * HTML出力
     *
     * @param string $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function generateHtml(string $name): View
    {
        $data = $this->breadcrumbData($name);

        return view($this->template, compact('data'));
    }

    /**
     * パンくずリストの生成
     *
     * @param string $name
     * @return array|null
     */
    private function breadcrumbData(string $name): ?array
    {
        $results = [];

        while ($data = $this->getBreadcrumbsByName($name)) {
            $results[] = array_merge($data, [
                'url' => $this->generateUrl($name)
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
     * @return string
     */
    private function generateUrl(string $name): string
    {
        return url(Arr::get(parse_url(route($name, request()->route()->parameters)), 'path'));
    }
}
