<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 02:15:27
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\RedactorAsset;
use Yii;
use yii\helpers\Url;
use yii\web\JsExpression;

use function in_array;

/**
 * Redactor Widget.
 *
 * @property string $sourcePath
 * @property RedactorAsset $assetBundle
 * @property RedactorModule $module
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
            'fontcolor',
            'fontfamily',
            'fontsize',
            'alignment',
            'table',
            'imagemanager',
            'filemanager',
            'video',
            'properties',
        ],

        'buttons' => [
            'fullscreen',
            'format',
            'fontcolor',
            'fontfamily',
            'fontsize',
            'bold',
            'italic',
            'underline',
            'alignment',
            'ul',
            'ol',
            'link',
            'image',
            'file',
            'video',
            'html',
        ],

        'imageResizable' => true,
        'imagePosition' => true,
        'multipleUpload' => false,
        'maxHeight' => '15rem',

        'fontcolors' => [
            '#fff', '#000', '#eeece1', '#00f', '#4f81bd', '#f00', '#0f0', '#f0f', '#4bacc6', '#f79646', '#ff0',
            '#f2f2f2', '#7f7f7f', '#ddd9c3', '#c6d9f0', '#dbe5f1', '#f2dcdb', '#ebf1dd', '#e5e0ec', '#dbeef3',
            '#fdeada', '#fff2ca',
            '#d8d8d8', '#595959', '#c4bd97', '#8db3e2', '#b8cce4', '#e5b9b7', '#d7e3bc', '#ccc1d9', '#b7dde8',
            '#fbd5b5', '#ffe694',
            '#bfbfbf', '#3f3f3f', '#938953', '#548dd4', '#95b3d7', '#d99694', '#c3d69b', '#b2a2c7', '#b7dde8',
            '#fac08f', '#f2c314',
            '#a5a5a5', '#262626', '#494429', '#17365d', '#366092', '#953734', '#76923c', '#5f497a', '#92cddc',
            '#e36c09', '#c09100',
            '#7f7f7f', '#0c0c0c', '#1d1b10', '#0f243e', '#244061', '#632423', '#4f6128', '#3f3151', '#31859b',
            '#974806', '#7f6000'
        ]
    ];

    /**
     * @inheritDoc
     */
    public function init() : void
    {
        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ?
                Html::getInputId($this->model, $this->attribute) :
                $this->getId();
        }

        Html::addCssClass($this->options, 'form-control');

        $this->clientOptions['lang'] = $this->clientOptions['lang'] ?? Yii::$app->language;

        $this->clientOptions['imageUpload'] = Url::to(
            $this->clientOptions['imageUpload'] ?? '/upload/image'
        );

        $this->clientOptions['imageUploadErrorCallback'] =
            $this->clientOptions['imageUploadErrorCallback'] ??
            new JsExpression('function(json){alert(json.error);}');

        if (in_array('imagemanager', $this->clientOptions['plugins'] ?? [], true)) {
            $this->clientOptions['imageManagerJson'] =
                $this->clientOptions['imageManagerJson'] ??
                '/redactor/upload/image-json';
        }

        $this->clientOptions['fileUpload'] = Url::to(
            $this->clientOptions['fileUpload'] ?? '/upload/file'
        );

        $this->clientOptions['fileUploadErrorCallback'] =
            $this->clientOptions['fileUploadErrorCallback'] ??
            new JsExpression('function(json){alert(json.error);}');

        if (in_array('filemanager', $this->clientOptions['plugins'] ?? [], true)) {
            $this->clientOptions['fileManagerJson'] = '/redactor/upload/file-json';
        }

        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function run() : string
    {
        // регистрируем ресурсы
        $asset = RedactorAsset::register($this->view);
        $asset->addPluginsResources($this->clientOptions['plugins'] ?? []);

        // регистрируем плагин
        $this->registerPlugin('redactor');

        return $this->hasModel() ?
            Html::activeTextarea($this->model, $this->attribute, $this->options) :
            Html::textarea($this->name, $this->value, $this->options);
    }
}
