<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 12.08.21 22:00:42
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\FontAwesomeAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Ресурсы Breadcrumbs.
 */
class BreadcrumbsAsset extends AssetBundle
{
    /** @inheritDoc */
    public $sourcePath = __DIR__ . '/assets/breadcrumbs';

    /** @inheritDoc */
    public $css = [
        'style.scss'
    ];

    /** @inheritDoc */
    public $depends = [
        BootstrapAsset::class,
        FontAwesomeAsset::class
    ];
}
