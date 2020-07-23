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
