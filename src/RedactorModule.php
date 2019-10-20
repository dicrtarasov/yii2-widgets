<?php
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\helpers\FileHelper;

/**
 * Модуль редактора.
 *
 * @property-read string $saveDir
 *
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @author Igor Tarasov <develop@dicr.org>
 * @since 2.0
 */
class RedactorModule extends Module
{
    public $controllerNamespace = 'dicr\widgets\redactor';

    public $defaultRoute = 'upload';

    public $uploadDir = '@webroot/uploads';

    public $uploadUrl = '@web/uploads';

    public $imageAllowExtensions = ['jpg', 'png', 'gif', 'bmp', 'svg'];

    public $fileAllowExtensions;

    /** @var bool раздельно хранить файлы пользоваелей */
    public $separateOwner = false;

    /**
     * {@inheritDoc}
     * @see \yii\base\Module::init()
     */
    public function init()
    {
        parent::init();

        $this->uploadDir = \Yii::getAlias($this->uploadDir, true);
        if (empty($this->uploadDir)) {
            throw new InvalidConfigException('upload directory not exists: ' . $this->uploadDir);
        } elseif (!is_dir($this->uploadDir)) {
            throw new InvalidConfigException('not a directory: ' . $this->uploadDir);
        } elseif (!is_writable($this->uploadDir)) {
            throw new InvalidConfigException('not writeable: ' . $this->uploadDir);
        }

        $this->uploadUrl = \Yii::getAlias($this->uploadUrl, true);
    }

    /**
     * Возвращает папку для загрузки файлов
     *
     * @return string
     */
    public function getSaveDir()
    {
        $dir = $this->uploadDir;

        // добавляем путь владельца
        if ($this->separateOwner) {
            $dir .= DIRECTORY_SEPARATOR . (int)\Yii::$app->user->id;
        }

        // создаем директорию
        if (!@file_exists($dir) && !FileHelper::createDirectory($dir, 0775, true)) {
            throw new InvalidConfigException('$uploadDir does not exist and default path creation failed');
        }

        return $dir;
    }

    /**
     * Возвращает путь файла.
     *
     * @param string $filename
     * @return string
     * @throws InvalidConfigException
     */
    public function getFilePath(string $filename)
    {
        return $this->saveDir . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Возвращает URL файла
     *
     * @param string $filename
     * @return string
     */
    public function getUrl(string $filename)
    {
        $url = $this->uploadUrl;

        if ($this->separateOwner) {
            $url .= '/' . (int)\Yii::$app->user->id;
        }

        $url .= '/' . $filename;

        return $url;
    }
}
