
const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById('closeBtn');
const mobileMenu = document.getElementById('mobileMenu');
const overlay = document.getElementById('overlay');

menuBtn.addEventListener('click', () => {
    mobileMenu.classList.add('active');
    overlay.classList.add('active');
});

closeBtn.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
    overlay.classList.remove('active');
});

overlay.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
    overlay.classList.remove('active');
});
let slides = document.querySelectorAll('.mobile-slide');
let index = 0;

function showSlide(i){
    slides.forEach(s => s.classList.remove('active'));
    slides[i].classList.add('active');
}

if(slides.length > 0){
    showSlide(index);

    setInterval(() => {
        index = (index + 1) % slides.length;
        showSlide(index);
    }, 8000); // 8 seconds
}
const reels = document.querySelectorAll('.news-reel .reel-box');

reels.forEach(box => {
    const video = box.querySelector('video');

    box.addEventListener('click', () => {

        // stop other videos
        reels.forEach(b => {
            const v = b.querySelector('video');
            if (v !== video) {
                v.pause();
                b.classList.remove('playing');
            }
        });

        // toggle play/pause
        if (video.paused) {
            video.play();
            box.classList.add('playing');
        } else {
            video.pause();
            box.classList.remove('playing');
        }

    });
});