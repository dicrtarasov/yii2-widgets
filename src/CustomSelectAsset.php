<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 23.07.20 21:31:29
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
