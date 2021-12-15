const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
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
const createSpan = (parent, event) => {
    const span = document.createElement('span');
    span.className = 'word-letter btn fs-2';
    span.id = document.getElementsByClassName('word-letter').length;
    span.innerText = event.key;
    span.innerText = event.key;
    return span;
};
wordInput.addEventListener('keydown', (event) => {
    if (wordInput.value === '') {
        divEndpoint.innerHTML = '';
    }
    if (alphabet.includes(event.key)) {
        const spanEndpoint = createSpan(divEndpoint, event);
        const spanMuteLetter = createSpan(divMuteLetter, event);
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
