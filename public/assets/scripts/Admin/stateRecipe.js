import {edit} from "../editingForm.js";

const formState = document.getElementById('formState');

const stateField = document.getElementById('stateField');

const btnEditState = document.getElementById('editState');

const hiddenSubmitButton = document.getElementById('hiddenSubmit');

edit(formState, [stateField], btnEditState, hiddenSubmitButton);