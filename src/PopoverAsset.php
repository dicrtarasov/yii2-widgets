<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 31.05.20 06:20:34
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы виджета Popover.
 */
class PopoverAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/popover';

    /** @var string[] */
    public $css = [
        'style.css'
    ];
}
