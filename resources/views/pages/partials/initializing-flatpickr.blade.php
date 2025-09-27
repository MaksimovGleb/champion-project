
function initializeFlatpickr(inputId, defaultStartDate, defaultEndDate, enabledCheckboxName) {
    var dateInput = document.getElementById(inputId);

    flatpickr(dateInput, {
        mode: 'range',
        dateFormat: 'd.m.Y',
        locale:
            {
                rangeSeparator: ' - ', // установка короткого разделителя диапазона
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
                    longhand: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"]
                },
                months: {
                    shorthand: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
                    longhand: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
                },
                applyButtonText: 'Применить',
                cancelButtonText: 'Отмена',
                weekAbbreviation: 'Н'
            },
        defaultDate: [defaultStartDate, defaultEndDate],
        allowInput: true,
        onReady: function(selectedDates, dateStr, instance) {
            var input = instance.input;
            input.addEventListener('input', function() {
                var dates = input.value.split(' - ');
                if (dates.length === 2) {
                    instance.setDate([dates[0], dates[1]], true);
                }
            });
        }
    });

    // Обработчик изменения состояния чекбокса
    if (enabledCheckboxName) {
        $('input[name="' + enabledCheckboxName + '"]').change(function() {
            var isEnabled = $(this).prop('checked');
            dateInput.disabled = !isEnabled;
        });
    }
}
