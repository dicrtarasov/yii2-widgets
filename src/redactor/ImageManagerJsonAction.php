<?php
declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:29:32
 */

namespace dicr\widgets\redactor;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use function count;
use function is_array;

/**
 * Class ImageManagerJsonAction
 *
 * @package dicr\widgets\redactor
 */
class ImageManagerJsonAction extends Action
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
        $onlyExtensions = array_map(static function($ext) {
            return '*.' . $ext;
        }, Yii::$app->controller->module->imageAllowExtensions);
        $filesPath = FileHelper::findFiles(Yii::$app->controller->module->getSaveDir(), [
            'recursive' => true,
            'only' => $onlyExtensions
        ]);
        if (is_array($filesPath) && count($filesPath)) {
            $result = [];
            foreach ($filesPath as $filePath) {
                $url = Yii::$app->controller->module->getUrl(pathinfo($filePath, PATHINFO_BASENAME));
                $result[] = [
                    'thumb' => $url,
                    'url' => $url,
                    'title' => pathinfo($filePath, PATHINFO_FILENAME),
                    'id' => count($result) + 1
                ];
            }
            return $result;
        }

        return null;
    }
}
