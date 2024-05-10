import "./bootstrap";

Echo.channel("calendars.5").listen("CalendarEventsUpdate", (e) => {
    console.log(e);
});
