if (document.getElementById('help-listen')) {
    const buttonHelpListen = document.getElementById('help-listen');
    const audioHelp = document.getElementById('audio-help');
    buttonHelpListen.addEventListener('click', (event) => {
        audioHelp.play();
    });
}
