import {edit} from "./editingForm.js";

const updateBtn = document.getElementById("editInformation");
const formInformation = document.getElementById('formInformation');
const formDescription = document.getElementById('formDescription');
const inputs = Array.from(formInformation.querySelectorAll('input'));

const btn = document.getElementById('editDescription');
const textarea = document.getElementById('description');


edit(formInformation, inputs , updateBtn);
edit(formDescription, [textarea], btn);

        