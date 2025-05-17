const modal = document.getElementById('imageModal');
const modalClose = document.querySelector('.modal__close');
const modalSlidesContainer = document.querySelector('.modal-slides__container');
const modalCounter = document.querySelector('.modal__counter');
const modalPrev = document.querySelector('.modal__button--prev');
const modalNext = document.querySelector('.modal__button--next');
const allPosts = document.querySelectorAll('.post')
let currentModalSlide = 0;
let modalSlides = [];
let totalModalSlides = 0;
// позицирование добавить + оптимизация 
for (let post of allPosts) {
    const postImages = post.querySelectorAll('.post__media-img')
    for (let postImage of postImages){
        postImage.addEventListener('click', function() {
            const images = post.querySelectorAll('.post__media-img');
            totalModalSlides = images.length;

            modalSlidesContainer.innerHTML = '';
            modalSlides = [];

            for (let index = 0; index < images.length; index++) {
                const img = images[index];
                const slide = document.createElement('img');
                slide.src = img.src;
                slide.className = 'modal-slide';
                slide.style.display = index === 0 ? 'flex' : 'none';
                modalSlidesContainer.appendChild(slide);
                modalSlides.push(slide);
            }
            updateCounter();

            document.addEventListener('keydown', handleKeydown);
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }
};

modalClose.addEventListener('click', function() {
    closeModal();
});

modalPrev.addEventListener('click', showPrevModalSlide);
modalNext.addEventListener('click', showNextModalSlide);

modal.addEventListener('click', function(e) {
    if (e.target == modal) {
        closeModal();
    }
});

function handleKeydown(e){
    if (e.key == 'Escape'){
        closeModal();
        console.log('esc');
    } else if (e.key == 'ArrowLeft'){
        showPrevModalSlide();
        console.log('<-');
    } else if (e.key == 'ArrowRight'){
        showNextModalSlide();
        console.log('->');
    };
}

function closeModal(){
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    document.removeEventListener('keydown', handleKeydown);
}

function showPrevModalSlide() {
    currentModalSlide = (currentModalSlide + 1) % totalModalSlides;
    updateSlider();
}


function showNextModalSlide() {
    currentModalSlide = (currentModalSlide - 1 + totalModalSlides) % totalModalSlides;
    updateSlider();
}

function updateSlider() {
    modalSlides.forEach((slide, index) => {
        slide.style.display = index === currentModalSlide ? 'flex' : 'none';
    });
    updateCounter();
}

function updateCounter() {
    console.log(`${currentModalSlide + 1}/${totalModalSlides}`);
    if (modalCounter) {
        modalCounter.textContent = `${currentModalSlide + 1} из ${totalModalSlides}`;
    }
}