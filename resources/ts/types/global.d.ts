import { Alpine as AlpineType } from "alpinejs";

declare global {
    var Alpine: AlpineType;
    interface Window {
        axios: any;
        Pusher: any;
    }
}

export {};
