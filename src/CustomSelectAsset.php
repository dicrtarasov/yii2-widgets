<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 06.10.19 08:25:16
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
    public $sourcePath = __DIR__ . '/assets/customselect';

    /** @var string[] */
    public $css = [
        'customselect.css',
    ];

    /** @var string[] */
    public $js = [
        'customselect.js'
    ];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class
    ];
}
