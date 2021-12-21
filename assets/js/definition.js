const wordInput = document.getElementById('word_content');
const definition = document.getElementById('word_definition');

wordInput.addEventListener('keyup', (event) => {
    fetch(`/word/definition/${wordInput.value}`)
        .then((response) => response.json())
        .then((data) => {
            definition.innerHTML = data;
        });
});
