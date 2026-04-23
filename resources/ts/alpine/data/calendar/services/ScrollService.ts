import LoaderService from "./LoaderService";

export default class ScrollService {
    public async scrollToMonth(monthId: string): Promise<void> {
        await Alpine.nextTick();
        LoaderService.addTask({ name: "scrollToMonth" });

        await Alpine.nextTick();
        const el = document.getElementById(monthId);
        el?.scrollIntoView({ behavior: "instant" });

        await Alpine.nextTick();
        LoaderService.removeTask("scrollToMonth");
    }
}
