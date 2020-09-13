<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:21:47
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы виджета Popover.
 */
class PopoverAsset extends AssetBundle
{
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/popover';

    /** @inheritDoc */
    public $css = [
        'style.scss'
    ];
}
