import {edit} from "./editingForm.js";

const btn = document.getElementById('editPost');
const formEdit = document.getElementById('formPostEdit');
const title = document.getElementById('title');
const content = document.getElementById('content');

edit(formEdit, [title, content], btn);