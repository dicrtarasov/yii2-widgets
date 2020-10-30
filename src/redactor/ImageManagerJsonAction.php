<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:34:15
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;

use function count;

/**
 * Class ImageManagerJsonAction
 */
class ImageManagerJsonAction extends RedactorAction
{
    /**
     * @return array
     * @throws Exception
     */
    public function run() : array
    {
        if (! Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('This action allow only ajaxRequest');
        }

        $onlyExtensions = array_map(static function ($ext) : string {
            return '*.' . $ext;
        }, $this->module->imageAllowExtensions ?: []);

        $result = [];

        $filesPath = FileHelper::findFiles($this->module->saveDir, [
            'recursive' => true,
            'only' => $onlyExtensions
        ]);

        foreach ($filesPath as $filePath) {
            $url = $this->module->fileUrl(pathinfo($filePath, PATHINFO_BASENAME));

            $result[] = [
                'thumb' => $url,
                'url' => $url,
                'title' => pathinfo($filePath, PATHINFO_FILENAME),
                'id' => count($result) + 1
            ];
        }

        return $result;
    }
}
