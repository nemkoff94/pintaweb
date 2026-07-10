document.addEventListener('DOMContentLoaded', function () {
  const wrap = document.querySelector('.slider-wrap');
  if (!wrap) return;

  const slider = wrap.querySelector('.taps-slider');
  const prev = wrap.querySelector('.slider-btn.prev');
  const next = wrap.querySelector('.slider-btn.next');

  const scrollByAmount = () => {
    if (!slider) return 300;
    const visible = window.innerWidth > 980 ? 4 : 1;
    const item = slider.querySelector('.slider-item');
    if (!item) return Math.round(slider.clientWidth * 0.6);
    const w = item.getBoundingClientRect().width;
    return Math.round(w * visible + 16 * (visible - 1));
  };

  if (prev) prev.addEventListener('click', () => {
    slider.scrollBy({ left: -scrollByAmount(), behavior: 'smooth' });
  });
  if (next) next.addEventListener('click', () => {
    slider.scrollBy({ left: scrollByAmount(), behavior: 'smooth' });
  });

  // Optional: show/hide arrows based on overflow
  const updateArrows = () => {
    if (!slider) return;
    if (slider.scrollWidth <= slider.clientWidth) {
      prev.style.display = 'none'; next.style.display = 'none';
    } else {
      prev.style.display = ''; next.style.display = '';
    }
  };

  updateArrows();
  window.addEventListener('resize', updateArrows);
});
