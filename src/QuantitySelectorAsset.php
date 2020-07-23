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
 * Ресурсы виджета QuantitySelector.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class QuantitySelectorAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/quantity-selector';

    /** @var string[] */
    public $css = ['style.css'];

    /** @var string[] */
    public $js = ['script.js'];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class
    ];
}
