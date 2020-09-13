<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 13.08.20 06:21:00
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы галереи.
 */
class HoverGalleryAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/hover-gallery';

    /** @var string[] */
    public $css = [
        'style.scss'
    ];
}

