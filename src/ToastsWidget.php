<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 03.10.21 20:01:15
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
    /** @var string[] ошибки */
    public $errors = [];

    /** @var string[] предупреждения */
    public $warnings = [];

    /** @var string[] сообщения об успехе */
    public $success = [];

    /** @var string[] произвольный контент внутри <div class="toast"></div> */
    public $toasts = [];

    /** @var bool анимация */
    public $animation = true;

    /** @var int задержка скрытия, 0/false - запретить авто-скрытие */
    public $autohide = 10000;

    /** @var string|false ключ сессии flash */
    public $flashKey = 'toasts';

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
            'errors' => (array)($this->errors ?: []),
            'warnings' => (array)($this->warnings ?: []),
            'success' => (array)($this->success ?: []),
            'toasts' => (array)($this->toasts ?: [])
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
