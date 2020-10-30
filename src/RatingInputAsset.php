<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:28:05
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\FontAwesomeAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы виджета RatingInput.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class RatingInputAsset extends AssetBundle
{
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/rating-input';

    /** @inheritDoc */
    public $css = [
        'style.scss'
    ];

    /** @inheritDoc */
    public $js = [
        'script.js'
    ];

    /** @inheritDoc */
    public $depends = [
        JqueryAsset::class,
        FontAwesomeAsset::class
    ];
}
