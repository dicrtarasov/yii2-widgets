<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:21:23
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
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/multiselect';

    /** @var string[] */
    public $css = [
        'multiselect.scss'
    ];

    /** @var string[] */
    public $depends = [
        \dicr\asset\MultiselectAsset::class
    ];
}
