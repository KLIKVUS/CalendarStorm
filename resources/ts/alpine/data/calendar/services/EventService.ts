import Alpine from "alpinejs";
import {
    compareAsc,
    compareDesc,
    eachMonthOfInterval,
    eachWeekOfInterval,
    format,
    isBefore,
    isWithinInterval,
    parseISO,
    startOfDay,
} from "date-fns";

import LoaderService from "./LoaderService";

import EventRender from "../utils/EventRender";

import type {
    ApiRes,
    ConvertedEventData,
    EventData,
    EventsByWeek,
} from "../types";
import { api } from "../utils/ApiClient";

export default class EventService {
    public eventRender: EventRender;
    private receivedEvents: EventData[];
    private _events: ConvertedEventData[] = [];
    private _eventsByWeek: EventsByWeek = {};

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
        this.AssignEventsToDay(assignEventLayers);

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
        const layerEnds: Date[] = [];

        for (const event of events) {
            let layer = 1;

            while (
                layerEnds[layer] &&
                layerEnds[layer] >= new Date(event.data.beginning)
            ) {
                layer++;
            }

            layerEnds[layer] = new Date(event.data.ending);
            event.layer = layer;
        }

        return events;
    }

    private AssignEventsToDay(events: ConvertedEventData[]): void {
        for (const event of events) {
            const startDate = parseISO(event.data.beginning);
            const endDate = parseISO(event.data.ending);

            const datesToRegister = [
                startDate,

                ...eachWeekOfInterval(
                    {
                        start: startDate,
                        end: endDate,
                    },
                    {
                        weekStartsOn: 1,
                    },
                ).filter((date) => !isBefore(date, startDate)),

                ...eachMonthOfInterval({
                    start: startDate,
                    end: endDate,
                }).filter((date) => !isBefore(date, startDate)),
            ];

            const uniqueDates = new Map<number, Date>();

            for (const date of datesToRegister) {
                uniqueDates.set(startOfDay(date).getTime(), date);
            }

            for (const date of uniqueDates.values()) {
                const dayId = this.eventRender.GetDayIndex(
                    date.getFullYear(),
                    date.getMonth(),
                    date.getDate(),
                );

                this.PushEventToLayerLogic(dayId, event);
            }
        }
    }
    private PushEventToLayerLogic(
        dayId: string,
        event: ConvertedEventData,
    ): void {
        if (!this._eventsByWeek[dayId]) {
            this._eventsByWeek[dayId] = {
                events: [],
                layersCount: event.layer,
            };
        } else {
            const week = this._eventsByWeek[dayId];

            week.layersCount = Math.max(week.layersCount, event.layer);
        }

        this._eventsByWeek[dayId].events.push(event);
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

    public get events(): ConvertedEventData[] {
        return this._events;
    }
    private set events(value: ConvertedEventData[]) {
        this._events = value;
    }

    public get eventsByWeek(): EventsByWeek {
        return this._eventsByWeek;
    }
}
