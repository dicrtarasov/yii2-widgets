<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 10:16:01
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
        'multiselect.css'
    ];

    /** @var string[] */
    public $depends = [
        \dicr\asset\MultiselectAsset::class
    ];
}
