<?php
declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:26:34
 */

namespace dicr\widgets\redactor;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use function count;
use function is_array;

/**
 * Class FileManagerJsonAction
 *
 * @package dicr\widgets\redactor
 */
class FileManagerJsonAction extends Action
{
    /**
     * @throws \yii\web\HttpException
     */
    public function init()
    {
        if (! Yii::$app->request->isAjax) {
            throw new HttpException(403, 'This action allow only ajaxRequest');
        }
    }

    /**
     * @return array|null
     */
    public function run()
    {
        $config = ['recursive' => true];
        if (Yii::$app->controller->module->imageAllowExtensions !== null) {
            $onlyExtensions = array_map(static function($ext) {
                return '*.' . $ext;
            }, Yii::$app->controller->module->imageAllowExtensions);
            $config['only'] = $onlyExtensions;
        }

        $filesPath = FileHelper::findFiles(Yii::$app->controller->module->saveDir, $config);

        if (is_array($filesPath) && count($filesPath)) {
            $result = [];
            foreach ($filesPath as $filePath) {
                $url = Yii::$app->controller->module->getUrl(pathinfo($filePath, PATHINFO_BASENAME));
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

        return null;
    }
}
