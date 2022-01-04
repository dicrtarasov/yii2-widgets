<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:31:58
 */

declare(strict_types = 1);
namespace dicr\widgets;

use function ob_get_clean;
use function ob_start;
use function trim;

/**
 * Виджет всплывающей подсказки.
 *
 * Позицию и ориентацию строки, а также размеры popover требуется подстроить дополнительно через css блока,
 * в котором он используется.
 *
 * @deprecated используйте BootStrap popover
 * @link https://getbootstrap.com/docs/4.5/components/popovers/
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

    /** @var string позиция */
    public string $position = self::POS_TOP;

    /** @var ?string оборачиваемый контент */
    public ?string $content = null;

    /** @var ?string содержимое всплывашки */
    public ?string $popup = null;

    /**
     * @inheritDoc
     */
    public function init() : void
    {
        parent::init();

        Html::addCssClass($this->options, ['widget-popover', $this->position]);

        ob_start();
    }

    /**
     * @inheritDoc
     */
    public function run() : string
    {
        $content = $this->content . trim(ob_get_clean());
        if (empty($content)) {
            return '';
        }

        PopoverAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);

        echo $content;

        if (! empty($this->popup)) {
            echo '<div class="popup"><div class="inner">' . $this->popup . '</div></div>';
        }

        echo Html::endTag('section');
        return ob_get_clean();
    }
}
