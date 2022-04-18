import { addPosition, createSpan, deletePosition, getLetterPosition } from './functions';

const defaultDefinition = 'À définir';
const blockHidden = document.getElementById('block-hidden');
const divLetter = document.getElementById('study-letter');
const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const blockDefinition = document.getElementById('word_definition');
const url = blockHidden.dataset.url;
window.addEventListener('load', () => {
    const wordArray = wordInput.value.split('');
    for (let i = 0; i < wordArray.length; i++) {
        const spanLetter = createSpan('study-letter', wordArray[i]);
        const spanEndpoint = createSpan('positions', wordArray[i]);
        const spanMuteLetter = createSpan('mute', wordArray[i]);
        divLetter.appendChild(spanLetter);
        divEndpoint.appendChild(spanEndpoint);
        divMuteLetter.appendChild(spanMuteLetter);
        spanEndpoint.addEventListener('click', () => addPosition(spanEndpoint, 'clickedLetters'));
        spanMuteLetter.addEventListener('click', () => addPosition(spanMuteLetter, 'clickedMuteLetters'));
        if (blockDefinition.value === defaultDefinition) {
            fetch(`${url}`)
                .then((response) => response.json())
                .then((data) => {
                    blockDefinition.innerHTML = data;
                });
        }
    }
    const studyLetter = blockHidden.dataset.letter;
    const positionLetter = blockHidden.dataset.position;
    const position = getLetterPosition(wordInput.value, studyLetter, positionLetter);
    const allLetters = document.querySelectorAll('.study-letter');

    if (blockHidden.dataset.letter !== '' && position !== undefined) {
        const letterStudy = addPosition(allLetters[position], 'clickedLetterStudy', 'study-letter-selected');
        blockHidden.appendChild(letterStudy);
    }
    allLetters.forEach((letter) => {
        letter.addEventListener('click', () => {
            if (document.getElementById(`clickedLetterStudy_${letter.id}`)) {
                deletePosition(letter, `clickedLetterStudy_${letter.id}`);
            } else {
                const input = addPosition(letter, 'clickedLetterStudy', 'study-letter-selected', letter.innerText);
                blockHidden.appendChild(input);
            }
        });
    });
    const allEndpoints = document.querySelectorAll('.positions');
    if (!blockHidden.dataset.endpoints == '') {
        const endpoints = blockHidden.dataset.endpoints.split(',');
        for (let i = 0; i < endpoints.length; i ++) {
            if (allEndpoints[endpoints[i]]) {
                const endpoint = addPosition(allEndpoints[endpoints[i]], 'clickedLetters', 'endpoint-selected');
                blockHidden.appendChild(endpoint);
            }
        }
    }
    allEndpoints.forEach((endpoint) => {
        endpoint.addEventListener('click', () => {
            if (document.getElementById(`clickedLetters_${endpoint.id}`)) {
                deletePosition(endpoint, `clickedLetters_${endpoint.id}`);
            } else {
                const input = addPosition(endpoint, 'clickedLetters', 'endpoint-selected');
                blockHidden.appendChild(input);
            }
        });
    });

    const allMuteLetters = document.querySelectorAll('.mute');
    if (!blockHidden.dataset.muteletters == '') {
        const muteLetters = blockHidden.dataset.muteletters.split(',');
        for (let i = 0; i < muteLetters.length; i++) {
            const muteLetter = addPosition(allMuteLetters[muteLetters[i]], 'clickedMuteLetters', 'mute-selected');
            blockHidden.appendChild(muteLetter);
        }
    }
    allMuteLetters.forEach((muteLetter) => {
        muteLetter.addEventListener('click', () => {
            if (document.getElementById(`clickedMuteLetters_${muteLetter.id}`)) {
                deletePosition(muteLetter, `clickedMuteLetters_${muteLetter.id}`);
            } else {
                const input = addPosition(muteLetter, 'clickedMuteLetters', 'mute-selected');
                blockHidden.appendChild(input);
            }
        });
    });
});
