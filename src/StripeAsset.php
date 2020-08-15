<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 16.08.20 02:52:04
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
    public $css = [
        'style.scss'
    ];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class,
        SlickAsset::class
    ];
}
