<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 09:27:14
 */

declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:29:32
 */

namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\InvalidConfigException;
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
     * @throws HttpException
     */
    public function init()
    {
        if (! Yii::$app->request->isAjax) {
            throw new HttpException(403, 'This action allow only ajaxRequest');
        }
    }

    /**
     * Модуль редактора.
     *
     * @return RedactorModule
     */
    protected function module()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->controller->module;
    }

    /**
     * @return array|null
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function run()
    {
        $onlyExtensions = array_map(static function($ext) {
            return '*.' . $ext;
        }, $this->module()->imageAllowExtensions);

        $filesPath = FileHelper::findFiles($this->module()->getSaveDir(), [
            'recursive' => true,
            'only' => $onlyExtensions
        ]);
        if (is_array($filesPath) && count($filesPath)) {
            $result = [];
            foreach ($filesPath as $filePath) {
                $url = $this->module()->getUrl(pathinfo($filePath, PATHINFO_BASENAME));
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
