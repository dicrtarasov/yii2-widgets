<?php
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Assets for Jquery Multiselect widget.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class MultiselectAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/multiselect';

    /** @var string[] */
    public $css = [
        'multiselect.css'
    ];

    /** @var string[] */
    public $depends = [
        \dicr\asset\MultiselectAsset::class
    ];
}
