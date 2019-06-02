<?php
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Toasts Asset.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
class ToastsAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@dicr/widgets/assets';

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