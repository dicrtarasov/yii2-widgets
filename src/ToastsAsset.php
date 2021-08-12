<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 12.08.21 22:00:48
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;
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
