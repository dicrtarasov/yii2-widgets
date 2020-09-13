<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:22:33
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
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/rating-input';

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
        JqueryAsset::class,
        FontAwesomeAsset::class
    ];
}
