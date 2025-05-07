const sliders = document.querySelectorAll('.slider');

for (let slider of sliders) {
    const slides = slider.querySelectorAll('.slide');
    const totalSlides = slides.length;
    const prevButton = slider.querySelector('.slider__button--prev');
    const nextButton = slider.querySelector('.slider__button--next');
    const counter = slider.querySelector('.slider__counter')
    let currentSlide = 0;

    slides[0].style.display = 'block';
    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.style.display = index == currentSlide ? 'block' : 'none';
        });
        console.log(`${currentSlide + 1}/${totalSlides}`);
        if (counter) {
            counter.textContent = `${currentSlide + 1}/${totalSlides}`;
        }

    }

    prevButton.addEventListener('click', showPrevSlide);
    nextButton.addEventListener('click', showNextSlide);

    function showNextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function showPrevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    updateSlider();
};