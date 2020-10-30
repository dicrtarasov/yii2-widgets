<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:28:53
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
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/stripe';

    /** @inheritDoc */
    public $css = [
        'style.scss'
    ];

    /** @inheritDoc */
    public $depends = [
        JqueryAsset::class,
        SlickAsset::class
    ];
}
