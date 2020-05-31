<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 31.05.20 06:12:06
 */

/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 02.05.20 18:18:45
 */

declare(strict_types = 1);

namespace dicr\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use function ob_get_clean;

/**
 * Виджет всплывающей подсказки.
 *
 * Позицию и ориентацию строки, а также размеры popover требуется подстроить дополнительно через css блока,
 * в котором он используется.
 *
 * Контент виджета добавляется методом обертки:
 * ```php
 * Popover::begin();
 * echo '<a href="javascript:">Ссылка со всплывашкой</a>';
 * Popover::beginPopup();
 * echo '<h3>Заголовок окна</h3>';
 * echo '<p>Текст окна</p>'
 * Popover::endPopup();
 * Popover::end();
 * ```
 *
 * @noinspection PhpUnused
 */
class Popover extends Widget
{
    /** @var string позиция сверху */
    public const POS_TOP = 'top';

    /** @var string позиция снизу */
    public const POS_BOTTOM = 'bottom';

    /** @var string позиция слева */
    public const POS_LEFT = 'left';

    /** @var string позиция справа */
    public const POS_RIGHT = 'right';

    public $position = self::POS_TOP;

    /** @var array опции виджета */
    public $options = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget-popover', $this->position]);
        ob_start();
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $content = trim(ob_get_clean());
        if (empty($content)) {
            return '';
        }

        PopoverAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);
        echo $content;
        echo Html::endTag('section');

        return ob_get_clean();
    }

    /**
     * Начало всплывающего окна.
     */
    public static function beginPopup()
    {
        ob_start();
    }

    /**
     * Конец всплывающего окна
     */
    public static function endPopup()
    {
        $content = ob_get_clean();
        ?>
        <div class="popup">
            <div class="inner">
                <?= $content ?>
            </div>
        </div>
        <?php
    }
}
