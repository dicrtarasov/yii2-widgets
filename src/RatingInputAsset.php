<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:33
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\assets\FontAwesomeAsset;
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
        'style.css'
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
