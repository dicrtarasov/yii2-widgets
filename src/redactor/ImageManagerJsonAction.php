<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:41:27
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use Yii;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;

use function count;

/**
 * Class ImageManagerJsonAction
 */
class ImageManagerJsonAction extends RedactorAction
{
    /**
     * @inheritDoc
     */
    public function run(): array
    {
        if (! Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('This action allow only ajaxRequest');
        }

        $onlyExtensions = array_map(
            static fn($ext): string => '*.' . $ext,
            $this->module->imageAllowExtensions ?: []
        );

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
