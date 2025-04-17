(() => {

  const htmlInput = document.getElementById('search');
  const htmlAutocomplete = document.getElementById('autocomplete');

  htmlInput.addEventListener('keydown', ((timeoutId) => (e) => {
    window.clearTimeout(timeoutId);
    timeoutId = window.setTimeout(() => autocomplete(e.target.value), 250);
  })(null));

  htmlInput.addEventListener('blur', () => htmlAutocomplete.classList.add('hidden'));

  const autocomplete = (search) => {
    fetch(`/autocomplete?search=${search}`)
      .then(response => response.json())
      .then(data => {
        if (data.results.length) {
          render(data.results);
        } else if (data.completions.length) {
          render(data.completions);
        } else if (data.corrections.length) {
          const [correction] = data.corrections;
          autocomplete(correction)
        }else {
          htmlAutocomplete.classList.add('hidden');
        }
      });
  }

  const render = (results) => {
    htmlAutocomplete.classList.remove('hidden');
    htmlAutocomplete.innerHTML = `
      <div class="py-1" role="none">
        ${results.map((result) => `
          <a href="/catalog?search=${result}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
            ${result}
          </a>
       `).join('')}
      </div>`;
  }

})()
