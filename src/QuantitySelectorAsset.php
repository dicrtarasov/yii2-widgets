<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 31.05.20 06:37:22
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
