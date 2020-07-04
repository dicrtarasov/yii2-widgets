<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 22:37:24
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
 * @noinspection PhpUnused
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
            'aligment',
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
        'maxHeight' => '15rem'
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (! isset($this->options['id'])) {
            $this->options['id'] =
                $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }

        Html::addCssClass($this->options, 'form-control');

        $this->clientOptions['lang'] = $this->clientOptions['lang'] ?? Yii::$app->language;

        $this->clientOptions['imageUpload'] = Url::to($this->clientOptions['imageUpload'] ?? '/redactor/upload/image');

        $this->clientOptions['imageUploadErrorCallback'] =
            $this->clientOptions['imageUploadErrorCallback'] ?? new JsExpression('function(json){alert(json.error);}');

        if (in_array('imagemanager', $this->clientOptions['plugins'] ?? [], true)) {
            $this->clientOptions['imageManagerJson'] =
                $this->clientOptions['imageManagerJson'] ?? '/redactor/upload/image-json';
        }

        $this->clientOptions['fileUpload'] = Url::to($this->clientOptions['fileUpload'] ?? '/redactor/upload/file');

        $this->clientOptions['fileUploadErrorCallback'] =
            $this->clientOptions['fileUploadErrorCallback'] ?? new JsExpression('function(json){alert(json.error);}');

        if (in_array('filemanager', $this->clientOptions['plugins'] ?? [], true)) {
            $this->clientOptions['fileManagerJson'] = '/redactor/upload/file-json';
        }

        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        // регистрируем ресурсы
        $asset = RedactorAsset::register($this->view);
        $asset->addLangResources($this->clientOptions['lang']);
        $asset->addPluginsResources($this->clientOptions['plugins'] ?? []);

        // регистрируем плагин
        $this->registerPlugin('redactor');

        return $this->hasModel() ? Html::activeTextarea($this->model, $this->attribute, $this->options) :
            Html::textarea($this->name, $this->value, $this->options);
    }
}
