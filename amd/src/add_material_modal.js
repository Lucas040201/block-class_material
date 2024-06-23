import Modal from 'core/modal';

export default class AddMaterialModal extends Modal {
    static TYPE = 'block_class_material/add_material_modal';
    static TEMPLATE = 'block_class_material/modal/add_material_modal';


    constructor(...config) {
        super(...config);
    }


    configure(modalConfig) {
        modalConfig.removeOnClose = true;

        super.configure(modalConfig);

        this.setButtonText('save', 'Salvar Material')

    }
}

AddMaterialModal.registerModalType();