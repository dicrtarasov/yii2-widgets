<?php
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы галлереи.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
class HoverGalleryAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/hovergallery';

    /** @var string[] */
    public $css = ['hovergallery.css'];
}

