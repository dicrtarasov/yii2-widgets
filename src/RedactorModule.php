<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 21.01.20 18:37:16
 */

declare(strict_types = 1);

namespace dicr\widgets;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\helpers\FileHelper;
use const DIRECTORY_SEPARATOR;

/**
 * Модуль редактора.
 *
 * @property-read string $saveDir
 */
class RedactorModule extends Module
{
    /** @inheritDoc */
    public $controllerNamespace = 'dicr\widgets\redactor';

    /** @inheritDoc */
    public $defaultRoute = 'upload';

    /** @var string директория для загрузки картинок */
    public $uploadDir = '@webroot/uploads';

    /** @var string базовый URL загруженных картинок */
    public $uploadUrl = '@web/uploads';

    /** @var array расширения картинок, разрешенных для загрузки */
    public $imageAllowExtensions = ['jpg', 'png', 'gif', 'bmp', 'svg'];

    /** @var array расширения файлов, разрешеных для загрузки */
    public $fileAllowExtensions;

    /** @var bool раздельно хранить файлы пользоваелей */
    public $separateOwner = false;

    /**
     * {@inheritDoc}
     * @throws InvalidConfigException
     * @throws InvalidConfigException
     * @throws InvalidConfigException
     * @see \yii\base\Module::init()
     */
    public function init()
    {
        parent::init();

        $this->uploadDir = Yii::getAlias($this->uploadDir, true);
        if (empty($this->uploadDir)) {
            throw new InvalidConfigException('upload directory not exists: ' . $this->uploadDir);
        }

        if (! is_dir($this->uploadDir)) {
            throw new InvalidConfigException('not a directory: ' . $this->uploadDir);
        }

        if (! is_writable($this->uploadDir)) {
            throw new InvalidConfigException('not writeable: ' . $this->uploadDir);
        }

        $this->uploadUrl = Yii::getAlias($this->uploadUrl, true);
        if (empty($this->uploadUrl)) {
            throw new InvalidConfigException('invalid upload url');
        }
    }

    /**
     * Возвращает папку для загрузки файлов.
     *
     * @return string
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function getSaveDir()
    {
        $dir = $this->uploadDir;

        // добавляем путь владельца
        if ($this->separateOwner) {
            $dir .= DIRECTORY_SEPARATOR . (int)Yii::$app->user->id;
        }

        // создаем директорию
        if (! file_exists($dir) && ! FileHelper::createDirectory($dir, 0775, true)) {
            throw new InvalidConfigException('$uploadDir does not exist and default path creation failed');
        }

        return $dir;
    }

    /**
     * Возвращает путь файла.
     *
     * @param string $filename
     * @return string
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
            $url .= '/' . (int)Yii::$app->user->id;
        }

        $url .= '/' . $filename;

        return $url;
    }
}