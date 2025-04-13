<ul role="list" class="mx-4 inline-flex space-x-8 sm:mx-6 lg:mx-0 lg:grid lg:grid-cols-4 lg:gap-x-8 lg:space-x-0 gap-y-4 py-8">
    <?php foreach ($products as $product): ?>
        <li class="inline-flex w-64 flex-col text-center lg:w-auto">
            <div class="group relative">
                <img src="<?= $product->getImageLink() ?>"
                    title="<?= filter_var($product->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>"
                    alt=""
                    class="border-0 aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 h-48 overflow-hidden" onerror="this.src='/assets/images/fallback.webp'">
                <div class="mt-6">
                    <p class="text-sm text-gray-500 truncate" title="<?= filter_var($product->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>"
                        <?= filter_var($product->getDescription(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>
                        </p>
                    <h3 class="mt-1 font-semibold text-gray-900 truncate" title="<?= filter_var($product->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>">
                        <?= filter_var($product->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>
                    </h3>
                    <p class="mt-1 text-gray-900">
                        <?= filter_var($product->getPrice(), FILTER_SANITIZE_NUMBER_INT) ?>
                    </p>
                </div>
            </div>
            <h4 class="sr-only">Available colors</h4>
            <ul role="list" class="mt-auto flex items-center justify-center space-x-3 pt-6">
                <?php foreach (array_slice([...$product->getColors()], 0, 5) as $color): ?>
                    <li class="size-4 rounded-full border border-black/10" style="background-color: <?= $color->getHex() ?>">
                        <span class="sr-only">
                            <?= filter_var($color->getName(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>