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

class ModalService {
    public modalsNames: string[] = [
        "CreateEvent",
        "ReadEvent",
        "UpdateEvent",
    ];
    public activeModal: string | undefined = undefined;
    public modalsData: { [key: string]: any } = {
        EventModal: {
            CreateEvent: eventDataTemplate,
            ReadEvent: eventDataTemplate,
            UpdateEvent: eventDataTemplate,
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

    public SetModalData(modalName: string, data: any) {
        this.modalsData[modalName] = data;
    }
}

export default new ModalService();
