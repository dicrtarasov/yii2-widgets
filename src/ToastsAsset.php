<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:23:09
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
        'toasts.scss'
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
