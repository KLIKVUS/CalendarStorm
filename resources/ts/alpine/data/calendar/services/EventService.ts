import Alpine from "alpinejs";
import {
    compareAsc,
    compareDesc,
    differenceInCalendarDays,
    eachMonthOfInterval,
    eachWeekOfInterval,
    endOfMonth,
    endOfWeek,
    isBefore,
    isSameDay,
    min,
    parseISO,
    startOfDay,
} from "date-fns";

import LoaderService from "./LoaderService";
import EventRender from "../utils/EventRender";
import EventController from "../controllers/EventController";

import type {
    ApiRes,
    GlobalEventData,
    EventData,
    EventsByDay,
    DayEventData,
    CalendarConfig,
} from "../types";
import { api } from "../utils/ApiClient";

export default class EventService {
    public calendarConfig: CalendarConfig = {};
    public eventRender: EventRender;
    public eventController: EventController;
    private receivedEvents: EventData[];
    private _data = Alpine.reactive({
        events: [] as GlobalEventData[],
        layersEvents: [] as GlobalEventData[][],
        eventsByDay: {} as EventsByDay,
    });

    constructor({
        events = [],
        config,
    }: {
        events?: EventData[];
        config?: CalendarConfig;
    }) {
        if (config) {
            this.calendarConfig = config;
        }

        this.eventRender = new EventRender();
        this.eventController = new EventController(
            this.events,
            this.ConvertEventData,
        );
        this.receivedEvents = events;
    }

    public async init(): Promise<void> {
        LoaderService.addTask({ name: "LoadingEvents" });
        this._data.layersEvents.length = 0;
        this._data.eventsByDay = {};

        let events: GlobalEventData[];
        if (this.receivedEvents.length) {
            events = this.ConvertEventData(this.receivedEvents);
        } else if (this.events.length) {
            events = [...this.events];
        } else {
            events = this.ConvertEventData(await this.FetchFromDatabase());
        }

        if (events.length > 0) {
            const sortedEvents = this.SortEventsByDate(events, "asc");
            const assignEventLayers = this.AssignEventLayers(sortedEvents);
            this.AssignEventsToDay(assignEventLayers);
            this.events = assignEventLayers;
        }

        Alpine.nextTick(() => {
            LoaderService.removeTask("LoadingEvents");
        });
    }

    private async FetchFromDatabase(): Promise<EventData[]> {
        const res: ApiRes = await api.get(this.calendarConfig.eventsUrl || "events");
        const events: EventData[] = res.data;

        return events;
    }

    private SortEventsByDate(
        events: GlobalEventData[],
        sortType: "asc" | "desc",
    ): GlobalEventData[] {
        return events.sort((a, b) =>
            sortType === "asc"
                ? compareAsc(
                      new Date(a.data.beginning),
                      new Date(b.data.beginning),
                  )
                : compareDesc(
                      new Date(a.data.beginning),
                      new Date(b.data.beginning),
                  ),
        );
    }

    private ConvertEventData(events: EventData[]): GlobalEventData[] {
        return events.map((event) => {
            const converted: GlobalEventData = {
                data: event,
                layer: 0,
                offsetHeight: 0,
                isHovered: false,
            };
            return Alpine.reactive(converted);
        });
    }

    private AssignEventLayers(events: GlobalEventData[]): GlobalEventData[] {
        for (const event of events) {
            let layer = 0;
            let layerEvents: GlobalEventData[];

            for (layer; true; layer++) {
                layerEvents = this._data.layersEvents[layer] ??= [];

                let lastEvent: GlobalEventData | undefined =
                    layerEvents?.at(-1);
                if (!lastEvent) break;

                if (
                    new Date(lastEvent.data.ending) >=
                        new Date(event.data.beginning) ||
                    isSameDay(lastEvent.data.beginning, event.data.beginning)
                ) {
                    continue;
                }

                break;
            }

            layerEvents.push(event);
            event.layer = layer;
        }

        return events;
    }

    private AssignEventsToDay(events: GlobalEventData[]): void {
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

            for (const dayDate of uniqueDates.values()) {
                this.AddDayEvent(dayDate, event);
            }
        }
    }

    private AddDayEvent(dayDate: Date, event: GlobalEventData) {
        const dayId = this.eventRender.GetDayIndex(
            dayDate.getFullYear(),
            dayDate.getMonth(),
            dayDate.getDate(),
        );
        let day = (this._data.eventsByDay[dayId] ??= {
            events: [],
        });

        if (day.events.length < event.layer) {
            const countEmptyLayers = event.layer - day.events.length;
            const emptyLayers: [][] = Array(countEmptyLayers).fill(null);
            day.events.push(...emptyLayers);
        }

        const dayEventData: DayEventData = {
            globalData: event,
            dayDate,
            adjacent: {
                left: false,
                right: false,
            },
        };
        this.SetEventAdjacent(dayEventData);

        const dayEvents = (day.events[event.layer] ??= []);
        dayEvents.push(dayEventData);
    }

    private SetEventAdjacent(event: DayEventData): void {
        const layerEvents = this._data.layersEvents[event.globalData.layer];

        const index = layerEvents.findIndex(
            (e) => e.data.id === event.globalData.data.id,
        );
        if (index === -1) return;

        const previousEvent = layerEvents[index - 1];
        const nextEvent = layerEvents[index + 1];

        if (previousEvent) {
            const adjacentLeft =
                differenceInCalendarDays(
                    new Date(previousEvent.data.ending),
                    event.dayDate,
                ) === 0;
            event.adjacent.left = adjacentLeft;
        }

        if (nextEvent) {
            const eventEnding = min([
                event.globalData.data.ending,
                this.GetWeekEndOrMonthEnd(event.dayDate),
            ]);
            const adjacentRight =
                differenceInCalendarDays(
                    new Date(nextEvent.data.beginning),
                    eventEnding,
                ) === 0;
            event.adjacent.right = adjacentRight;
        }
    }

    private GetWeekEndOrMonthEnd(date: Date): Date {
        return min([endOfWeek(date, { weekStartsOn: 1 }), endOfMonth(date)]);
    }

    public get events(): GlobalEventData[] {
        return this._data.events;
    }
    private set events(events: GlobalEventData[]) {
        this._data.events.length = 0;
        this._data.events.push(...events);
    }

    public get eventsByDay(): EventsByDay {
        return this._data.eventsByDay;
    }
}
