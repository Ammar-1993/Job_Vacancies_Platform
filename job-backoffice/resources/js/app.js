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

	// Make metric cards clickable (elements with class .metric-card and data-href)
	function handleMetricCardClick(e) {
		const card = e.target.closest('.metric-card[data-href]');
		if (!card) return;
		// If click originated from an interactive child (like a button/link), let it through
		if (isInteractiveElement(e.target)) return;
		const href = card.getAttribute('data-href');
		if (href) window.location.href = href;
	}

	document.body.addEventListener('click', handleMetricCardClick);

	document.body.addEventListener('keydown', function (e) {
		const key = e.key || e.keyCode;
		if (key === 'Enter' || key === ' ' || key === 13 || key === 32) {
			const el = document.activeElement;
			if (el && el.classList && el.classList.contains('metric-card') && el.hasAttribute('data-href')) {
				// Prevent scrolling on Space
				e.preventDefault();
				const href = el.getAttribute('data-href');
				if (href) window.location.href = href;
			}
		}
	});

	// Render simple SVG sparklines inside elements with data-sparkline
	function renderSparkline(container) {
		const raw = container.getAttribute('data-sparkline');
		if (!raw) return;
		let values = [];
		try {
			if (raw.trim().startsWith('[')) {
				values = JSON.parse(raw);
			} else {
				values = raw.split(',').map(function (v) { return parseFloat(v); }).filter(function (n) { return !isNaN(n); });
			}
		} catch (err) {
			return;
		}
		if (!values.length) return;

		const width = 120;
		const height = 28;
		const min = Math.min.apply(null, values);
		const max = Math.max.apply(null, values);
		const range = max - min || 1;

		const points = values.map(function (v, i) {
			const x = (i / (values.length - 1)) * width;
			const y = height - ((v - min) / range) * height;
			return x + ',' + y;
		}).join(' ');

		const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
		svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
		svg.setAttribute('width', '100%');
		svg.setAttribute('height', height);

		const poly = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
		poly.setAttribute('fill', 'none');
		poly.setAttribute('stroke', 'currentColor');
		poly.setAttribute('stroke-width', '2');
		poly.setAttribute('points', points);

		svg.appendChild(poly);
		container.innerHTML = '';
		container.appendChild(svg);
	}

	document.querySelectorAll('[data-sparkline]').forEach(function (el) {
		renderSparkline(el);
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
