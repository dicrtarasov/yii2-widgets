<?php
namespace dicr\widgets;

use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Виджет набора тостеров.
 *
 * Необходимо использовать для Bootstrap-наследователя Widget:
 *
 * class ToastsWidget extends \yii\bootstrap4\Widget
 * {
 *     use ToastsTrait;
 * }
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
trait ToastsTrait
{
    /** @var string[] ошибки */
    public $errors = [];

    /** @var string[] предупреждения */
    public $warnings = [];

    /** @var string[] сообщения об успехе */
    public $success = [];

    /** @var string[] произвольный контент внури <div class="toast"></div> */
    public $toasts = [];

    /** @var int задержка скрытия, 0/false - запретить автоскрытие */
    public $autohide = 500;

    /** @var bool анимация */
    public $animation = true;

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        Html::addCssClass($this->options, 'dicr-widgets-toasts');

        parent::init();

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::render()
     */
    public function run()
    {
        ToastsAsset::register($this->view);

        $this->view->registerJs(
            "(function(args) {
                const options = {
                    animation: args.animation,
                    autohide: args.autohide
                };

                $.each(args.errors, (i, message) => window.dicr.widgets.toasts.createToast('test-danger', message, options));
                $.each(args.warnings, (i, message) => window.dicr.widgets.toasts.createToast('test-warning', message, options));
                $.each(args.success, (i, message) => window.dicr.widgets.toasts.createToast('test-success', message, options));
                $.each(args.toasts, (i, content) => window.dicr.widgets.toasts.addToast(content, options));
            })(" . Json::encode($this->attributes) . ")"
        );

        return '';
    }
}