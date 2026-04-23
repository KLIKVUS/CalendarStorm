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

import type { ConvertedEventData, EventData } from "../types";

export default class EventService {
    public eventRender: EventRender;
    private _events: ConvertedEventData[];

    constructor({
        events = this.FetchFromDatabase(),
    }: {
        events: EventData[];
    }) {
        this.eventRender = new EventRender();

        LoaderService.addTask({ name: "LoadingEvents" });

        const sortedEvents = this.SortEventsByDate(events, "asc");
        const convertedEvents = this.ConvertEventData(sortedEvents);
        const assignEventLayers = this.AssignEventLayers(convertedEvents);
        this._events = assignEventLayers;

        LoaderService.removeTask("LoadingEvents");
    }

    private FetchFromDatabase(): EventData[] {
        return [
            {
                id: 1,
                name: "Event 1",
                beginning: "2026-04-01 08:00:00",
                ending: "2026-04-01 18:00:00",
                color: "#3f8efc",
            },
            {
                id: 2,
                name: "Event 2",
                beginning: "2026-04-01 09:00:00",
                ending: "2026-04-03 16:00:00",
                color: "#f97316",
            },
            {
                id: 3,
                name: "Event 3",
                beginning: "2026-04-04 19:00:00",
                ending: "2026-04-12 20:00:00",
                color: "#10b981",
            },
            {
                id: 4,
                name: "Event 4",
                beginning: "2026-03-31 11:30:00",
                ending: "2026-04-07 19:30:00",
                color: "#ef4444",
            },
            {
                id: 5,
                name: "Event 5",
                beginning: "2026-04-02 11:30:00",
                ending: "2026-04-03 19:30:00",
                color: "#8b5cf6",
            },
            {
                id: 6,
                name: "Event 6",
                beginning: "2026-04-04 11:30:00",
                ending: "2026-04-11 19:30:00",
                color: "#14b8a6",
            },
            {
                id: 7,
                name: "Event 7",
                beginning: "2026-04-08 11:30:00",
                ending: "2026-04-10 19:30:00",
                color: "#eab308",
            },
            {
                id: 8,
                name: "Event 8",
                beginning: "2026-04-11 11:30:00",
                ending: "2026-04-13 19:30:00",
                color: "#ec4899",
            },
        ];
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
