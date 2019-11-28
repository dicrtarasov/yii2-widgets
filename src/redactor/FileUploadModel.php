<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:30:09
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
 *
 * @package dicr\widgets\redactor
 */
class FileUploadModel extends Model
{
    /** @var UploadedFile[] */
    public $files;

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => Yii::$app->controller->module->fileAllowExtensions]]
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
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstancesByName('file');
            return true;
        }

        return false;
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
                $name = self::getFileName($file);

                if (! $file->saveAs(Yii::$app->controller->module->getFilePath($name), true)) {
                    throw new RuntimeException('save error');
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
        } /** @noinspection BadExceptionsProcessingInspection */ catch (Throwable $ex) {
            $ret = ['error' => 'Unable to save file'];
        }

        return $ret;
    }

    /**
     * Генерирует имя файла.
     *
     * @param \yii\web\UploadedFile $file
     * @return string
     */
    protected static function getFileName(UploadedFile $file)
    {
        $fileName = substr(uniqid(md5(mt_rand()), true), 0, 10);
        $fileName .= '-' . Inflector::slug($file->baseName);
        $fileName .= '.' . $file->extension;
        return $fileName;
    }
}
