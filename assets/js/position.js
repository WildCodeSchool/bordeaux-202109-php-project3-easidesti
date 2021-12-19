const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZàâéèêëîïôùûü'.split('');
const blockHidden = document.getElementById('block-hidden');
const emptyWorld = document.getElementById('empty-word');
const addPosition = (span, nameInput) => {
    span.className = 'word-letter fs-1 text-danger btn text-danger';
    const input = document.createElement('input');
    input.classList.add('input-endpoint');
    input.type = 'hidden';
    input.name = `${nameInput}[]`;
    input.value = span.id;
    blockHidden.appendChild(input);
};
const createSpan = (parent, event, name) => {
    const span = document.createElement('span');
    span.className = 'word-letter btn fs-2 ' + name;
    span.id = document.getElementsByClassName(name).length;
    span.innerText = event.key;
    span.innerText = event.key;
    return span;
};
wordInput.addEventListener('keyup', (event) => {
    console.log('ok')
    if (wordInput.value === '') {
        divEndpoint.innerHTML = '';
        divMuteLetter.innerHTML = '';
    }
    if (alphabet.includes(event.key)) {
        const spanEndpoint = createSpan(divEndpoint, event, 'positions');
        const spanMuteLetter = createSpan(divMuteLetter, event, 'mute');
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
});
