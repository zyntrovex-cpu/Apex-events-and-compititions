/* APEX — shared JS: nav toggle, scroll reveal, form helpers */
(function () {
  'use strict';

  /* Mobile nav */
  const toggle = document.querySelector('[data-menu-toggle]');
  const nav = document.querySelector('[data-nav]');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.getAttribute('data-open') === 'true';
      nav.setAttribute('data-open', String(!open));
      toggle.setAttribute('aria-expanded', String(!open));
    });
  }

  /* Reveal on scroll */
  const items = document.querySelectorAll('.reveal');
  if (items.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((en) => {
        if (en.isIntersecting) {
          en.target.classList.add('on');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.12 });
    items.forEach((el) => io.observe(el));
  } else {
    items.forEach((el) => el.classList.add('on'));
  }

  /* Smooth anchor */
  document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach((a) => {
    a.addEventListener('click', (e) => {
      const t = document.querySelector(a.getAttribute('href'));
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  /* Accessible form validation helper */
  document.querySelectorAll('form[data-validate]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      let firstBad = null;
      form.querySelectorAll('[data-req]').forEach((wrap) => {
        const input = wrap.querySelector('input,select,textarea');
        if (!input) return;
        const v = (input.value || '').trim();
        const bad = !v || (input.type === 'tel' && v.replace(/[^0-9]/g, '').length < 10);
        wrap.classList.toggle('invalid', bad);
        if (bad && !firstBad) firstBad = input;
      });
      const em = form.querySelector('[data-email]');
      if (em) {
        const emIn = em.querySelector('input');
        const bad = emIn.value.trim() !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emIn.value.trim());
        em.classList.toggle('invalid', bad);
        if (bad && !firstBad) firstBad = emIn;
      }
      const chip = form.querySelector('[data-chips-required]');
      if (chip && !chip.querySelector('input:checked')) {
        chip.classList.add('invalid');
        if (!firstBad) firstBad = chip.querySelector('input');
      }
      const consent = form.querySelector('[data-consent]');
      if (consent) {
        const c = consent.querySelector('input');
        if (!c.checked) {
          consent.classList.add('invalid');
          if (!firstBad) firstBad = c;
        }
      }
      if (firstBad) { e.preventDefault(); firstBad.focus(); }
    });
    form.querySelectorAll('input,select,textarea').forEach((el) => {
      el.addEventListener('input', () => {
        const w = el.closest('.invalid'); if (w) w.classList.remove('invalid');
      });
      el.addEventListener('change', () => {
        const w = el.closest('.invalid'); if (w) w.classList.remove('invalid');
      });
    });
  });

  /* Chip visual state (fallback for :has(input:checked) on older browsers) */
  document.querySelectorAll('.form .chip').forEach((chip) => {
    const cb = chip.querySelector('input[type="checkbox"],input[type="radio"]');
    if (!cb) return;
    const sync = () => chip.classList.toggle('is-checked', cb.checked);
    cb.addEventListener('change', sync);
    sync();
  });

  /* Count-up stat animation */
  document.querySelectorAll('[data-count]').forEach((el) => {
    const end = parseInt(el.dataset.count, 10);
    if (!Number.isFinite(end)) return;
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
    let started = false;
    const io = new IntersectionObserver((entries) => {
      entries.forEach((en) => {
        if (en.isIntersecting && !started) {
          started = true;
          const dur = 1200, start = performance.now();
          function step(ts) {
            const p = Math.min(1, (ts - start) / dur);
            const val = Math.round(p * end);
            el.textContent = prefix + val.toLocaleString() + suffix;
            if (p < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
          io.disconnect();
        }
      });
    });
    io.observe(el);
  });
})();
