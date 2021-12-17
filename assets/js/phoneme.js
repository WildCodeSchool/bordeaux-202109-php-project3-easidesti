if (document.getElementById('phoneme-listen')) {
    const buttonPhonemeListen = document.getElementById('phoneme-listen');
    const audioPhoneme = document.getElementById('audio-phoneme');
    buttonPhonemeListen.addEventListener('click', (event) => {
        audioPhoneme.play();
    });
}
