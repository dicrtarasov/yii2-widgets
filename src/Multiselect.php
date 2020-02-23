<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 10:17:09
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * JQuery Multiselect widget.
 *
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
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     * @see \yii\widgets\InputWidget::init()
     */
    public function init()
    {
        parent::init();

        if (! isset($this->options['id'])) {
            $this->options['id'] = 'dicr-multiselect-widget-' . random_int(1, 999999);
        }

        if (! isset($this->options['multiple'])) {
            $this->options['multiple'] = true;
        }

        Html::addCssClass($this->options, ['dicr-multiselect-widget']);
    }

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        if (empty($this->items)) {
            return '';
        }

        $this->view->registerAssetBundle(MultiselectAsset::class);

        $this->view->registerJs("$('#{$this->options['id']}').multiselect(" . Json::encode($this->clientOptions) . ')');

        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        }

        return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
    }
}