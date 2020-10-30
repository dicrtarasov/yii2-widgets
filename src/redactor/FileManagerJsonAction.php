<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:34:15
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use Yii;
use yii\helpers\FileHelper;
use yii\web\HttpException;

use function array_map;
use function count;
use function filesize;
use function pathinfo;

use const PATHINFO_BASENAME;
use const PATHINFO_FILENAME;

/**
 * Class FileManagerJsonAction
 */
class FileManagerJsonAction extends RedactorAction
{
    /**
     * @return array
     * @throws HttpException
     */
    public function run() : array
    {
        if (! Yii::$app->request->isAjax) {
            throw new HttpException(403, 'This action allow only ajaxRequest');
        }

        $config = ['recursive' => true];

        if ($this->module->imageAllowExtensions !== null) {
            $onlyExtensions = array_map(static function ($ext) : string {
                return '*.' . $ext;
            }, $this->module->imageAllowExtensions);

            $config['only'] = $onlyExtensions;
        }

        $result = [];

        $filesPath = FileHelper::findFiles($this->module->saveDir, $config);
        foreach ($filesPath as $filePath) {
            $url = $this->module->fileUrl(pathinfo($filePath, PATHINFO_BASENAME));
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);

            $result[] = [
                'title' => $fileName,
                'name' => $fileName,
                'url' => $url,
                'size' => Yii::$app->formatter->asShortSize(filesize($filePath)),
                'id' => count($result) + 1
            ];
        }

        return $result;
    }
}
