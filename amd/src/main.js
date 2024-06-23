import $ from 'jquery';
import ModalForm from 'core_form/modalform';
import {getString} from 'core/str';



export const init = async (root) => {
    console.log(root);
    const triggerElement = document.querySelector('#add_material');
    triggerElement.addEventListener('click', event => {
        event.preventDefault();

        const modalForm = new ModalForm({
            modalConfig: {
                title: getString('contactdataprotectionofficer', 'tool_dataprivacy'),
            },
            formClass: 'block_class_material\\form\\add_material',
            saveButtonText: getString('save', 'block_class_material'),
            returnFocus: triggerElement,
        });

        modalForm.addEventListener(modalForm.events.SUBMIT_BUTTON_PRESSED, event => {
            event.preventDefault();
            $('input[name="cmid"]').val(Number(root.data('course-module-id')))

            if(modalForm.validateElements()) {
                modalForm.submitFormAjax();
            }
        });

        modalForm.show();

    });
};