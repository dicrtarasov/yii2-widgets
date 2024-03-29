<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:31:58
 */

declare(strict_types = 1);
namespace dicr\widgets;

use Exception;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

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
    public array $items = [];

    /**
     * @inheritDoc
     * @see Html::dropDownList
     */
    public $options = [
        'class' => ['form-control'],
        'multiple' => true
    ];

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function init() : void
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
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function run() : string
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
