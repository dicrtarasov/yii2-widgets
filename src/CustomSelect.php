<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 20.06.20 18:26:46
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use function is_array;
use function ob_get_clean;
use function ob_start;

/**
 * Альтернативный элемент select.
 *
 * @noinspection PhpUnused
 */
class CustomSelect extends InputWidget
{
    /** @var string[] ассоциативный массив значений val => label */
    public $values;

    /** @var string текст не выбранного значения */
    public $placeholder;

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        if (empty($this->values)) {
            $this->values = [];
        } elseif (! is_array($this->values)) {
            throw new InvalidConfigException('values');
        }

        $this->placeholder = (string)$this->placeholder;
        Html::addCssClass($this->options, 'dicr-widget-custom-select');
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        CustomSelectAsset::register($this->view);

        $this->view->registerJs('$("#' . $this->options['id'] . '").dicrWidgetsCustomSelect();');

        ob_start();
        echo Html::beginTag('section', $this->options);

        // определяем название поля ввода и значение
        $inputName = null;
        $value = null;

        if ($this->hasModel()) {
            $inputName = Html::getInputName($this->model, $this->attribute);
            $value = (string)Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $inputName = $this->name;
            $value = (string)$this->value;
        }

        // определяем метку текущего значения
        $label = $this->values[$value] ?? '';
        if ($label === '') {
            $label = $this->placeholder;
        }

        // кнопка открытия списка
        echo Html::button(Html::encode($label), [
            'class' => [$value === '' ? 'placeholder' : '']
        ]);

        // всплывающий список
        echo Html::beginTag('div', ['class' => 'popup']);

        if ($this->placeholder !== '') {
            echo Html::label(
                Html::radio($inputName, $value === '', ['value' => '']) .
                Html::encode($this->placeholder), null, ['class' => 'placeholder']
            );
        }

        if (! empty($this->values)) {
            foreach ($this->values as $val => $label) {
                echo Html::label(
                    Html::radio($inputName, $value === (string)$val, ['value' => $val]) .
                    Html::encode($label)
                );
            }
        }

        echo Html::endTag('div');   // popup

        echo Html::endTag('section');   // widget
        return ob_get_clean();
    }
}
