define("block_class_material/AddMaterialModal",["exports","core/modal"],(function(_exports,_modal){var obj;function _defineProperty(obj,key,value){return key in obj?Object.defineProperty(obj,key,{value:value,enumerable:!0,configurable:!0,writable:!0}):obj[key]=value,obj}Object.defineProperty(_exports,"__esModule",{value:!0}),_exports.default=void 0,_modal=(obj=_modal)&&obj.__esModule?obj:{default:obj};class AddMaterialModal extends _modal.default{configure(modalConfig){modalConfig.removeOnClose=!0,super.configure(modalConfig),modalConfig.someValue&&this.setSomeValue(someValue)}setSomeValue(value){this.someValue=value}}return _exports.default=AddMaterialModal,_defineProperty(AddMaterialModal,"TYPE","mod_example/my_modal"),_defineProperty(AddMaterialModal,"TEMPLATE","mod_example/my_modal"),_exports.default}));

//# sourceMappingURL=AddMaterialModal.min.js.map