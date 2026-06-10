const eventDataTemplate = {
    id: null,
    calendarId: null,
    active: true,
    name: "",
    description: "",
    link: "",
    color: "#00000000",
    beginning: "",
    ending: "",
    rights_of_the_current_user: {
        is_user_can_update: false,
        is_user_can_delete: false,
    },
};
const calendarDataTemplate = {
    id: null,
    name: "",
};

class ModalService {
    public modalsNames: string[] = [
        "CreateEvent",
        "ReadEvent",
        "UpdateEvent",
        "CreateCalendar",
        "UpdateCalendar",
    ];
    public activeModal: string | undefined = undefined;
    public modalsData: { [key: string]: any } = {
        EventModal: {
            CreateEvent: eventDataTemplate,
            ReadEvent: eventDataTemplate,
            UpdateEvent: eventDataTemplate,
        },
        CalendarModal: {
            CreateCalendar: calendarDataTemplate,
            UpdateCalendar: calendarDataTemplate,
        },
    };

    public OpenModal(modalName: string) {
        const isModal = this.modalsNames.includes(modalName);
        if (!isModal) return;
        this.activeModal = modalName;
    }

    public CloseModal() {
        this.activeModal = undefined;
    }

    public SetModalData(path: string, data: any) {
        const keys = path.split(".");

        let target = this.modalsData;

        for (let i = 0; i < keys.length - 1; i++) {
            target = target[keys[i]];
        }

        target[keys[keys.length - 1]] = data;
    }
}

export default new ModalService();
