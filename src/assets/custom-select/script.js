/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 09.01.21 18:05:36
 */

"use strict";

(function (window, $) {
    // noinspection ES6ConvertVarToLetConst
    /** @var {string} селектор класса виджета */
    var selector = '.widget-custom-select';

    // noinspection JSUnusedGlobalSymbols
    /**
     * Искусственный элемент select.
     *
     * Функции:
     *
     * $widget[0].val(), $widget.val() - получить значение
     * $widget[0].val(val) - установить значение
     * $widget[0].items(...) - установить новые элементы
     * $widget.on('change', function(e, value) {}) - событие изменения
     *
     * @param {HTMLElement} target
     * @constructor
     */
    function CustomSelectWidget(target)
    {
        // noinspection ES6ConvertVarToLetConst
        var self = this;

        self.dom = $(target);
        self.dom.button = $('button', self.dom);
        self.dom.list = $('datalist', self.dom);
        self.labelWidth = null;

        /**
         * обновляет кнопку текущим значением выбранного элемента
         *
         * @param {JQuery} $input активный измененный radio input
         */
        self.updateValue = function ($input) {
            if ($input.length > 0) {
                // обновляем значение виджета
                self.dom[0].value = $input[0].value;

                // noinspection ES6ConvertVarToLetConst
                var $label = $input.next('label');
                if ($label.length > 0) {
                    self.dom.button.empty().append(
                        $label.clone().removeAttr('for').width(self.labelWidth)
                    );
                }
            }
        };

        /**
         * Рассчитывает и обновляет ширину кнопки виджета по самой широкой из списка элементов
         */
        self.updateWidth = function () {
            // временно включаем datalist
            self.dom.addClass('open');

            // ожидаем отрисовки
            window.requestAnimationFrame(function () {
                // определяем максимальную ширину
                self.labelWidth = 0;

                $('label', self.dom.list).each(function () {
                    // noinspection ES6ConvertVarToLetConst
                    var width = $(this).width;
                    if (width > self.labelWidth) {
                        self.labelWidth = width;
                    }
                });

                // прячем
                self.dom.removeClass('open');

                // устанавливаем ширину кнопки по максимальной
                $('label', self.dom.button).css('width', self.labelWidth);
            });
        };

        /**
         * Установить/получить значение элемента.
         *
         * @param {string|undefined} value
         * @returns {string|JQuery}
         */
        self.val = function (value) {
            if (typeof value === 'undefined') {
                return self.dom[0].value;
            }

            // noinspection ES6ConvertVarToLetConst, JSStringConcatenationToES6Template
            var $input = $('input[value="' + value + '"]', self.dom.list);
            // noinspection JSUnusedGlobalSymbols
            $input[0].checked = true;
            self.updateValue($input);

            return self.dom;
        };

        // noinspection JSUnusedGlobalSymbols

        /**
         * Установить новые значения
         *
         * $widget[0].items(...)
         *
         * @param {string} name название поля ввода
         * @param {{
         *     label: string
         *     encode: boolean|undefined,
         *     class: string|undefined
         * }[]|string[]} items значения value => string| item{label, encode}
         */
        self.items = function (name, items) {
            // удаляем все элементы кроме placeholder
            $('input:not([value=""])', self.dom.list).each(function () {
                $(this).next('label').remove();
                $(this).remove();
            });

            // добавляем новые элементы
            Object.keys(items).forEach(function (value, index) {
                // noinspection ES6ConvertVarToLetConst
                var item = items[value];
                if (typeof item !== 'object') {
                    item = {label: item, encode: true};
                }

                // noinspection ES6ConvertVarToLetConst,JSStringConcatenationToES6Template
                var id = self.dom.attr('id') + '-' + index;

                // noinspection ES6ShorthandObjectProperty
                self.dom.list.append(
                    $('<input/>', {type: 'radio', id: id, name: name, value: value})
                );

                // noinspection ES6ConvertVarToLetConst
                var $label = $('<label/>', {for: id, class: item.class || undefined});
                $label[item.encode ? 'text' : 'html'](item.label);
                self.dom.list.append($label);
            });

            // пересчитываем ширину метки
            self.updateWidth();

            // устанавливаем значение первого элемента
            // noinspection ES6ConvertVarToLetConst
            var $input = $('input:first', self.dom.list);
            $input.prop('checked', true);
            self.updateValue($input);
        };

        // начальное значение элемента
        self.updateValue($('input:checked', self.dom.list));

        // обновляем ширину кнопки
        self.updateWidth();

        // клики по кнопке
        // noinspection JSStringConcatenationToES6Template
        self.dom.button.off(selector).on('click' + selector, function (e) {
            e.preventDefault();

            // переключаем открытое состояние
            self.dom.toggleClass('open');
        });

        // клики по документу
        // noinspection JSStringConcatenationToES6Template
        $(window.document).on('click' + selector, function (e) {
            // пропускаем клики по кнопке виджета
            // noinspection ES6ConvertVarToLetConst
            var $button = $(e.target).closest('button');
            if ($button.length < 1 || $button[0] !== self.dom.button[0]) {
                self.dom.removeClass('open');
            }
        });

        // изменение выбранного значения
        // noinspection JSStringConcatenationToES6Template
        self.dom.list.off(selector).on('change' + selector, 'input', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            // обновляем кнопку и значение элемента
            self.updateValue($(this));
            // эмулируем синтетическое событие change
            self.dom.trigger('change', $(this).val());
        });

        // получение/установка значения
        self.dom[0].val = self.val;

        // установка нового списка элементов
        self.dom[0].items = self.items;
    }

    /**
     * Инициализация всех виджетов на странице
     */
    function init()
    {
        $(window.document).off(selector);

        $(selector, window.document).each(function () {
            $(this).data('widget', new CustomSelectWidget(this));
        });
    }

    // при загрузке страницы
    $(init);

    // при загрузке Ajax
    $(window.document).ajaxComplete(init);
})(window, jQuery);
