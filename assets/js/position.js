import { addPosition, deletePosition, createSpan } from './functions';

const divStudyLetter = document.getElementById('study-letter');
const divEndpoint = document.getElementById('endpoint');
const divMuteLetter = document.getElementById('mute-letter');
const wordInput = document.getElementById('word_content');
const alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZàâéèêëîïôùûü'.split('');
const blockHidden = document.getElementById('block-hidden');
const emptyWorld = document.getElementById('empty-word');
const blockDefinition = document.getElementById('word_definition');
const displayDivSyllabesMuteLetters = document.getElementById('display-div');
const blockSyllabe = document.getElementById('div-syllabe');
const blockMuteLetter = document.getElementById('div-mute-letter');
const blockLetter = document.getElementById('div-letter');
const url = blockHidden.dataset.url;
if (displayDivSyllabesMuteLetters) {
    displayDivSyllabesMuteLetters.addEventListener('click', () => {
        blockSyllabe.classList.remove('d-none');
        blockMuteLetter.classList.remove('d-none');
        blockLetter.classList.remove('d-none');
        const wordArray = wordInput.value.split('');
        for (let i = 0; i < wordArray.length; i++) {
            const spanEndpoint = createSpan('positions', wordArray[i]);
            const spanMuteLetter = createSpan('mute', wordArray[i]);
            const spanLetter = createSpan('letter', wordArray[i]);
            divEndpoint.appendChild(spanEndpoint);
            divMuteLetter.appendChild(spanMuteLetter);
            divStudyLetter.appendChild(spanLetter);
            fetch(`${url}${wordInput.value}`)
                .then((response) => response.json())
                .then((data) => {
                    blockDefinition.innerHTML = data;
                });
        }
        const letters = document.querySelectorAll('.letter');
        letters.forEach((letter) => {
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
    divMuteLetter.innerHTML = '';
    divStudyLetter.innerHTML = '';
    blockLetter.innerHTML = '';
    blockHidden.innerHTML = '';
    blockDefinition.innerHTML = '';
    blockSyllabe.classList.add('d-none');
    blockMuteLetter.classList.add('d-none');
    wordInput.value = '';
    divEndpoint.innerHTML = '';
});
