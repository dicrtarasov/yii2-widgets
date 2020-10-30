<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:27:17
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Assets for Jquery Multiselect widget.
 *
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class MultiselectAsset extends AssetBundle
{
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/multiselect';

    /** @inheritDoc */
    public $css = [
        'multiselect.scss'
    ];

    /** @inheritDoc */
    public $depends = [
        \dicr\asset\MultiselectAsset::class
    ];
}
