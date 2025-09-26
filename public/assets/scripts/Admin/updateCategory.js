import {edit} from "../editingForm.js";


const formCategory = document.getElementById("formUpdateCategory");
const input = Array.from(formCategory.querySelectorAll("input"));
const btn = document.getElementById("editCategory");
const hiddenBtn = document.getElementById("hiddenSubmit");

edit(formCategory, input, btn, hiddenBtn);