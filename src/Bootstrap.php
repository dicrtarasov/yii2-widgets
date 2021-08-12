<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 12.08.21 22:16:00
 */

declare(strict_types = 1);
namespace dicr\widgets;

use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

/**
 * Автозагрузка при настройке пакета.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app) : void
    {
        $app->i18n->translations['dicr/widgets'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'ru',
            'basePath' => __DIR__ . '/messages'
        ];

        Yii::$container->set(\yii\bootstrap5\Breadcrumbs::class, Breadcrumbs::class);
    }
}
