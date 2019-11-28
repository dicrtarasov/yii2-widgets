<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 06.10.19 08:25:33
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Toasts Asset.
 */
class ToastsAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/toasts';

    /** @var string[] */
    public $css = [
        'toasts.css'
    ];

    /** @var string[] */
    public $js = [
        'toasts.js'
    ];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class,
    ];
}
