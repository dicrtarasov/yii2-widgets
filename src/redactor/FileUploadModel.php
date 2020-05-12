<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 12.05.20 21:11:39
 */

declare(strict_types = 1);

namespace dicr\widgets\redactor;

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
    public function init()
    {
        parent::init();

        $this->allowedExtensions = Yii::$app->controller->module->fileAllowExtensions;
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => $this->allowedExtensions]]
        ];
    }

    /**
     * Загружает файлы
     *
     * {@inheritDoc}
     * @see \yii\base\Model::beforeValidate()
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
                $path = Yii::$app->controller->module->getFilePath($name);

                // сохраняем
                if (! $file->saveAs($path, true)) {
                    throw new RuntimeException('ошибка загрузки файла: ' . $path);
                }

                $key = 'file';
                if (count($this->files) > 1) {
                    $key .= '-' . $i;
                }

                $ret[$key] = [
                    'url' => Yii::$app->controller->module->getUrl($name),
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
