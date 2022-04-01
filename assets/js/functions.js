const addPosition = (span, nameInput, className, letter = null) => {
    if (letter === 'é' || letter === 'è' || letter === 'ê' || letter === 'ë') {
        letter = 'e';
    }
    if (letter === 'à' || letter === 'â' || letter === 'ä') {
        letter = 'a';
    }
    if (letter === 'î' || letter === 'ï') {
        letter = 'i';
    }
    span.className = `word-letter fs-1 text-danger btn ${className}`;
    const input = document.createElement('input');
    input.classList.add('input-endpoint');
    input.type = 'hidden';
    input.id = `${nameInput}_${span.id}`;
    input.name = `${nameInput}[]`;
    input.value = letter !== null ? `${span.id}_${letter}` : span.id;
    return input;
};
const createSpan = (name, letter) => {
    const span = document.createElement('span');
    span.className = `word-letter btn fs-2 ${name}`;
    span.id = document.getElementsByClassName(name).length;
    span.innerText = letter;
    return span;
};
const deletePosition = (span, nameInput) => {
    const hiddenInputs = document.getElementsByClassName('input-endpoint');
    for (let i = 0; i < hiddenInputs.length; i++) {
        if (hiddenInputs[i].id === nameInput) {
            span.classList.remove('text-danger');
            span.classList.remove('fs-1');
            span.classList.add('fs-2');
            hiddenInputs[i].remove();
        }
    }
};
const getLetterPosition = (word, letter, position) => {
    const letters = [];
    const wordLetters = word.split('');
    const newWordLetters = [];
    for (let i = 0; i < wordLetters.length; i++) {
        let lettre = '';
        if (wordLetters[i] === 'à' || wordLetters[i] === 'â') {
            lettre = 'a';
        } else if (wordLetters[i] === 'é' || wordLetters[i] === 'è' || wordLetters[i] === 'ë' || wordLetters[i] === 'ê') {
            lettre = 'e';
        } else if (wordLetters[i] === 'î' || wordLetters[i] === 'ï') {
            lettre = 'i';
        } else {
            lettre = wordLetters[i];
        }
        newWordLetters.push(lettre);
    }
    for (let i = 0; i < word.length; i++) {
        if (newWordLetters[i] === letter) {
            letters.push(i);
        }
    }
    return letters[position - 1];
};

export { addPosition, createSpan, deletePosition, getLetterPosition };
