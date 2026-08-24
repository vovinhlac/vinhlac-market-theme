(() => {
  'use strict';

  const toggles = document.querySelectorAll('[data-lacvo-menu-toggle]');

  toggles.forEach((toggle) => {
    const targetId = toggle.getAttribute('aria-controls');
    const panel = targetId ? document.getElementById(targetId) : null;

    if (!panel) {
      return;
    }

    const setOpen = (open) => {
      toggle.setAttribute('aria-expanded', String(open));
      panel.hidden = !open;
    };

    setOpen(toggle.getAttribute('aria-expanded') === 'true');

    toggle.addEventListener('click', () => {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
        setOpen(false);
        toggle.focus();
      }
    });
  });
})();
