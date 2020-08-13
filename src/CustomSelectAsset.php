<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:20:19
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
        'style.scss',
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
