// search.js
document.addEventListener('DOMContentLoaded', () => {
  const form  = document.querySelector('form.d-flex');
  const input = form.querySelector('input[type="search"]');

  form.addEventListener('submit', e => {
    e.preventDefault();
    const term = input.value.trim().toLowerCase();
    if (!term) return;

    // adjust the selectors to whatever you want searchable
    const elems = Array.from(
      document.querySelectorAll('h1, h2, h3, p, li')
    );

    const match = elems.find(el =>
      el.textContent.toLowerCase().includes(term)
    );

    if (match) {
      match.scrollIntoView({ behavior: 'smooth', block: 'start' });

      match.classList.add('search-highlight');
      setTimeout(() => match.classList.remove('search-highlight'), 2000);
    } else {
      alert(`No result for “${term}” on this page.`);
      // or: window.location.href = '/search?query=' + encodeURIComponent(term);
    }
  });
});
