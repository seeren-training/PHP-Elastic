<div class="flex items-baseline justify-between border-b border-gray-200 py-6">
  <h1 class="text-4xl font-bold tracking-tight text-gray-900 grow">Training Elastic</h1>
  <form class="-mr-px grid grid-cols-1 focus-within:relative relative" action='' method="get">
    <input
      value="<?= filter_input(INPUT_GET, 'search') ?? '' ?>"
      type="text"
      name="search"
      id="search"
      aria-label="Search products"
      class="shadow-md mr-auto col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 sm:text-sm/6"
      placeholder="Search products"
      autocomplete="off" />
    <svg class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
      <path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" />
    </svg>
    <div class="hidden absolute top-10 z-10 w-full rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
      id="autocomplete"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="menu-button"
      tabindex="-1">
      <div class="py-1" role="none">
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Account settings</a>
      </div>
    </div>
  </form>
</div>
