
const fileInput = document.getElementById('fileInput');
const uploadBtnMain = document.getElementById('uploadBtnMain');
const uploadBtnSecondary = document.getElementById('uploadBtnSecondary');
const imageUploader = document.getElementById('imageUploader');
const imageSlider = document.getElementById('imageSlider');
const slidesContainer = document.getElementById('slidesContainer');
const sliderCounter = document.getElementById('sliderCounter');
const slidersContainer = document.querySelector('slider__controls');
const postCaption = document.getElementById('postCaption');
const shareBtn = document.getElementById('shareBtn');
const prevBtn = document.querySelector('.slider__button--prev');
const nextBtn = document.querySelector('.slider__button--next');

let images = [];
let currentSlideIndex = 0;

uploadBtnMain.addEventListener('click', x => fileInput.click());
uploadBtnSecondary.addEventListener('click', x => fileInput.click());
fileInput.addEventListener('change', handleFileSelect);
prevBtn.addEventListener('click', showPrevSlide);
nextBtn.addEventListener('click', showNextSlide);
postCaption.addEventListener('input', validateForm);

function handleFileSelect(event) {
    const files = event.target.files;
    if (files.length === 0) return;
    
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        if (!file.type.match('image.*')) continue;
        
        const reader = new FileReader();
        reader.onload = image => {
            images.push(image.target.result);
            updateImageDisplay();
        };
        reader.readAsDataURL(file);
    }
    
    fileInput.value = '';
}

function updateImageDisplay() {
    if (images.length > 0) {
        imageUploader.style.display = 'none';
        imageSlider.style.display = 'block';
        if (images.length > 1){
            sliderCounter.style.display = 'flex';
            nextBtn.style.display = 'flex';
            prevBtn.style.display = 'flex';

        } else {
            sliderCounter.style.display = 'none';
            nextBtn.style.display = 'none';
            prevBtn.style.display = 'none';
        }
        slidesContainer.innerHTML = '';
        images.forEach((image, index) => {
            const slide = document.createElement('div');
            slide.className = 'slide';
            slide.style.display = index == currentSlideIndex? 'block' : 'none';
            const img = document.createElement('img');
            img.src = image;
            img.className = 'slide-image';
            slide.appendChild(img);
            slidesContainer.appendChild(slide);
        });
        updateCounter();
    } else {
        imageUploader.style.display = 'flex';
        imageSlider.style.display = 'none';
        uploadBtnSecondary.style.display = 'flex';
    }
    validateForm();
}

function showPrevSlide() {
    if (images.length <= 1) return;
    
    const slides = document.querySelectorAll('.slide');
    slides[currentSlideIndex].style.display = 'none';
    
    currentSlideIndex = (currentSlideIndex - 1 + images.length) % images.length;
    slides[currentSlideIndex].style.display = 'block';
    
    updateCounter();
}

function showNextSlide() {
    if (images.length <= 1) return;
    
    const slides = document.querySelectorAll('.slide');
    slides[currentSlideIndex].style.display = 'none';
    
    currentSlideIndex = (currentSlideIndex + 1) % images.length;
    slides[currentSlideIndex].style.display = 'block';
    
    updateCounter();
}

function updateCounter() {
    sliderCounter.textContent = `${currentSlideIndex + 1}/${images.length}`;
}

function validateForm() {
    shareBtn.disabled = !(images.length > 0 && postCaption.value.trim() !== '');
    
    if (shareBtn.disabled) {
        shareBtn.style.background = 'rgba(180, 180, 180, 1)';
    } else {
        shareBtn.style.background = 'rgba(34, 34, 34, 1)';
    }
}

shareBtn.addEventListener('click', x => {
    console.log('New post data:', {images: images, caption: postCaption.value.trim()});
});

//константы