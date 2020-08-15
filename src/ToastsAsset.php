<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 16.08.20 02:52:04
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
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
        'toasts.scss'
    ];

    /** @var string[] */
    public $js = [
        'toasts.js'
    ];

    /** @var string[] */
    public $depends = [
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        JqueryAsset::class
    ];
}
