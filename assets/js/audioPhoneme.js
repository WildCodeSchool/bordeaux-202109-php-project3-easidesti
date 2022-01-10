const audioPhoneme = document.getElementsByClassName('sound-propositions');
const audios = document.getElementsByClassName('audios')
for (let i=0; i<audioPhoneme.length; i++)  {
    audioPhoneme[i].addEventListener('click', (e) => {
        audios[i].play()
    })
};


