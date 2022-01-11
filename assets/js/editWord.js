import { addPosition, createSpan, deletePosition } from './functions';

const blockHidden = document.getElementById('block-hidden');
const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const blockDefinition = document.getElementById('word_definition');
const emptyWorld = document.getElementById('empty-word');

if (blockHidden.dataset.edit) {
    window.addEventListener('load', () => {
        const wordArray = wordInput.value.split('');
        for (let i = 0; i < wordArray.length; i++) {
            const spanEndpoint = createSpan(divEndpoint, 'positions', wordArray[i]);
            const spanMuteLetter = createSpan(divMuteLetter, 'mute', wordArray[i]);
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
        const allEndpoints = document.querySelectorAll('.positions');
        for (let i = 0; i < endpoints.length; i++) {
            const endpoint = addPosition(allEndpoints[endpoints[i]], 'clickedLetters');
            blockHidden.appendChild(endpoint);
        }
        allEndpoints.forEach((endpoint) => {
            endpoint.addEventListener('click', () => {
                if (document.getElementById(`clickedLetters_${endpoint.id}`)) {
                    deletePosition(endpoint, `clickedLetters_${endpoint.id}`);
                } else {
                    const input = addPosition(endpoint, 'clickedLetters');
                    blockHidden.appendChild(input);
                }
            });
        });
        const allMuteLetters = document.querySelectorAll('.mute');
        allMuteLetters.forEach((muteLetter) => {
            muteLetter.addEventListener('click', () => {
                if (document.getElementById(`clickedMuteLetters_${muteLetter.id}`)) {
                    deletePosition(muteLetter, `clickedMuteLetters_${muteLetter.id}`);
                } else {
                    const input = addPosition(muteLetter, 'clickedMuteLetters');
                    blockHidden.appendChild(input);
                }
            });
        });
    });
}
emptyWorld.addEventListener('click', () => {
    blockSyllabe.classList.add('d-none');
    blockMuteLetter.classList.add('d-none');
    wordInput.value = '';
    divEndpoint.innerHTML = '';
    divMuteLetter.innerHTML = '';
    blockHidden.innerHTML = '';
    blockDefinition.innerHTML = '';
});
