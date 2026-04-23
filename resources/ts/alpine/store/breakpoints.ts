type Breakpoint = "sm" | "md" | "lg" | "xl" | "2xl";

type BreakpointMap = Record<Breakpoint, number>;

interface BreakpointStore {
    width: number;
    map: BreakpointMap;
    up: (bp: Breakpoint) => boolean;
    down: (bp: Breakpoint) => boolean;
    between: (min: Breakpoint, max: Breakpoint) => boolean;
}

export function createBreakpointsStore(): BreakpointStore {
    const map: BreakpointMap = {
        sm: 640,
        md: 768,
        lg: 1024,
        xl: 1280,
        "2xl": 1536,
    };

    const store: BreakpointStore = Alpine.reactive({
        width: window.innerWidth,
        map,

        up(bp) {
            return this.width >= this.map[bp];
        },

        down(bp) {
            return this.width < this.map[bp];
        },

        between(min, max) {
            return this.width >= this.map[min] && this.width < this.map[max];
        },
    });

    window.addEventListener("resize", () => {
        store.width = window.innerWidth;
    });

    return store;
}
