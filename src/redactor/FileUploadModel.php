<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 14.09.20 20:42:08
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
 */
class FileUploadModel extends Model
{
    /** @var UploadedFile[] */
    public $files;

    /** @var string[] разрешенные расширения */
    protected $allowedExtensions;

    /**
     * Инициализация.
     */
    public function init() : void
    {
        parent::init();

        $this->allowedExtensions = $this->module()->fileAllowExtensions;
    }

    /**
     * Модуль редактора.
     *
     * @return RedactorModule
     */
    protected function module()
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
    public function beforeValidate()
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
    public function upload()
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
                $path = $this->module()->getFilePath($name);

                // сохраняем
                if (! $file->saveAs($path)) {
                    throw new RuntimeException('ошибка загрузки файла: ' . $path);
                }

                $key = 'file';
                if (count($this->files) > 1) {
                    $key .= '-' . $i;
                }

                $ret[$key] = [
                    'url' => $this->module()->getUrl($name),
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
    protected static function getFileName(UploadedFile $file)
    {
        $fileName = substr(uniqid(md5((string)mt_rand()), true), 0, 10);
        $fileName .= '-' . Inflector::slug($file->baseName);
        $fileName .= '.' . $file->extension;
        return $fileName;
    }
}
