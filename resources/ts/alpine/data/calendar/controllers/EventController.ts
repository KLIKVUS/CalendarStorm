import type { ApiRes, EventData, GlobalEventData } from "../types";
import { api } from "../utils/ApiClient";

export default class EventController {
    private events: GlobalEventData[];
    private ConvertEventData: Function

    constructor(events: GlobalEventData[] = [], convertEventDataFunc: Function) {
        this.events = events;
        this.ConvertEventData = convertEventDataFunc;
    }

    public async Create(calendarId: number, event: GlobalEventData): Promise<ApiRes> {
        const res: ApiRes = await api.post(`/calendars/${calendarId}/events`, event);
        if (!res.success) return res;
        const newEvent = await this.ConvertEventData([res.data]);
        this.events.push(...newEvent);
        return res;
    }

    public async Update(
        id: number | string,
        payload: Partial<EventData>,
    ): Promise<ApiRes> {
        const event = this.Find(id);
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

    public async Delete(id: number | string): Promise<ApiRes> {
        const index = this.FindIndex(id);
        const error: ApiRes = {
            data: null,
            success: false,
            message: "Ивент не найден.",
        };
        if (index === -1) return error;

        const res: ApiRes = await api.delete(`/events/${id}`);
        if (!res.success) return res;

        this.events.splice(index, 1);
        return res;
    }

    public Find(id: number | string): GlobalEventData | undefined {
        return this.events.find((event) => event.data.id === id);
    }

    public FindIndex(id: number | string): number {
        return this.events.findIndex((event) => event.data.id === id);
    }
}
