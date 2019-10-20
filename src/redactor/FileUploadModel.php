<?php
namespace dicr\widgets\redactor;

use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadModel extends \yii\base\Model
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
            ['files', 'each', 'rule' => ['file', 'extensions' => \Yii::$app->controller->module->fileAllowExtensions]]
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
            if (!$this->validate()) {
                throw new \Exception('validate');
            }

            foreach ($this->files as $i => $file) {
                $name = self::getFileName($file);

                if (!$file->saveAs(\Yii::$app->controller->module->getFilePath($name), true)) {
                    throw new \Exception('save error');
                }

                $key = 'file';
                if (count($this->files) > 1) {
                    $key .= '-' . $i;
                }

                $ret[$key] = [
                    'url' => \Yii::$app->controller->module->getUrl($name),
                    'name' => $name,
                    'id' => md5(date('YmdHis'))
                ];
            }
        } catch (\Throwable $ex) {
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
        $fileName = substr(uniqid(md5(rand()), true), 0, 10);
        $fileName .= '-' . Inflector::slug($file->baseName);
        $fileName .= '.' . $file->extension;
        return $fileName;
    }
}
