<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 31.05.20 06:16:29
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Виджет набора тостеров.
 *
 * @noinspection PhpUnused
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

    /** @var int задержка скрытия, 0/false - запретить авто-скрытие */
    public $autoHide = 10000;

    /** @var bool анимация */
    public $animation = true;

    /** @var array опции тега виджета */
    public $options = [];

    /** @var array опции javascript */
    public $clientOptions = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
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
                $this->clientOptions[$field] = (array)$this->{$field};
            }
        }

        Html::addCssClass($this->options, 'dicr-widgets-toasts');
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