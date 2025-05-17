document.querySelectorAll('.post__text').forEach(textElement => {
    const container = textElement.closest('.post__text-container');
    const moreButton = container.querySelector('.post__more');
    if (textElement.scrollHeight > textElement.clientHeight) {
        moreButton.style.display = 'inline';
        textElement.dataset.fullText = textElement.textContent;
        moreButton.addEventListener('click', x => {
            if (textElement.classList.contains('post__text--expanded')) {
                textElement.classList.remove('post__text--expanded');
                moreButton.textContent = 'ещё';
            } else {
                textElement.classList.add('post__text--expanded');
                moreButton.textContent = 'свернуть';
            }
        });
    }
});
//todo сделать через ивент загрузку все класы в константу
