export default class ModalService {
    public modalsNames: string[] = [
        "CreateEvent",
        "ReadEvent",
        "EditEvent",
        "DeleteEvent",
    ];
    public activeModal: string | undefined = undefined;
    public modalsData: { [key: string]: any } = {
        EventModal: {
            id: null,
            active: true,
            name: "test",
            description: "test description",
            link: "https://test.com",
            color: "#fff",
            beginning: "2024-04-27 06:58:09",
            ending: "024-04-29 16:58:09",
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
        Object.assign(this.modalsData[modalName], data);
    }
}
