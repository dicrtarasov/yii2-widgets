<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.08.20 15:30:40
 */

declare(strict_types = 1);
namespace dicr\widgets;

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
    public function bootstrap($app)
    {
        $app->i18n->translations['dicr/widgets'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'ru',
            'basePath' => __DIR__ . '/messages'
        ];
    }
}
