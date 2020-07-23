<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 23.07.20 21:31:29
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\FontAwesomeAsset;
use yii\web\AssetBundle;

/**
 * Ресурсы виджета RatingWidget.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class RatingAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/rating';

    /** @var string[] */
    public $css = ['style.css'];

    /** @var string[] */
    public $depends = [
        FontAwesomeAsset::class
    ];
}
