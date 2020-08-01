<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 02.08.20 02:53:31
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
        'style.css'
    ];
}
