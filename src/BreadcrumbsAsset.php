<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 16.08.20 02:44:13
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\FontAwesomeAsset;
use yii\bootstrap4\BootstrapAsset;
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
