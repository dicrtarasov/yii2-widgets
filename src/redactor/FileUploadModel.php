<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:28:01
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use RuntimeException;
use Throwable;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

use function count;

/**
 * Class FileUploadModel
 *
 * @property-read RedactorModule $module
 */
class FileUploadModel extends Model
{
    /** @var UploadedFile[] */
    public array $files = [];

    /** @var string[] разрешенные расширения */
    protected array $allowedExtensions = [];

    /**
     * Инициализация.
     */
    public function init() : void
    {
        parent::init();

        $this->allowedExtensions = $this->module->fileAllowExtensions;
    }

    /**
     * Модуль редактора.
     *
     * @return RedactorModule
     */
    protected function getModule() : RedactorModule
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::$app->controller->module;
    }

    /**
     * {@inheritDoc}
     */
    public function rules() : array
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => $this->allowedExtensions]]
        ];
    }

    /**
     * {@inheritDoc}
     *
     * Загружает файлы
     */
    public function beforeValidate() : bool
    {
        if (! parent::beforeValidate()) {
            return false;
        }

        $this->files = UploadedFile::getInstancesByName('file');

        return true;
    }

    /**
     * Upload files.
     *
     * @return array response
     */
    public function upload() : array
    {
        $ret = [];

        try {
            if (! $this->validate()) {
                throw new RuntimeException('validate');
            }

            foreach ($this->files as $i => $file) {
                // имя файла
                $name = self::getFileName($file);

                // полный путь файла
                $path = $this->getModule()->filePath($name);

                // сохраняем
                if (! $file->saveAs($path)) {
                    throw new RuntimeException('ошибка загрузки файла: ' . $path);
                }

                $key = 'file';
                if (count($this->files) > 1) {
                    $key .= '-' . $i;
                }

                $ret[$key] = [
                    'url' => $this->getModule()->fileUrl($name),
                    'name' => $name,
                    'id' => md5(date('YmdHis'))
                ];
            }
        } catch (Throwable $ex) {
            $ret = [
                'error' => $ex->getMessage(),
                'debug' => (string)$ex
            ];
        }

        return $ret;
    }

    /**
     * Генерирует имя файла.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected static function getFileName(UploadedFile $file) : string
    {
        $fileName = substr(uniqid(md5((string)mt_rand()), true), 0, 10);
        $fileName .= '-' . Inflector::slug($file->baseName);
        $fileName .= '.' . $file->extension;

        return $fileName;
    }
}
