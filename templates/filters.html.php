<form class="hidden lg:block py-6" action="?toto=tata" method="GET">
    <input
        value="<?= filter_input(INPUT_GET, 'search') ?? '' ?>"
        type="hidden"
        name="search" />
    <?php foreach ($filters as $filterName => $filterValues): ?>
        <div>
            <h3 class="flow-root shadow-sm">
                <button type="button" onclick="document.getElementById('<?= $filterName ?>').classList.toggle('hidden')"
                    class="border-b border-gray-200 flex w-full items-center justify-between bg-white shadow-sm py-3 text-sm text-gray-400 hover:text-gray-500"
                    aria-controls="<?= $filterName ?>" aria-expanded="false">
                    <span class="font-medium text-gray-900 uppercase"><?= ucfirst($filterName) ?></span>
                </button>
            </h3>
            <div class="pt-6 h-48 overflow-scroll" id="<?= $filterName ?>">
                <div class="space-y-4">
                    <?php foreach ($filterValues as $filterKey => $filterValue): ?>
                        <div class="flex gap-3">
                            <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input
                                        <?= isset($params['filters'][$filterName]) && in_array($filterKey, $params['filters'][$filterName]) ? 'checked' : '' ?>
                                        onchange="this.form.submit()"
                                        id="<?= $filterKey ?>"
                                        name="filters[<?= $filterName ?>][]"
                                        value="<?= $filterKey ?>"
                                        <?= !$filterValue ? 'disabled' : '' ?>
                                        type="checkbox"
                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                        <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <label for="<?= $filterKey ?>" class="text-sm text-gray-600"><?= $filterKey ?> (<?= $filterValue ?>)</label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</form>