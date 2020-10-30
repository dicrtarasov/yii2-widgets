<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:29:06
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
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/toasts';

    /** @inheritDoc */
    public $css = [
        'toasts.scss'
    ];

    /** @inheritDoc */
    public $js = [
        'toasts.js'
    ];

    /** @inheritDoc */
    public $depends = [
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        JqueryAsset::class
    ];
}
