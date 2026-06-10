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
        let currentTask = this.data.tasks.find((t) => t.name === task.name);

        if (!currentTask) {
            this.data.tasks.push(task);
            currentTask = task;
        }

        currentTask.count ??= 0;
        currentTask.count += 1;

        this.checkTasks();
    }

    public removeTask(taskName: string) {
        const index = this.findTaskIndex(taskName);
        if (index === -1) return;

        const task = this.data.tasks[index];
        task.count = (task.count ?? 1) - 1;
        if (task.count <= 0) {
            this.data.tasks.splice(index, 1);
        }

        Alpine.nextTick(() => {
            this.checkTasks();
        });
    }

    private findTaskIndex(taskName: string): number {
        const index = this.data.tasks.findIndex((t) => t.name === taskName);
        return index;
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
