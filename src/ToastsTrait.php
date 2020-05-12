<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 12.05.20 21:35:15
 */

declare(strict_types = 1);
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
 * @noinspection PhpUnused
 */
trait ToastsTrait
{
    /** @var string[] ошибки */
    public $errors = [];

    /** @var string[] предупреждения */
    public $warnings = [];

    /** @var string[] сообщения об успехе */
    public $success = [];

    /** @var string[] произвольный контент внутри <div class="toast"></div> */
    public $toasts = [];

    /** @var int задержка скрытия, 0/false - запретить авто-скрытие */
    public $autoHide = 10000;

    /** @var bool анимация */
    public $animation = true;

    /**
     * @inheritDoc
     */
    public function init()
    {
        Html::addCssClass($this->options, 'dicr-widgets-toasts');

        parent::init();

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        foreach (['animation', 'autoHide'] as $field) {
            if (isset($this->{$field})) {
                $this->clientOptions['options'][$field] = $this->{$field};
            }
        }

        foreach (['errors', 'warnings', 'success', 'toasts'] as $field) {
            if (isset($this->{$field})) {
                $this->clientOptions[$field] = $this->{$field};
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        ToastsAsset::register($this->view);

        $this->view->registerJs("(function(args) {
                $.each(args.errors, (i, message) => window.dicr.widgets.toasts.error(message, 'Ошибка', args.options));
                $.each(args.warnings, (i, message) => window.dicr.widgets.toasts.warning(message, 'Предупреждение', args.options));
                $.each(args.success, (i, message) => window.dicr.widgets.toasts.success(message, 'Готово', args.options));
                $.each(args.toasts, (i, content) => window.dicr.widgets.toasts.addToast(content, args.options));
            })(" . Json::encode($this->clientOptions) . ')');

        return '';
    }
}
