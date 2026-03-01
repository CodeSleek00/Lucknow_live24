(function () {
  var menuToggle = document.getElementById('menuToggle');
  var menuClose = document.getElementById('menuClose');
  var mobileNav = document.getElementById('mobileNav');
  var drawerBackdrop = document.getElementById('drawerBackdrop');

  function openDrawer() {
    if (!mobileNav) return;
    mobileNav.classList.add('open');
    mobileNav.setAttribute('aria-hidden', 'false');
    if (drawerBackdrop) drawerBackdrop.classList.add('show');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
  }

  function closeDrawer() {
    if (!mobileNav) return;
    mobileNav.classList.remove('open');
    mobileNav.setAttribute('aria-hidden', 'true');
    if (drawerBackdrop) drawerBackdrop.classList.remove('show');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
  }

  if (menuToggle) menuToggle.addEventListener('click', openDrawer);
  if (menuClose) menuClose.addEventListener('click', closeDrawer);
  if (drawerBackdrop) drawerBackdrop.addEventListener('click', closeDrawer);

  var heroSlides = document.querySelectorAll('.hero-slide');
  var heroDots = document.querySelectorAll('.hero-dot');
  var index = 0;

  function setSlide(next) {
    heroSlides.forEach(function (slide, i) {
      slide.classList.toggle('active', i === next);
    });
    heroDots.forEach(function (dot, i) {
      dot.classList.toggle('active', i === next);
    });
    index = next;
  }

  if (heroSlides.length > 1) {
    setInterval(function () {
      var next = (index + 1) % heroSlides.length;
      setSlide(next);
    }, 4200);
  }

  heroDots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      var target = Number(dot.getAttribute('data-slide'));
      if (!Number.isNaN(target)) setSlide(target);
    });
  });
})();
