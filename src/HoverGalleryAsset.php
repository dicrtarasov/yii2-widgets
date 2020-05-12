<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 12.05.20 21:29:02
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
    public $sourcePath = __DIR__ . '/assets/hovergallery';

    /** @var string[] */
    public $css = ['hovergallery.css'];
}

