<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 05.01.22 07:04:59
 */

declare(strict_types = 1);
namespace dicr\widgets;

use Yii;
use yii\helpers\Json;

/**
 * Виджет набора тостеров.
 */
class ToastsWidget extends Widget
{
    /** @var string[]|null ошибки */
    public ?array $errors = null;

    /** @var string[]|null предупреждения */
    public ?array $warnings = null;

    /** @var string[]|null сообщения об успехе */
    public ?array $success = null;

    /** @var string[]|null произвольный контент внутри <div class="toast"></div> */
    public ?array $toasts = null;

    /** @var bool анимация */
    public bool $animation = true;

    /** @var int задержка скрытия, 0/false - запретить авто-скрытие */
    public int $autohide = 10000;

    /** @var ?string ключ сессии flash */
    public ?string $flashKey = 'toasts';

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        // если задан ключ flash-сессии
        if (! empty($this->flashKey)) {
            // получаем конфиг из flash сессии
            $flashConfig = Yii::$app->session->getFlash($this->flashKey, [], true);
            if (! empty($flashConfig)) {
                Yii::configure($this, $flashConfig);
            }
        }

        $this->clientOptions = [
            'animation' => $this->animation,
            'autohide' => $this->autohide,
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'success' => $this->success,
            'toasts' => $this->toasts
        ];

        Html::addCssClass($this->options, 'dicr-widgets-toasts');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        ToastsAsset::register($this->view);

        $this->view->registerJs('window.dicr.widgets.toasts = new window.dicr.widgets.Toasts(".dicr-widgets-toasts",' .
            Json::encode($this->clientOptions) . ')'
        );

        return Html::tag('section', '', $this->options);
    }
}
