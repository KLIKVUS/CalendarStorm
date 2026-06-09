type PopupType = "success" | "error" | "info";

interface PopupItem {
    id: number;
    type: PopupType;
    message: string;
}

class Popup {
    public items: PopupItem[] = [];

    show(type: PopupType, message: string) {
        const id = Date.now();

        this.items.push({
            id,
            type,
            message,
        });

        setTimeout(() => {
            this.items = this.items.filter((p) => p.id !== id);
        }, 10000);
    }
}

export default new Popup();
