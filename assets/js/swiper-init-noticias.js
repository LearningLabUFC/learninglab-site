
document.addEventListener('DOMContentLoaded', () => {
  const swiper = new Swiper('.leitura-swiper', {
      loop: true,
      autoplay: {
          delay: 5000,
          disableOnInteraction: false,
      },
      slidesPerView: 1, // Sempre exibir 1 slide por vez
      spaceBetween: 30,
      breakpoints: {
          768: {
              slidesPerView: 2, // 2 slides por vez em tablets
          },
          1024: {
              slidesPerView: 3, // 3 slides por vez em desktops
          },
      },
      navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
      },
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
      },
  });
});