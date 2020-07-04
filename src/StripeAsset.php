<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 22:30:48
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\SlickAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы виджета StripeAsset.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class StripeAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/stripe';

    /** @var string[] */
    public $css = ['style.css'];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class, SlickAsset::class
    ];
}
