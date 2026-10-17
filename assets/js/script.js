(() => {
  const root = document.documentElement;
  const themeButton = document.getElementById('themeToggle');
  const storedTheme = (() => { try { return localStorage.getItem('portfolio-theme'); } catch (_) { return null; } })();
  if (storedTheme === 'dark') root.dataset.theme = 'dark';
  const paintThemeButton = () => { if (!themeButton) return; const dark = root.dataset.theme === 'dark'; themeButton.innerHTML = `<span class="theme-icon" aria-hidden="true">${dark ? '☀' : '☾'}</span>`; themeButton.setAttribute('aria-label', dark ? 'Switch to light theme' : 'Switch to dark theme'); };
  paintThemeButton();
  themeButton?.addEventListener('click', () => { root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark'; try { localStorage.setItem('portfolio-theme', root.dataset.theme); } catch (_) {} paintThemeButton(); });
  const toggle = document.getElementById('menuToggle'); const nav = document.getElementById('navLinks');
  toggle?.addEventListener('click', () => { const open = toggle.getAttribute('aria-expanded') !== 'true'; toggle.setAttribute('aria-expanded', String(open)); toggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu'); nav?.classList.toggle('is-open', open); });
  nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { nav.classList.remove('is-open'); toggle?.setAttribute('aria-expanded', 'false'); }));
  const copy = document.getElementById('copyEmail'); const feedback = document.getElementById('copyFeedback');
  copy?.addEventListener('click', async () => { const email = copy.dataset.email; try { await navigator.clipboard.writeText(email); feedback.textContent = 'Email copied to clipboard.'; } catch (_) { feedback.textContent = `Copy failed. Email: ${email}`; } });
  const topButton = document.getElementById('backToTop'); const updateTop = () => topButton?.classList.toggle('visible', window.scrollY > 500); window.addEventListener('scroll', updateTop, { passive: true }); updateTop(); topButton?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' }));
  document.querySelectorAll('a[href^="#"]').forEach(anchor => anchor.addEventListener('click', event => { const target = document.querySelector(anchor.getAttribute('href')); if (target) { event.preventDefault(); target.scrollIntoView({ behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'start' }); history.replaceState(null, '', anchor.getAttribute('href')); } }));
  const params = new URLSearchParams(location.search); const status = params.get('contact');
  if (status === 'sent') { const target = document.getElementById('contact'); if(target) { const msg=document.createElement('p'); msg.className='notice success'; msg.textContent='Thanks! Your message has been recorded.'; target.querySelector('.contact-grid')?.prepend(msg); } }
  if (status === 'error') { const target = document.getElementById('contact'); if(target) { const msg=document.createElement('p'); msg.className='notice error'; msg.textContent='Please check your form details and try again.'; target.querySelector('.contact-grid')?.prepend(msg); } }
})();
