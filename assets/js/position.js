const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZàâéèêëîïôùûü'.split('');
const blockHidden = document.getElementById('block-hidden');
const emptyWorld = document.getElementById('empty-word');
const blockDefinition = document.getElementById('word_definition');
const addPosition = (span, nameInput) => {
    span.className = 'word-letter fs-1 text-danger btn text-danger positions';
    const input = document.createElement('input');
    input.classList.add('input-endpoint');
    input.type = 'hidden';
    input.name = `${nameInput}[]`;
    input.value = span.id;
    blockHidden.appendChild(input);
};
const createSpan = (parent, name, letter) => {
    const span = document.createElement('span');
    span.className = `word-letter btn fs-2 ${name}`;
    span.id = document.getElementsByClassName(name).length;
    span.innerText = letter;
    span.innerText = letter;
    return span;
};
wordInput.addEventListener('keyup', (event) => {
    if (wordInput.value === '') {
        divEndpoint.innerHTML = '';
        divMuteLetter.innerHTML = '';
    }
    if (alphabet.includes(event.key)) {
        const spanEndpoint = createSpan(divEndpoint, 'positions', event.key);
        const spanMuteLetter = createSpan(divMuteLetter, 'mute', event.key);
        divEndpoint.appendChild(spanEndpoint);
        divMuteLetter.appendChild(spanMuteLetter);
        spanEndpoint.addEventListener('click', () => addPosition(spanEndpoint, 'clickedLetters'));
        spanMuteLetter.addEventListener('click', () => addPosition(spanMuteLetter, 'clickedMuteLetters'));
    }
});
emptyWorld.addEventListener('click', () => {
    wordInput.value = '';
    divEndpoint.innerHTML = '';
    divMuteLetter.innerHTML = '';
    blockHidden.innerHTML = '';
    blockDefinition.innerHTML = '';
});
window.addEventListener('load', () => {
    if (blockHidden.dataset.edit) {
        const wordArray = wordInput.value.split('');
        for (let i = 0; i < wordArray.length; i++) {
            let spanEndpoint = createSpan(divEndpoint, 'positions', wordArray[i]);
            let spanMuteLetter = createSpan(divMuteLetter, 'mute', wordArray[i]);
            divEndpoint.appendChild(spanEndpoint);
            divMuteLetter.appendChild(spanMuteLetter);
            spanEndpoint.addEventListener('click', () => addPosition(spanEndpoint, 'clickedLetters'));
            spanMuteLetter.addEventListener('click', () => addPosition(spanMuteLetter, 'clickedMuteLetters'));
            fetch(`/word/definition/${wordInput.value}`)
                .then((response) => response.json())
                .then((data) => {
                    blockDefinition.innerHTML = data;
                });
        }
        const endpoints = blockHidden.dataset.endpoints.split(',');
        const allEndpoints = document.getElementsByClassName('positions');
        for (let i = 0; i < endpoints.length; i++) {
            console.log(allEndpoints.length)
            addPosition(allEndpoints[endpoints[i]], 'clickedLetters')
        }
    }
})
