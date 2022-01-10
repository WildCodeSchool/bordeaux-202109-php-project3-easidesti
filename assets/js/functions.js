const addPosition = (span, nameInput) => {
    span.className = 'word-letter fs-1 text-danger btn positions';
    const input = document.createElement('input');
    input.classList.add('input-endpoint');
    input.type = 'hidden';
    input.id = `${nameInput}_${span.id}`;
    input.name = `${nameInput}[]`;
    input.value = span.id;
    return input;
};
const createSpan = (parent, name, letter) => {
    const span = document.createElement('span');
    span.className = `word-letter btn fs-2 ${name}`;
    span.id = document.getElementsByClassName(name).length;
    span.innerText = letter;
    span.innerText = letter;
    span.innerText = letter;
    return span;
};
const deletePosition = (span, nameInput) => {
    const hiddenInputs = document.getElementsByClassName('input-endpoint');
    for (let i = 0; i < hiddenInputs.length; i++) {
        if (hiddenInputs[i].id === nameInput) {
            hiddenInputs[i].remove();
            span.className = 'word-letter fs-2 btn positions';
        }
    }
};

export { addPosition, createSpan, deletePosition };
