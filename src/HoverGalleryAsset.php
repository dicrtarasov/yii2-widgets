<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:35:13
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы галереи.
 */
class HoverGalleryAsset extends AssetBundle
{
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/hover-gallery';

    /** @inheritDoc */
    public $css = [
        'style.scss'
    ];
}

