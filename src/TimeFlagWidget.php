<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:33:43
 */

declare(strict_types = 1);
namespace dicr\widgets;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Виджет поля ввода datetime с типом checkbox.
 */
class TimeFlagWidget extends InputWidget
{
    /** @var string datetime формат */
    public $format;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function run() : string
    {
        $this->options['labelOptions'] = [
            'class' => 'control-label',
            'style' => 'font-weight: normal'
        ];

        if ($this->hasModel()) {
            $val = Html::getAttributeValue($this->model, $this->attribute);
            $this->options['value'] = $val ?: date('Y-m-d H:i:s');
            $this->options['label'] = $val ? Yii::$app->formatter->asDatetime($val, $this->format) : '';
            return Html::activeCheckbox($this->model, $this->attribute, $this->options);
        }

        $this->options['value'] = $this->value ?: date('Y-m-d H:i:s');
        $this->options['label'] = $this->value ? Yii::$app->formatter->asDatetime($this->value, $this->format) : '';
        return Html::checkbox($this->name, $this->value, $this->options);
    }
}
