<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:32
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
