<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:29:17
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы виджета QuantitySelector.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class QuantitySelectorAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/quantity-selector';

    /** @var string[] */
    public $css = [
        'style.scss'
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
