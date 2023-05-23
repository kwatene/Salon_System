//Script to add another Job Title

const container = document.getElementById('job-title-container');
const button = document.getElementById('add-job-title');
const formGroupTemplate = document.querySelector('.form-group');

button.addEventListener('click', () => {
    const newFormGroup = formGroupTemplate.cloneNode(true);
    container.appendChild(newFormGroup);
    i++;
});