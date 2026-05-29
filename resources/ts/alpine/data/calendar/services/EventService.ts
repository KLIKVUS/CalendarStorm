import Alpine from "alpinejs";
import {
    areIntervalsOverlapping,
    compareAsc,
    compareDesc,
    format,
    isWithinInterval,
} from "date-fns";

import LoaderService from "./LoaderService";

import EventRender from "../utils/EventRender";

import type { ApiRes, ConvertedEventData, EventData } from "../types";
import { api } from "../utils/ApiClient";

export default class EventService {
    public eventRender: EventRender;
    private receivedEvents: EventData[];
    private _events: ConvertedEventData[] = [];

    constructor({ events = [] }: { events?: EventData[] }) {
        this.eventRender = new EventRender();
        this.receivedEvents = events;
    }

    public async init(): Promise<void> {
        LoaderService.addTask({ name: "LoadingEvents" });

        let events: EventData[];

        if (!this.receivedEvents.length) {
            events = await this.FetchFromDatabase();
        } else {
            events = this.receivedEvents;
        }

        const sortedEvents = this.SortEventsByDate(events, "asc");
        const convertedEvents = this.ConvertEventData(sortedEvents);
        const assignEventLayers = this.AssignEventLayers(convertedEvents);

        this._events = assignEventLayers;

        LoaderService.removeTask("LoadingEvents");
    }

    private async FetchFromDatabase(): Promise<EventData[]> {
        const res: ApiRes = await api.get("/events");
        const events: EventData[] = res.data;

        return events;
    }

    private SortEventsByDate(
        events: EventData[],
        sortType: "asc" | "desc",
    ): EventData[] {
        return events.sort((a, b) =>
            sortType === "asc"
                ? compareAsc(new Date(a.beginning), new Date(b.beginning))
                : compareDesc(new Date(a.beginning), new Date(b.beginning)),
        );
    }

    private ConvertEventData(events: EventData[]): ConvertedEventData[] {
        return events.map((event) => {
            const converted: ConvertedEventData = {
                data: event,
                layer: 0,
                offsetHeight: 0,
                isHovered: false,
            };
            return Alpine.reactive(converted);
        });
    }

    private AssignEventLayers(
        events: ConvertedEventData[],
    ): ConvertedEventData[] {
        events.forEach((event1) => {
            for (let layer = 1; ; layer++) {
                const isAvailable = events.every((event2) => {
                    if (
                        event2.data.id === event1.data.id ||
                        (event2.layer >= 0 && event2.layer !== layer)
                    )
                        return true;

                    return !areIntervalsOverlapping(
                        {
                            start: format(event1.data.beginning, "yyyy-MM-dd"),
                            end: format(event1.data.ending, "yyyy-MM-dd"),
                        },
                        {
                            start: format(event2.data.beginning, "yyyy-MM-dd"),
                            end: format(event2.data.ending, "yyyy-MM-dd"),
                        },
                        { inclusive: true },
                    );
                });

                if (isAvailable) {
                    event1.layer = layer;
                    break;
                }
            }
        });

        return events;
    }

    public GetEventsForDay(
        year: number,
        month: number,
        day: number,
    ): ConvertedEventData[] {
        const date = format(new Date(year, month, day), "yyyy-MM-dd");

        return this._events.filter((event) => {
            const evStart = format(
                new Date(event.data.beginning),
                "yyyy-MM-dd",
            );
            const evEnd = format(new Date(event.data.ending), "yyyy-MM-dd");

            return isWithinInterval(date, {
                start: evStart,
                end: evEnd,
            });
        });
    }

    public GetEventsStartingOn(
        year: number,
        month: number,
        day: number,
    ): ConvertedEventData[] {
        const date = format(new Date(year, month, day), "yyyy-MM-dd");

        return this._events.filter((event) => {
            const evStart = format(
                new Date(event.data.beginning),
                "yyyy-MM-dd",
            );

            return isWithinInterval(date, {
                start: evStart,
                end: evStart,
            });
        });
    }

    public get events(): ConvertedEventData[] {
        return this._events;
    }
    private set events(value: ConvertedEventData[]) {
        this._events = value;
    }
}
