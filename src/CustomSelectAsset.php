<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:32
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы кастомного элемента select.
 */
class CustomSelectAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/custom-select';

    /** @var string[] */
    public $css = [
        'style.css',
    ];

    /** @var string[] */
    public $js = [
        'script.js'
    ];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class
    ];
}
