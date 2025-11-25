import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Make table rows with a `data-href` attribute clickable and keyboard-accessible.
document.addEventListener('DOMContentLoaded', function () {
	function isInteractiveElement(el) {
		return el.closest('a, button, input, textarea, select, label, form');
	}

	document.body.addEventListener('click', function (e) {
		const row = e.target.closest('tr[data-href]');
		if (!row) return;
		// If click originated from an interactive child, let it handle the event
		if (isInteractiveElement(e.target)) return;
		const href = row.getAttribute('data-href');
		if (href) window.location.href = href;
	});

	document.body.addEventListener('keydown', function (e) {
		const key = e.key || e.keyCode;
		if (key === 'Enter' || key === ' ' || key === 13 || key === 32) {
			const el = document.activeElement;
			if (el && el.tagName === 'TR' && el.hasAttribute('data-href')) {
				// Prevent scrolling on Space
				e.preventDefault();
				const href = el.getAttribute('data-href');
				if (href) window.location.href = href;
			}
		}
	});
});
