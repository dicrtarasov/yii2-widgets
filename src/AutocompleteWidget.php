<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 12.05.20 21:34:50
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\AutocompleteAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Виджет авто-подсказок при вводе.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 * @noinspection PhpUnused
 */
class AutocompleteWidget extends InputWidget
{
    /** @var array опции скрипта */
    public $clientOptions = [];

    /**
     * {@inheritDoc}s
     *
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widgets-autocomplete');

        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        AutocompleteAsset::register($this->view);

        $this->view->registerJs(
            "$('#{$this->options['id']}').devbridgeAutocomplete(" . Json::encode($this->clientOptions) . ')'
        );

        $type = ArrayHelper::remove($this->options, 'type', 'search');
        return $this->renderInputHtml($type);
    }
}
