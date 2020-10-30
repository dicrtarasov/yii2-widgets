<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:27:54
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
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/rating';

    /** @inheritDoc */
    public $css = ['style.scss'];

    /** @inheritDoc */
    public $depends = [
        FontAwesomeAsset::class
    ];
}
