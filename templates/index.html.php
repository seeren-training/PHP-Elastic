<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/assets/js/autocomplete.js" defer></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Elastic</title>
</head>

<body class="h-full flex">
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 bg-white grow lg:flex flex-col hidden">
        <?php include __DIR__ . '/header.html.php' ?>
        <section aria-labelledby="products-heading" class="py-6 grow flex flex-col">
            <?php if (count($products)): ?>
                <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                    <div class="lg:col-span-1 flex flex-col h-full">
                        <?php include __DIR__ . '/filters.html.php'; ?>
                    </div>
                    <div class="lg:col-span-3 flex flex-col">
                        <?php include __DIR__ . '/product-list.html.php'; ?>
                    </div>

                </div>
                <?php include __DIR__ . '/pagination.html.php'; ?>
            <?php else: ?>
                <?php include __DIR__ . '/product-list-empty.html.php'; ?>
            <?php endif; ?>
        </section>
    </main>


</body>