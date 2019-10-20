<?php
namespace dicr\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * JQuery Multiselect widget.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 * @link https://github.com/nobleclem/jQuery-MultiSelect
 */
class Multiselect extends InputWidget
{
    /**
     * @var string[] элементы выбора
     * @see Html::dropDownList
     */
    public $items = [];

    /**
     * @var array опции
     * @see Html::dropDownList
     */
    public $options = [
        'class' => ['form-control'],
        'multiple' => true
    ];

    /**
     * @var array опции плагина multiselect
     * @see https://github.com/nobleclem/jQuery-MultiSelect
     */
    public $clientOptions = [];

    /**
     * {@inheritDoc}
     * @see \yii\widgets\InputWidget::init()
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['dicr-multiselect-wdget']);

        if (!isset($this->options['id'])) {
            $this->options['id'] = 'dicr-multiselect-widget-' . rand(1, 999999);
        }

        if (!isset($this->options['multiple'])) {
            $this->options['multiple'] = true;
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        if (empty($this->items)) {
            return '';
        }

        $this->view->registerAssetBundle(MultiselectAsset::class);

        $this->view->registerJs(
            "$('#{$this->options['id']}').multiselect(" . Json::encode($this->clientOptions) . ")"
        );

        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        }

        return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
    }
}
