(() => {

  const htmlInput = document.getElementById('search');
  const htmlAutocomplete = document.getElementById('autocomplete');

  htmlInput.addEventListener('keydown', ((timeoutId) => (e) => {
    window.clearTimeout(timeoutId);
    timeoutId = window.setTimeout(() => autocomplete(e.target.value), 250);
  })(null));

  const autocomplete = (search) => {
    // TODO Fetch autocomplete then render
  }

})()
