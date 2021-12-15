const divEndpoint = document.getElementById('endpoint');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const blockHidden = document.getElementById('block-hidden');
const emptyWorld = document.getElementById('empty-word');
const addEndpoint = (span) => {
    span.className = 'word-letter fs-1 text-danger btn text-danger';
    const input = document.createElement('input');
    input.classList.add('input-endpoint');
    input.type = 'hidden';
    input.name = 'clickedLetters[]';
    input.value = span.id;
    blockHidden.appendChild(input);
};
wordInput.addEventListener('keydown', (event) => {
    if (wordInput.value === '') {
        divEndpoint.innerHTML = '';
    }
    if (alphabet.includes(event.key)) {
        const span = document.createElement('span');
        span.className = 'word-letter btn fs-2';
        span.id = document.getElementsByClassName('word-letter').length;
        span.innerText = event.key;
        divEndpoint.appendChild(span);
        span.addEventListener('click', () => addEndpoint(span));
    }
    if (event.key === 'Backspace' || event.key === 'ArrowLeft') {
        event.preventDefault();
    }
});
emptyWorld.addEventListener('click', () => {
    wordInput.value = '';
    divEndpoint.innerHTML = '';
});
