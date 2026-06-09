import Alpine from "alpinejs";

import type { LoaderTask } from "../types";

class LoaderService {
    private data = Alpine.reactive({
        isLoading: true as boolean,
        tasks: [] as LoaderTask[],
    });

    constructor() {
        // this.checkTasks();
    }

    public addTask(task: LoaderTask) {
        this.data.tasks.push(task);
        this.checkTasks();
    }
    public removeTask(taskName: string) {
        const index = this.data.tasks.findIndex((t) => t.name === taskName);

        if (index !== -1) {
            this.data.tasks.splice(index, 1);
        }
        this.checkTasks();
    }

    private checkTasks() {
        const isLoading = this.data.tasks.length > 0;
        this.data.isLoading = isLoading;
    }

    public get isLoading(): boolean {
        return this.data.isLoading;
    }

    public get tasks(): LoaderTask[] {
        return this.data.tasks;
    }
}

export { LoaderService as LoaderServiceClass };
export default new LoaderService();
