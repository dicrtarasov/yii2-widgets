<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 05:59:30
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\web\AssetBundle;

/**
 * Ресурсы галлереи.
 */
class HoverGalleryAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/hovergallery';

    /** @var string[] */
    public $css = ['hovergallery.css'];
}

