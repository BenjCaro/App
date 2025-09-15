import {edit} from "../editingForm.js";

const formState = document.getElementById('formState');

const stateField = document.getElementById('stateField');

const btnEditState = document.getElementById('editState');

edit(formState, [stateField], btnEditState);