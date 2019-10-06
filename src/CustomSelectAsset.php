<?php
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы кастомного элемента select.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
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
