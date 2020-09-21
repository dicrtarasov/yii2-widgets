<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 01:52:04
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
    public $controllerNamespace = __NAMESPACE__ . '\\redactor';

    /** @inheritDoc */
    public $defaultRoute = 'upload';

    /** @var string директория для загрузки картинок */
    public $uploadDir = '@webroot/uploads';

    /** @var string базовый URL загруженных картинок */
    public $uploadUrl = '@web/uploads';

    /** @var array расширения картинок, разрешенных для загрузки */
    public $imageAllowExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];

    /** @var array расширения файлов, разрешенных для загрузки */
    public $fileAllowExtensions;

    /** @var bool раздельно хранить файлы пользователей */
    public $separateOwner = false;

    /**
     * {@inheritDoc}
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->uploadDir = Yii::getAlias($this->uploadDir);
        if (empty($this->uploadDir)) {
            throw new InvalidConfigException('upload directory not exists: ' . $this->uploadDir);
        }

        if (! is_dir($this->uploadDir)) {
            throw new InvalidConfigException('not a directory: ' . $this->uploadDir);
        }

        if (! is_writable($this->uploadDir)) {
            throw new InvalidConfigException('not writeable: ' . $this->uploadDir);
        }

        $this->uploadUrl = Yii::getAlias($this->uploadUrl);
        if (empty($this->uploadUrl)) {
            throw new InvalidConfigException('invalid upload url');
        }
    }

    /**
     * Возвращает папку для загрузки файлов.
     *
     * @return string
     * @throws Exception
     */
    public function getSaveDir(): string
    {
        $dir = $this->uploadDir;

        // добавляем путь владельца
        if ($this->separateOwner) {
            $dir .= DIRECTORY_SEPARATOR . (int)Yii::$app->user->id;
        }

        // создаем директорию
        if (! file_exists($dir) && ! FileHelper::createDirectory($dir)) {
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
    public function filePath(string $filename) : string
    {
        return $this->saveDir . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Возвращает URL файла
     *
     * @param string $filename
     * @return string
     */
    public function fileUrl(string $filename) : string
    {
        $url = $this->uploadUrl;

        if ($this->separateOwner) {
            $url .= '/' . (int)Yii::$app->user->id;
        }

        return $url . '/' . $filename;
    }
}
