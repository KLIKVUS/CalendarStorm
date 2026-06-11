export default function (this: any) {
    return {
        /**
         * Управление темным режимом
         */
        dark_mode: this.$persist(undefined).as("dark_mode") as any,

        /**
         * Инициализация
         * @constructor
         */
        init() {
            // Включаем темный режим, если он включен в системе
            if (localStorage.dark_mode == "undefined") {
                this.toggleDarkMod(
                    window.matchMedia("(prefers-color-scheme: dark)").matches,
                );
            }
        },

        /**
         * Переключение темного режима
         * @param {boolean} [value=!this.dark_mode]
         */
        toggleDarkMod(this: any, value = !this.dark_mode) {
            this.dark_mode = value;
        },
    };
}
