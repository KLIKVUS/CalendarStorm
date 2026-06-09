import type { ApiRes, EventData, GlobalEventData } from "../types";
import { api } from "../utils/ApiClient";

export default class EventController {
    private events: GlobalEventData[];

    constructor(events: GlobalEventData[] = []) {
        this.events = events;
    }

    public Find(id: number | string): GlobalEventData | undefined {
        return this.events.find((event) => event.data.id === id);
    }

    public Create(event: GlobalEventData): GlobalEventData {
        this.events.push(event);

        return event;
    }

    public async Update(
        id: number | string,
        payload: Partial<EventData>,
    ): Promise<false | ApiRes> {
        const event = this.events.find((event) => event.data.id === id);
        const error: ApiRes = {
            data: null,
            success: false,
            message: "Ивент не найден.",
        };
        if (!event) return error;

        const res: ApiRes = await api.put(`/events/${id}`, payload);
        if (!res.success) return res;

        event.data = {
            ...event.data,
            ...payload,
        };

        return res;
    }

    public Delete(id: number | string): boolean {
        const index = this.events.findIndex((event) => event.data.id === id);

        if (index === -1) {
            return false;
        }

        this.events.splice(index, 1);

        return true;
    }
}
