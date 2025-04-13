(() => {

  const htmlInput = document.getElementById('search');
  const htmlAutocomplete = document.getElementById('autocomplete');

  htmlInput.addEventListener('keydown', ((timeoutId) => (e) => {
    window.clearTimeout(timeoutId);
    timeoutId = window.setTimeout(() => autocomplete(e.target.value), 250);
  })(null));

  const autocomplete = (search, refetched = false) => {
    fetch(`/products/autocomplete?search=${search}`)
      .then(response => response.json())
      .then((data) => {
        const results = filter(data.results, search);
        if (results.length) {
          htmlAutocomplete.innerHTML = render(results, search, refetched);
        } else if (data.suggest.completions.length) {
          htmlAutocomplete.innerHTML = render(data.suggest.completions, search);
        } else if (data.suggest.terms.length) {
          const [correction] = data.suggest.terms;
          autocomplete(correction, true);
        } else {
          htmlAutocomplete.classList.add("hidden");
        }
      });
  }

  const filter = (results, search) => {
    const regex = new RegExp(`\\b(${search})\\S*\\s+(.+)`, 'i');
    return results.map(item => {
      const match = item.match(regex);
      return match
        ? `${match[1]}${item.slice(match.index + match[1].length)}`.trim()
        : null;
    }).filter(Boolean);
  }

  const render = (results, search, refetched = false) => {
    htmlAutocomplete.classList.remove("hidden");
    return `
    <div class="py-1" role="none">
      ${results.map((result) => `
      <a href="?search=${result}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
        ${strongify(result, search, refetched)}
      </a>`).join('')}
    </div>`
  };

  const strongify = (result, search, refetched) => {
    if (refetched || !search) {
      return `<strong>${result}</strong>`;
    }
    const regex = new RegExp(`\\b(${search})\\S*\\s+(.+)`, 'i');
    const match = result.match(regex);
    return match
      ? `${match[1]}<strong>${result.slice(match.index + match[1].length)}</strong>`
      : `<strong>${result}</strong>`
  };

})()
