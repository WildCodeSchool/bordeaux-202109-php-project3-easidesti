const divEndpoint = document.getElementById('endpoint');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const letters = document.getElementsByClassName('word-letter');

wordInput.addEventListener('keyup', (event) => {
    if (wordInput.value === '') {
        divEndpoint.innerHTML = '';
    }
    if (alphabet.includes(event.key)) {
        const span = document.createElement('span');
        span.classList.add('word-letter');
        span.innerText = event.key;
        divEndpoint.appendChild(span);
    }
    if (event.key === 'Backspace' && letters.length > 0) {
        divEndpoint.lastChild.remove();
    }
});
