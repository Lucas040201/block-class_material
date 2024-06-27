import Ajax from 'core/ajax';


const deleteFile = obj => {
    const request = {
        methodname: 'block_class_material_delete_file',
        args: {
            ...obj
        }
    };

    return Ajax.call([request])[0];
};

export default {
    deleteFile
};