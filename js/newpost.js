document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('fileInput');
    const uploadBtnMain = document.getElementById('uploadBtnMain');
    const uploadBtnSecondary = document.getElementById('uploadBtnSecondary');
    const imageUploader = document.getElementById('imageUploader');
    const imageSlider = document.getElementById('imageSlider');
    const slidesContainer = document.getElementById('slidesContainer');
    const sliderCounter = document.getElementById('sliderCounter');
    const deleteBtn = document.getElementById('deleteButton');
    const postCaption = document.getElementById('postCaption');
    const shareBtn = document.getElementById('shareBtn');
    const prevBtn = document.querySelector('.slider__button--prev');
    const nextBtn = document.querySelector('.slider__button--next');
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');
    
    let uploadedImages = []; 
    let previewImages = [];
    let currentSlideIndex = 0;

    initEvents();

    function initEvents() {
        if (postId) {
            initEditMode(postId);
            document.title = 'Редактирование поста';
            shareBtn.textContent = 'Потвердить';
        }

        uploadBtnMain.addEventListener('click', () => fileInput.click());
        uploadBtnSecondary.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', handleFileSelect);
        deleteBtn.addEventListener('click', deleteSlide);
        prevBtn.addEventListener('click', showPrevSlide);
        nextBtn.addEventListener('click', showNextSlide);
        postCaption.addEventListener('input', validateForm);
        shareBtn.addEventListener('click', submitPost);
    }

    async function initEditMode(postId) {
        try {
            const response = await fetch(`/api/get_post.php?id=${postId}`);
            const data = await response.json();
    
            if (!data.success) {
                console.log('aaaaaa')
                window.location.href = '/home.php';
                return;
            }
    
            postCaption.value = data.content;
            previewImages = data.images.map(img => `/images/${img.image_name}`);
            uploadedImages = data.images.map(img => img.image_name);
    
            updateImageDisplay();
        } catch (err) {
            console.error('Ошибка загрузки поста:', err);
            alert('Ошибка сети');
        }
    }
    

    async function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        
        try {
            const response = await fetch('/api/upload_image.php', {
                method: 'POST',
                body: formData
            });
            // console.log(response);
            
            if (!response.ok) {
                throw new Error('Upload failed');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Upload error:', error);
            return null;
        }
    }

    async function handleFileSelect(event) {
        const files = event.target.files;
        if (files.length === 0) return;

        for (const file of files) {
            if (!file.type.match('image.*')) continue;
            const previewUrl = URL.createObjectURL(file);
            previewImages.push(previewUrl);
            const uploadResult = await uploadImage(file);
            console.log(uploadResult);

            if (uploadResult && uploadResult.success) {
                uploadedImages.push(uploadResult.image_name);
            } else {
                previewImages = previewImages.filter(img => img !== previewUrl);
                URL.revokeObjectURL(previewUrl);
            }
        }
        
        updateImageDisplay();
        fileInput.value = '';
    }

    async function submitPost() {
        if (uploadedImages.length === 0 || !postCaption.value.trim()) return;
    
        const payload = {
            content: postCaption.value,
            images: uploadedImages
        };
    
        const url = postId ? `/api/update_post.php?id=${postId}` : '/api/create_post.php';
    
        // try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });
    
            const result = await response.json();
            if (result.success) {
                alert(postId ? 'Пост обновлён' : 'Пост создан');
                resetForm();
                location.href = '/home.php';
            } else {
                alert('Ошибка: ' + (result.error || 'Неизвестная ошибка'));
            }
        // } catch (err) {
        //     console.error('Ошибка при сохранении поста:', err);
        //     alert('Ошибка сети');
        // }
    }
    

    function resetForm() {
        uploadedImages = [];
        previewImages = [];
        postCaption.value = '';
        currentSlideIndex = 0;
        previewImages.forEach(url => URL.revokeObjectURL(url));
        updateImageDisplay();
    }

    function deleteSlide() {
        previewImages.splice(currentSlideIndex, 1);
        uploadedImages.splice(currentSlideIndex, 1);
        if (currentSlideIndex >= previewImages.length && previewImages.length > 0) {
            currentSlideIndex = previewImages.length - 1;
        }
        updateImageDisplay();
    }

    function updateImageDisplay() {
        if (previewImages.length > 0) {
            imageUploader.style.display = 'none';
            imageSlider.style.display = 'block';
            if (previewImages.length > 1){
                sliderCounter.style.display = 'flex';
                deleteBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
                prevBtn.style.display = 'flex';

            } else {
                sliderCounter.style.display = 'none';
                nextBtn.style.display = 'none';
                prevBtn.style.display = 'none';
            }
            slidesContainer.innerHTML = '';
            previewImages.forEach((image, index) => {
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
        if (previewImages.length <= 1) return;
        
        const slides = document.querySelectorAll('.slide');
        slides[currentSlideIndex].style.display = 'none';
        
        currentSlideIndex = (currentSlideIndex - 1 + previewImages.length) % previewImages.length;
        slides[currentSlideIndex].style.display = 'block';
        
        updateCounter();
    }

    function showNextSlide() {
        if (previewImages.length <= 1) return;
        
        const slides = document.querySelectorAll('.slide');
        slides[currentSlideIndex].style.display = 'none';
        
        currentSlideIndex = (currentSlideIndex + 1) % previewImages.length;
        slides[currentSlideIndex].style.display = 'block';
        
        updateCounter();
    }

    function updateCounter() {  
        sliderCounter.textContent = `${currentSlideIndex + 1}/${previewImages.length}`;
    }

    function validateForm() {
        shareBtn.disabled = !(previewImages.length > 0 && postCaption.value.trim() !== '');
        
        if (shareBtn.disabled) {
            shareBtn.style.background = 'rgba(180, 180, 180, 1)';
        } else {
            shareBtn.style.background = 'rgba(34, 34, 34, 1)';
        }
    }
});
//константы