import $ from 'jquery';
import ModalForm from 'core_form/modalform';
import {getString} from 'core/str';
import Templates from 'core/templates';
import Notification from 'core/notification';
import ModalDeleteCancel from 'core/modal_delete_cancel';


const addItem = root => {
    const triggerElement = root.find('#add_material');
    triggerElement.off();
    triggerElement.on('click', event => {
        event.preventDefault();

        const modalForm = new ModalForm({
            modalConfig: {
                title: getString('form_title', 'block_class_material'),
            },
            formClass: 'block_class_material\\form\\add_material',
            saveButtonText: getString('save', 'block_class_material'),
            returnFocus: triggerElement,
        });

        modalForm.addEventListener(modalForm.events.SUBMIT_BUTTON_PRESSED, event => {
            event.preventDefault();
            $('input[name="cmid"]').val(Number(root.data('course-module-id')));

            if(modalForm.validateElements()) {
                modalForm.submitFormAjax();
            }
        });

        modalForm.show();

        modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, async event => {
            await drawItem(root, event.detail);
            Notification.addNotification({
                message: getString('upload_success', 'block_class_material'),
                type: 'success',
                closebutton: true,
                annouce: true,
            });
        });
    });
};

const drawItem = async (root, data) => {
    const fileItemTemplate = await Templates.render('block_class_material/file-item', data);
    root.find('.document-container').append(fileItemTemplate);
    loadActions(root);
};

const loadActions = root => {
    const deleteButtons = root.find('.document-item-actions-button-delete');

    deleteButtons.off();
    deleteButtons.on('click', async event => {
        event.preventDefault();
        const modal = await ModalDeleteCancel.create({
            title: getString('modal_delete_document_title', 'block_class_material'),
            body: getString('modal_delete_document_body', 'block_class_material'),
            isVerticallyCentered: true,
        });

        modal.show();
    });
};


export const init = async (root) => {
    addItem(root);
    loadActions(root);
};