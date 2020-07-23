<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 23.07.20 21:31:29
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
