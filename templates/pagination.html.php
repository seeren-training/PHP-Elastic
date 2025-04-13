<?php
$maxResults = $limit;
$firstResult = $offset;
$totalResults = $count;
$totalPages = ceil($totalResults / $maxResults);
$currentPage = ($firstResult / $maxResults) + 1;
?>

<nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
    <div class="-mt-px flex w-0 flex-1">
        <?php if ($currentPage > 1): ?>
            <a href="?<?= http_build_query(array_merge($params, ['page' => $currentPage - 1])) ?>"
                class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                <svg class="mr-3 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a.75.75 0 0 1-.75.75H4.66l2.1 1.95a.75.75 0 1 1-1.02 1.1l-3.5-3.25a.75.75 0 0 1 0-1.1l3.5-3.25a.75.75 0 1 1 1.02 1.1l-2.1 1.95h12.59A.75.75 0 0 1 18 10Z" clip-rule="evenodd" />
                </svg>
                Previous
            </a>
        <?php else: ?>
            <span class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-300 cursor-not-allowed">
                <svg class="mr-3 size-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a.75.75 0 0 1-.75.75H4.66l2.1 1.95a.75.75 0 1 1-1.02 1.1l-3.5-3.25a.75.75 0 0 1 0-1.1l3.5-3.25a.75.75 0 1 1 1.02 1.1l-2.1 1.95h12.59A.75.75 0 0 1 18 10Z" clip-rule="evenodd" />
                </svg>
                Previous
            </span>
        <?php endif; ?>
    </div>
    <div class="hidden md:-mt-px md:flex">
        <?php if ($currentPage > 3): ?>
            <a href="?<?= http_build_query(array_merge($params, ['page' => 1])) ?>" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">1</a>
            <?php if ($currentPage > 4): ?>
                <span class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500">...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
            <?php if ($i == $currentPage): ?>
                <a href="?<?= http_build_query(array_merge($params, ['page' => $i])) ?>" class="inline-flex items-center border-t-2 border-indigo-500 px-4 pt-4 text-sm font-medium text-indigo-600" aria-current="page"><?= $i ?></a>
            <?php else: ?>
                <a href="?<?= http_build_query(array_merge($params, ['page' => $i])) ?>" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages - 2): ?>
            <?php if ($currentPage < $totalPages - 3): ?>
                <span class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500">...</span>
            <?php endif; ?>
            <a href="?<?= http_build_query(array_merge($params, ['page' => $totalPages])) ?>" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"><?= $totalPages ?></a>
        <?php endif; ?>
    </div>
    <div class="-mt-px flex w-0 flex-1 justify-end">
        <?php if ($currentPage < $totalPages): ?>
            <a href="?<?= http_build_query(array_merge($params, ['page' => $currentPage + 1])) ?>"
                class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                Next
                <svg class="ml-3 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                </svg>
            </a>
        <?php else: ?>
            <span class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-300 cursor-not-allowed">
                Next
                <svg class="ml-3 size-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                </svg>
            </span>
        <?php endif; ?>
    </div>
</nav>