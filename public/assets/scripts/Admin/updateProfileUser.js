import {edit} from "../editingForm.js";

const updateBtn = document.getElementById("editInformation");
const formInformation = document.getElementById('formInformation');
const formDescription = document.getElementById('formDescription');
const inputs = Array.from(formInformation.querySelectorAll('input'));
const hiddenSubmitButton = document.getElementById("hiddenSubmit");
const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');
const hiddenDescriptionSubmitButton = document.getElementById("hiddenDescriptionSubmit");

edit(formInformation, inputs , updateBtn, hiddenSubmitButton);
edit(formDescription, [textarea], btn, hiddenDescriptionSubmitButton);