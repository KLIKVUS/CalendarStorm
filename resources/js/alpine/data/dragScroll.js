export default function () {
    return {
        posX: 0, // Текущая позиция по X
        posY: 0, // Текущая позиция по Y
        lastPosX: 0, // Предыдущая позиция для инерции по X
        lastPosY: 0, // Предыдущая позиция для инерции по Y
        friction: 0.98, // Коэффициент трения
        velocityX: 10, // Скорость инерции по X
        velocityY: 10, // Скорость инерции по Y
        scrolling: false, // Флаг, идет ли скроллинг
        scrollContainer: null,

        init({ friction = this.friction, velocityX = this.velocityX, velocityY = this.velocityY } = {}) {
            this.friction = friction;
            this.velocityX = velocityX;
            this.velocityY = velocityY;
            this.scrollContainer = this.$el;
        },

        startDrag(event) {
            this.scrolling = true;
            this.lastPosX = event.clientX || event.touches[0].clientX;
            this.lastPosY = event.clientY || event.touches[0].clientY;
            this.velocityX = 0;
            this.velocityY = 0;
        },

        onDrag(event) {
            if (!this.scrolling) return;

            let currentPosX = event.clientX || event.touches[0].clientX;
            let currentPosY = event.clientY || event.touches[0].clientY;
            let deltaX = currentPosX - this.lastPosX;
            let deltaY = currentPosY - this.lastPosY;

            this.scrollContainer.scrollLeft -= deltaX;
            this.scrollContainer.scrollTop -= deltaY;

            this.velocityX = deltaX;
            this.velocityY = deltaY;

            this.lastPosX = currentPosX;
            this.lastPosY = currentPosY;
        },

        stopDrag() {
            if (this.scrolling) {
                this.scrolling = false;
                this.applyInertia();
            }
        },

        applyInertia() {
            const step = () => {
                if (Math.abs(this.velocityX) > 0.1 || Math.abs(this.velocityY) > 0.1) {
                    this.scrollContainer.scrollLeft -= this.velocityX;
                    this.scrollContainer.scrollTop -= this.velocityY;

                    this.velocityX *= this.friction;
                    this.velocityY *= this.friction;

                    requestAnimationFrame(step);
                }
            };
            requestAnimationFrame(step);
        },
    };
}
