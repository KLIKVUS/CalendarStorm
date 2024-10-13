/**
 * Данные для инициализации месяца
 *
 * @typedef {Object} MonthInitialData
 * @property {number} weeks_count - Кол-во недель в месяце
 * @property {MonthData[]} months_data
 * @property {Date} start_date - Дата, с которой начинается месяц
 * @property {Date} end_date - Дата, на которой заканчивается месяц
 */
/**
 * Данные инициализированного месяца
 *
 * @typedef {Object} InitializedMonthData
 * @property {string} index - Индекс месяца. Должен быть уникальным и состоит из года этого месяца, месяца (пример: "2024-8--month-index")
 * @property {number} year - Год, к которому относиться месяц
 * @property {number} month - Месяц, к которому относиться месяц
 * @property {Date} start_date - Дата начала месяца
 * @property {Date} end_date - Дата окончания месяца
 * @property {WeekData[]} weeks - Недели месяца
 * @property {boolean} [is_shown=false] - Находится ли месяц в области видимости пользователя
 */
/**
 * Данные месяца
 *
 * @typedef {Object} MonthData
 * @property {number} year - Год, к которому относиться месяц
 * @property {number} month - Месяц, к которому относиться месяц
 * @property {number} start_day - День, с которого начинается месяц
 * @property {number} end_day - День, на котором заканчивается месяц
 */
/**
 * Данные о неделе
 *
 * @typedef {Object} WeekData
 * @property {string} index - Индекс недели. Должен быть уникальным и состоит из года первого дня недели, месяца первого дня недели и первого дня недели (пример для первой недели октября: "2024-8-30--week-index")
 * @property {DayData[]} days - Данные о днях недели
 */
/**
 * Данные дня
 *
 * @typedef {Object} DayData
 * @property {string} index - Индекс дня. Должен быть уникальным и состоит из года этого дня, месяца этого дня и этого дня (пример: "2024-8-30--day-index")
 * @property {Date} date - Дата
 * @property {number} year - Год
 * @property {number} month - Месяц
 * @property {number} day - День
 */
/**
 * Параметры функции добавления месяца
 *
 * @typedef {Object} AddMonthParams
 * @property {"push" | "unshift" | "init"} add_type - Тип добавления
 * @property {number} year - Год
 * @property {number} month - Месяц
 * @property {Date | null} [calendar_start_date=null] - Дата начала календаря
 * @property {Date | null} [calendar_end_date=null] - Дата конца календаря
 */
/**
 * Параметры функции добавления месяца
 *
 * @typedef {Object} RemoveMonthParams
 * @property {string} month_index - Индекс месяца, который подлежит удалению
 */

/**
 * Массив названий месяцев
 * @typedef {string[]} monthNames
 */
const MONTH_NAMES = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

/**
 * Массив названий дней недели
 * @typedef {string[]} daysNames
 */
const DAY_NAMES = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

export default function () {
    return {
        calendar_data: {
            /** @type {daysNames} */
            DAY_NAMES,

            /** @type {Date} */
            start_date: undefined,
            /** @type {Date} */
            end_date: undefined,

            /** @type {number} */
            selected_year: undefined,
            /** @type {number} */
            selected_month: undefined,

            /** @type {string} */
            selected_month_name: undefined,

            /**
             * Данные месяцев календаря
             * @type {InitializedMonthData[]}
             */
            calendar_months: undefined,

            /** @type {boolean} */
            is_initialized: false,

            /** @type {boolean} */
            is_scrolled: false,

            /**
             * @private
             *
             * @type {{saved_month_index: string, saved_calendar_scroll_top: number}}
             */
            _scroll_data: {
                saved_month_index: undefined,
                saved_calendar_scroll_top: undefined,
            },
        },

        /**
         * Инициализация данных календаря на текущий день
         */
        init() {
            let today = new Date();

            this.selectMonth(today.getFullYear(), today.getMonth());
            this.initSelectedMonth();
        },

        /**
         * Инициализация выбранного месяца
         */
        initSelectedMonth() {
            this._addMonth({
                add_type: "init",
                year: this.calendar_data.selected_year,
                month: this.calendar_data.selected_month,
            });

            this.calendar_data.is_initialized = true;
        },

        /**
         * Задает в качестве выбранного месяца переданный месяц
         * @param {number} year - Год
         * @param {number} month - Месяц
         */
        selectMonth(year, month) {
            this.calendar_data.selected_year = year;
            this.calendar_data.selected_month = month;
            this.calendar_data.selected_month_name = MONTH_NAMES[month];
        },

        // Проверочные функции
        /**
         * Проверка, является ли переданная дата сегодняшней
         * @param {number} [year=this.calendar_data.selected_year] - Год для проверки
         * @param {number} [month=this.calendar_data.selected_month] - Месяц для проверки
         * @param {number} day - День для проверки
         * @returns {boolean}
         */
        isToday(year = this.calendar_data.selected_year, month = this.calendar_data.selected_month, day) {
            const today = new Date();
            const date = new Date(year, month, day);

            return today.toDateString() === date.toDateString();
        },
        /**
         * Проверка, является ли переданный месяц текущим
         * @param {number} [year=this.calendar_data.selected_year] - Год для проверки
         * @param {number} [month=this.calendar_data.selected_month] - Месяц для проверки
         * @returns {boolean}
         */
        isCurrentMonth(year = this.calendar_data.selected_year, month = this.calendar_data.selected_month) {
            const current_year = new Date().getFullYear();
            const current_month = new Date().getMonth();

            return current_year === year && current_month === month;
        },
        /**
         * Проверка, является ли переданный месяц выбранным
         * @param {number} year - Год
         * @param {number} month - Месяц
         * @returns {boolean}
         */
        isSelectedMonth(year, month) {
            return this.calendar_data.selected_year === year && this.calendar_data.selected_month === month;
        },

        // Функции переключения месяцев
        /**
         * Переключение на текущий месяц
         */
        switchToCurrentMonth() {
            let today = new Date();

            this.calendar_data.is_initialized = false;

            this.selectMonth(today.getFullYear(), today.getMonth());
            this.initSelectedMonth();

            this.$nextTick(() => {
                this._scrollToMonth(`${today.getFullYear()}-${today.getMonth()}--month-index`);
            });
        },
        /**
         * Переключение на предыдущий месяц
         */
        switchToPreviousMonth() {
            let { year, month } = this._adjustMonth({ offset: -1 });

            this.calendar_data.is_initialized = false;

            this.selectMonth(year, month);
            this.initSelectedMonth();

            this.$nextTick(() => {
                this._scrollToMonth(`${year}-${month}--month-index`);
            });
        },
        /**
         * Переключение на следующий месяц
         */
        switchToNextMonth() {
            let { year, month } = this._adjustMonth({ offset: 1 });

            this.calendar_data.is_initialized = false;

            this.selectMonth(year, month);
            this.initSelectedMonth();

            this.$nextTick(() => {
                this._scrollToMonth(`${year}-${month}--month-index`);
            });
        },

        // Обработчики
        /**
         * Обработчик пересекаемого входа месяца в область видимости
         * Должен вызываться когда пересекаемый месяц попадает в область видимости.
         * Отвечает за переключение выбранного месяца и инициализацию новых месяцев.
         *
         * @param {InitializedMonthData} month_data - Данные месяца, на котором вызывается эта функция (прокси-объект)
         * @returns
         */
        handleIntersectEnterMonth(month_data, month_index_in_array) {
            if (!this.calendar_data.is_initialized) return;
            if (!this.isSelectedMonth(month_data.year, month_data.month)) this.selectMonth(month_data.year, month_data.month);

            const add_month_params = [];

            if (month_index_in_array == 0) {
                let { year, month } = this._adjustMonth({ year: month_data.year, month: month_data.month, offset: -1 });
                let calendar_end_date = new Date(this.calendar_data.start_date);
                calendar_end_date.setDate(calendar_end_date.getDate() - 1);

                /** @type {AddMonthParams} */
                let add_month_param = {
                    add_type: "unshift",
                    year,
                    month,
                    calendar_end_date,
                };

                add_month_params.push(add_month_param);
            }
            if (month_index_in_array == this.calendar_data.calendar_months.length - 1) {
                let { year, month } = this._adjustMonth({ year: month_data.year, month: month_data.month, offset: 1 });
                let calendar_start_date = new Date(this.calendar_data.end_date);
                calendar_start_date.setDate(calendar_start_date.getDate() + 1);

                /** @type {AddMonthParams} */
                let add_month_param = {
                    add_type: "push",
                    year,
                    month,
                    calendar_start_date,
                };

                add_month_params.push(add_month_param);
            }
            if (add_month_params.length == 0) return;

            month_data.is_shown = true;

            this.calendar_data.is_scrolled = false;

            this.$nextTick(async () => {
                this._saveScrollPos(month_data.index);
                add_month_params.forEach((add_month_param) => this._addMonth(add_month_param));
            }).then(async () => {
                this.calendar_data.is_scrolled = await this._scrollToSavedScrollPos();
            });
        },
        /**
         * Обработчик пересекаемого выхода месяца из области видимости
         * Должен вызываться когда пересекаемый день выходит из области видимости.
         * Отвечает за удаление месяцев, которые больше не просматривается пользователем.
         *
         * @param {InitializedMonthData} month_data - Данные месяца, на котором вызывается эта функция (прокси-объект)
         * @returns
         */
        handleIntersectLeaveMonth(month_data, month_index_in_array) {
            if (!this.calendar_data.is_initialized) return;

            const prev_month = this.calendar_data.calendar_months[month_index_in_array - 1];
            const next_month = this.calendar_data.calendar_months[month_index_in_array + 1];
            const excluded_month_indexes = [];
            let new_calendar_start_date, new_calendar_end_date;

            if (prev_month && !prev_month.is_shown) {
                excluded_month_indexes.push(prev_month.index);
                new_calendar_start_date = new Date(month_data.start_date);
            }
            if (next_month && !next_month.is_shown) {
                excluded_month_indexes.push(next_month.index);
                new_calendar_end_date = new Date(month_data.end_date);
            }
            if (excluded_month_indexes.length == 0) return;

            month_data.is_shown = false;

            this._changeCalendarStartAndEndDate({ new_start_date: new_calendar_start_date, new_end_date: new_calendar_end_date });
            this.calendar_data.calendar_months = this.calendar_data.calendar_months.filter((calendar_month) => !excluded_month_indexes.includes(calendar_month.index));
        },

        // Приватные функции
        /**
         * Добавление месяца
         *
         * @param {AddMonthParams} params - Объект с параметрами для добавления месяца
         */
        _addMonth({ add_type, year, month, calendar_start_date = null, calendar_end_date = null }) {
            const valid_add_types = ["push", "unshift", "init"];
            if (!valid_add_types.includes(add_type)) {
                throw new Error("Недопустимый 'add_type'. Это должно быть 'push', 'unshift' или 'init'.");
            }

            const curr_month_initial_data = this._getMonthInitialData({
                year,
                month,
                start_date: calendar_start_date,
                end_date: calendar_end_date,
            });
            const curr_month_weeks = this._getMonthWeeksData({
                weeks_count: curr_month_initial_data.weeks_count,
                months_data: curr_month_initial_data.months_data,
            });
            const curr_month_data = this._getMonthData({ year, month, weeks: curr_month_weeks, start_date: curr_month_initial_data.start_date, end_date: curr_month_initial_data.end_date });

            let calendar_months = this.calendar_data.calendar_months;
            switch (add_type) {
                case "unshift":
                    this._changeCalendarStartAndEndDate({ new_start_date: curr_month_initial_data.start_date });
                    calendar_months.unshift(curr_month_data);
                    break;

                case "push":
                    this._changeCalendarStartAndEndDate({ new_end_date: curr_month_initial_data.end_date });
                    calendar_months.push(curr_month_data);
                    break;

                default:
                    this._changeCalendarStartAndEndDate({ new_start_date: curr_month_initial_data.start_date, new_end_date: curr_month_initial_data.end_date });
                    this.calendar_data.calendar_months = [curr_month_data];
                    break;
            }
        },

        /**
         * Получение данных о месяце для рендеринга
         *
         * @private
         *
         * @param {Object} [params={}]
         * @param {number} [params.year=this.calendar_data.selected_year] - Год
         * @param {number} [params.month=this.calendar_data.selected_month] - Месяц
         * @param {Date} [params.start_date=null] - Начальная дата
         * @param {Date} [params.end_date=null] - Конечная дата
         * @returns {MonthInitialData} Данные для рендеринга месяца
         */
        _getMonthInitialData({ year = this.calendar_data.selected_year, month = this.calendar_data.selected_month, start_date = null, end_date = null } = {}) {
            let days_in_prev_month = new Date(year, month, 0).getDate();
            let days_in_this_month = new Date(year, month + 1, 0).getDate();

            let first_day_of_this_month = new Date(year, month, 1).getDay();
            let last_day_of_this_month = new Date(year, month + 1, 0).getDay();

            let days_before_first_monday = first_day_of_this_month === 0 ? 6 : first_day_of_this_month - 1;
            let days_after_last_sunday = last_day_of_this_month === 0 ? 0 : 7 - last_day_of_this_month;

            if (!start_date) {
                let { year: adjust_year, month: adjust_month } = this._adjustMonth({ year, month, offset: days_before_first_monday > 0 ? -1 : 0 });
                start_date = new Date(adjust_year, adjust_month, days_before_first_monday > 0 ? days_in_prev_month - days_before_first_monday + 1 : 1);
            }
            if (!end_date) {
                let { year: adjust_year, month: adjust_month } = this._adjustMonth({ year, month, offset: days_after_last_sunday > 0 ? 1 : 0 });
                end_date = new Date(adjust_year, adjust_month, days_after_last_sunday > 0 ? days_after_last_sunday : days_in_this_month);
            }

            let total_days = Math.abs(start_date - end_date) / (24 * 60 * 60 * 1000) + 1;
            let weeks_count = Math.ceil(total_days / 7);

            let current_date = new Date(start_date);
            const months_data = [];

            while (current_date <= end_date) {
                const year = current_date.getFullYear();
                const month = current_date.getMonth();
                const start_day = current_date.getDate();
                const end_of_month = new Date(year, month + 1, 0).getDate();
                const end_day = year === end_date.getFullYear() && month === end_date.getMonth() ? end_date.getDate() : end_of_month;

                months_data.push({
                    year,
                    month,
                    start_day,
                    end_day,
                });

                current_date.setDate(1);
                current_date.setMonth(current_date.getMonth() + 1);
            }

            /** @type {MonthInitialData} */
            const month_initial_data = {
                weeks_count,
                months_data,
                start_date,
                end_date,
            };

            return month_initial_data;
        },
        /**
         * Получение данных месяца
         *
         * @private
         *
         * @param {Object} params
         * @param {number} params.year - Год
         * @param {number} params.month - Месяц
         * @param {WeekData[]} params.weeks - Недели месяца
         * @param {Date} params.start_date - Дата, с которой начинается месяц
         * @param {Date} params.end_date - Дата, на которой заканчивается месяц
         * @returns {InitializedMonthData}
         */
        _getMonthData({ year, month, weeks, start_date, end_date }) {
            /** @type {InitializedMonthData} */
            const month_data = {
                index: `${year}-${month}--month-index`,
                year,
                month,
                start_date,
                end_date,
                weeks,
                is_shown: false,
            };

            return month_data;
        },
        /**
         * Получение данных о неделях в календарь
         *
         * @private
         *
         * @param {Object} params
         * @param {number} params.weeks_count - Количество недель
         * @param {MonthData[]} params.months_data - Данные о месяцах
         * @returns {WeekData[]}
         */
        _getMonthWeeksData({ weeks_count, months_data }) {
            let weeks = [];
            let week_index = 0;

            months_data.forEach((month_data) => {
                let days_counter = month_data.start_day;

                for (week_index; week_index < weeks_count; week_index++) {
                    if (!weeks[week_index]) weeks.push(this._getWeekData(month_data.year, month_data.month, days_counter));

                    let current_week_days = weeks[week_index].days;

                    for (days_counter; days_counter <= month_data.end_day; days_counter++) {
                        if (current_week_days.length === 7) break;

                        let day_data = this._getDayData(month_data.year, month_data.month, days_counter);

                        current_week_days.push(day_data);
                    }

                    if (days_counter > month_data.end_day) break;
                }
            });

            return weeks;
        },
        /**
         * Получение данных о неделе
         *
         * @private
         *
         * @param {number} year - Год
         * @param {number} month - Месяц
         * @param {number} day - День
         * @returns {WeekData} Данные о неделе
         */
        _getWeekData(year, month, day) {
            /** @type {WeekData} */
            const weekData = {
                index: `${year}-${month}-${day}--week-index`,
                days: [],
            };

            return weekData;
        },
        /**
         * Получение данных о дне
         *
         * @private
         *
         * @param {number} year - Год
         * @param {number} month - Месяц
         * @param {number} day - День
         * @returns {Object} Данные о дне
         */
        _getDayData(year, month, day) {
            /** @type {DayData} */
            const dayData = {
                index: `${year}-${month}-${day}--day-index`,
                date: new Date(year, month, day),
                year,
                month,
                day,
            };

            return dayData;
        },

        /**
         * Корректировка года и месяца
         *
         * @private
         *
         * @param {Object} params
         * @param {number} [params.year=this.calendar_data.selected_year] - Год
         * @param {number} [params.month=this.calendar_data.selected_month] - Месяц
         * @param {number} [params.offset=0] - Смещение месяца
         * @returns {{ year: number, month: number }} Скорректированные год и месяц
         */
        _adjustMonth({ year = this.calendar_data.selected_year, month = this.calendar_data.selected_month, offset = 0 }) {
            let date = new Date(year, month, 1);
            date.setMonth(date.getMonth() + offset);

            return { year: date.getFullYear(), month: date.getMonth() };
        },

        /**
         * Прокрутка к сохраненной позиции скролла
         *
         * @private
         *
         * @returns {Promise<boolean>} Успешность восстановления позиции
         */
        _scrollToSavedScrollPos() {
            if (this.calendar_data._scroll_data.saved_month_index === undefined || this.calendar_data._scroll_data.saved_calendar_scroll_top === undefined) {
                throw new Error(
                    "Функция '_scrollToSavedScrollPos' не может быть выполнена из-за отсутствия 'saved_month_index' и 'saved_calendar_scroll_top'. Возможно, что функция '_saveScrollPos' не была вызвана до вызова функции '_scrollToSavedScrollPos'."
                );
            }

            const saved_month = document.getElementById(this.calendar_data._scroll_data.saved_month_index);

            if (!saved_month) {
                throw new Error("Функция '_scrollToSavedScrollPos' не может быть выполнена из-за отсутствия 'saved_month_index' в DOM дереве.");
            }

            const calendar = this.$refs.calendar;
            const new_top_scroll_pos = saved_month.offsetTop + this.calendar_data._scroll_data.saved_calendar_scroll_top;
            const error_of_the_scroll_position = 5;

            return new Promise((resolve, reject) => {
                calendar.scrollTo({
                    top: new_top_scroll_pos,
                    left: 0,
                    behavior: "instant",
                });

                const failed = setTimeout(() => {
                    reject(false);
                }, 2000);
                const scrollHandler = () => {
                    if (Math.abs(calendar.scrollTop - new_top_scroll_pos) <= error_of_the_scroll_position) {
                        calendar.removeEventListener("scroll", scrollHandler);
                        clearTimeout(failed);
                        resolve(true);
                        this.calendar_data._scroll_data = {
                            saved_month_index: undefined,
                            saved_calendar_scroll_top: undefined,
                        };
                    }
                };

                if (calendar.scrollTop === new_top_scroll_pos) {
                    clearTimeout(failed);
                    resolve(true);
                    this.calendar_data._scroll_data = {
                        saved_month_index: undefined,
                        saved_calendar_scroll_top: undefined,
                    };
                } else {
                    calendar.addEventListener("scroll", scrollHandler);
                }
            });
        },
        /**
         * Сохранение текущей позиции скролла
         *
         * @private
         *
         * @param {string} month_index - Индекс месяца. Позволяет сохранить позицию скрола относительно месяца, что позволяет добиться большей точности.
         * Найдет месяц, если в момент вызова функции он находиться в DOM дереве.
         */
        _saveScrollPos(month_index) {
            let calendar = this.$refs.calendar;

            if (!month_index) return;
            const month_element = document.getElementById(month_index);

            if (!month_element) return;

            this.calendar_data._scroll_data.saved_month_index = month_index;
            this.calendar_data._scroll_data.saved_calendar_scroll_top = calendar.scrollTop - month_element.offsetTop;
        },
        /**
         * Прокрутка скрола к месяцу
         *
         * @private
         *
         * @param {string} month_index - Индекс месяца. Позволяет прокрутить скрол к месяцу.
         */
        _scrollToMonth(month_index) {
            if (!month_index) return;
            const month_element = document.getElementById(month_index);

            if (!month_element) return;

            month_element.scrollIntoView({
                behavior: "instant",
            });
        },

        /**
         * Изменение начальной и конечной даты календаря
         *
         * @private
         *
         * @param {Object} params
         * @param {Date} [params.new_start_date] - Новая дата начала календаря
         * @param {Date} [params.new_end_date] - Новая дата окончания календаря
         */
        _changeCalendarStartAndEndDate({ new_start_date, new_end_date }) {
            this.calendar_data.start_date = new_start_date || this.calendar_data.start_date;
            this.calendar_data.end_date = new_end_date || this.calendar_data.end_date;
        },
    };
}
