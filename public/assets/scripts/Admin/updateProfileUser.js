import {edit} from "../editingForm.js";

const updateBtn = document.getElementById("editInformation");
const formInformation = document.getElementById('formInformation');
const formDescription = document.getElementById('formDescription');
const inputs = Array.from(formInformation.querySelectorAll('input'));
const hiddenSubmitButton = document.getElementById("hiddenSubmit");

const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');
const hiddenDescriptionSubmitButton = document.getElementById("hiddenDescriptionSubmit");

const editBtn = document.getElementById('editRole');
const formRole = document.getElementById('formRole');
const roleInput = document.getElementById('role');
const hiddenBtnRole = document.getElementById('hiddenSubmitRole');

edit(formInformation, inputs , updateBtn, hiddenSubmitButton);
edit(formDescription, [textarea], btn, hiddenDescriptionSubmitButton);
edit(formRole, [roleInput], editBtn, hiddenBtnRole);