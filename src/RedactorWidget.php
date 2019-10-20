<?php
namespace dicr\widgets;

use dicr\asset\RedactorAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Redactor Widget.
 *
 * @property \dicr\asset\RedactorAsset $assetBundle
 * @property string $sourcePath
 * @property \dicr\widgets\RedactorModule $module
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 * @version 2019
 *
 */
class RedactorWidget extends InputWidget
{
    /**
     * @var array The options underlying for setting up Redactor plugin.
     * @see http://imperavi.com/redactor/docs/settings
     */
    public $clientOptions = [
        'plugins' => [
            'fullscreen',
            'fontcolor', 'fontfamily', 'fontsize',
            'aligment', 'table', 'imagemanager', 'filemanager', 'video',
            'properties',
        ],

        'buttons' => [
            'fullscreen', 'format', 'fontcolor', 'fontfamily', 'fontsize', 'bold', 'italic', 'underline', 'ul', 'ol',
            'link', 'image', 'file', 'video', 'html',
        ],

        'imageResizable' => true,
        'imagePosition' => true,
        'multipleUpload' => false,
        'maxHeight' => '15rem'
    ];

    /**
     * {@inheritDoc}
     * @see \yii\widgets\InputWidget::init()
     */
    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }

        Html::addCssClass($this->options, 'form-control');

        $this->clientOptions['lang'] = $this->clientOptions['lang'] ?? \Yii::$app->language;

        $this->clientOptions['imageUpload'] = Url::to($this->clientOptions['iamgeUpload'] ?? '/redactor/upload/image');

        $this->clientOptions['imageUploadErrorCallback'] = $this->clientOptions['imageUploadErrorCallback'] ?? new JsExpression("function(json){alert(json.error);}");

        if (array_search('imagemanager', $this->clientOptions['plugins'] ?? []) !== false) {
            $this->clientOptions['imageManagerJson'] = $this->clientOptions['imageManagerJson'] ?? '/redactor/upload/image-json';
        }

        $this->clientOptions['fileUpload'] = Url::to($this->clientOptions['fileUpload'] ?? '/redactor/upload/file');

        $this->clientOptions['fileUploadErrorCallback'] = $this->clientOptions['fileUploadErrorCallback'] ?? new JsExpression("function(json){alert(json.error);}");

        if (array_search('filemanager', $this->clientOptions['plugins'] ?? []) !== false) {
            $this->clientOptions['fileManagerJson'] = '/redactor/upload/file-json';
        }

        parent::init();
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        // регистрируем ресурсы
        $asset = RedactorAsset::register($this->view);
        $asset->addLangResources($this->clientOptions['lang']);
        $asset->addPluginsResources($this->clientOptions['plugins'] ?? []);

        // регистрируем плагин
        $this->view->registerJs("$('#{$this->options['id']}').redactor(" . Json::encode($this->clientOptions ?: []) . ");");

        return $this->hasModel() ?
            Html::activeTextarea($this->model, $this->attribute, $this->options) :
            Html::textarea($this->name, $this->value, $this->options);
    }
}
