```blade


<?php $__env->startSection('title', 'Shop Collection | GownEase'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .shop-page {
        color: #302B32;
    }

    .shop-hero {
        background: #F8F5F0;
        padding: 42px 24px;
        text-align: center;
        margin-bottom: 30px;
    }

    .shop-eyebrow {
        color: #B79A78;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 11px;
        font-weight: 600;
    }

    .shop-heading {
        font-family: 'Playfair Display', serif;
        color: #30263A;
        font-size: clamp(30px, 4vw, 46px);
        margin: 8px 0;
    }

    .shop-description {
        color: #777078;
        max-width: 600px;
        margin: 0 auto;
    }

    .filter-panel {
        border: 1px solid #E8E0D8;
        background: #fff;
        padding: 22px;
        margin-bottom: 30px;
    }

    .filter-panel label {
        font-size: 12px;
        color: #51415F;
        margin-bottom: 6px;
    }

    .filter-panel .form-control,
    .filter-panel .form-select {
        border-radius: 3px;
        min-height: 43px;
    }

    .collection-heading {
        font-family: 'Playfair Display', serif;
        color: #30263A;
    }

    .product-card {
        height: 100%;
        border: 1px solid #E8E0D8;
        background: white;
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(48, 38, 58, .10);
    }

    .product-image-wrap {
        position: relative;
        overflow: hidden;
        background: #F8F5F0;
    }

    .product-image {
        display: block;
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.025);
    }

    .product-image-placeholder {
        width: 100%;
        aspect-ratio: 3 / 4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777078;
        background: #F8F5F0;
    }

    .product-info {
        padding: 16px;
    }

    .product-category {
        color: #B79A78;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 10px;
        font-weight: 600;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        color: #30263A;
        text-decoration: none;
    }

    .product-name:hover {
        color: #B79A78;
    }

    .product-meta {
        color: #777078;
        font-size: 12px;
    }

    .product-price {
        font-weight: 600;
        font-size: 16px;
        color: #30263A;
    }

    .shop-button {
        display: block;
        width: 100%;
        padding: 10px;
        background: #30263A;
        border: 1px solid #30263A;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 12px;
        letter-spacing: .5px;
    }

    .shop-button:hover {
        background: #51415F;
        border-color: #51415F;
        color: white;
    }

    .empty-products {
        border: 1px solid #E8E0D8;
        padding: 50px 20px;
        text-align: center;
        background: #F8F5F0;
    }

    .empty-products h3 {
        font-family: 'Playfair Display', serif;
        color: #30263A;
    }

    .pagination {
        margin-top: 30px;
    }

    .page-link {
        color: #30263A;
        border-color: #E8E0D8;
    }

    .active > .page-link,
    .page-link.active {
        background: #30263A;
        border-color: #30263A;
        color: white;
    }
</style>

<div class="shop-page">

    
    <section class="shop-hero">
        <div class="shop-eyebrow">GownEase Collection</div>

        <h1 class="shop-heading">
            Find Your Perfect Look
        </h1>

        <p class="shop-description">
            Explore our collection of gowns, suits, and special-occasion
            outfits for your next memorable event.
        </p>
    </section>

    
    <section class="filter-panel">
        <form action="<?php echo e(route('shop')); ?>" method="GET" id="shop-filter-form">
            <div class="row g-3 align-items-end">

                <div class="col-12 col-md-6 col-lg-4">
                    <label for="search" class="form-label">Search products</label>

                    <input
                        type="search"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Search by name, color, size..."
                        value="<?php echo e(request('search')); ?>"
                    >
                </div>

                <div class="col-6 col-md-6 col-lg-2">
                    <label for="category" class="form-label">Category</label>

                    <select
                        name="category"
                        id="category"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Categories</option>

                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($category); ?>"
                                <?php if(request('category') === $category): echo 'selected'; endif; ?>
                            >
                                <?php echo e($category); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="color" class="form-label">Color</label>

                    <select
                        name="color"
                        id="color"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Colors</option>

                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($color); ?>"
                                <?php if(request('color') === $color): echo 'selected'; endif; ?>
                            >
                                <?php echo e($color); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="size" class="form-label">Size</label>

                    <select
                        name="size"
                        id="size"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Sizes</option>

                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($size); ?>"
                                <?php if(request('size') === $size): echo 'selected'; endif; ?>
                            >
                                <?php echo e($size); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="sort" class="form-label">Sort by</label>

                    <select
                        name="sort"
                        id="sort"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">Newest</option>
                        <option value="name" <?php if(request('sort') === 'name'): echo 'selected'; endif; ?>>
                            Name
                        </option>
                        <option value="price_low" <?php if(request('sort') === 'price_low'): echo 'selected'; endif; ?>>
                            Price: Low to High
                        </option>
                        <option value="price_high" <?php if(request('sort') === 'price_high'): echo 'selected'; endif; ?>>
                            Price: High to Low
                        </option>
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="min_price" class="form-label">
                        Minimum price (₱)
                    </label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        name="min_price"
                        id="min_price"
                        class="form-control"
                        value="<?php echo e(request('min_price')); ?>"
                        placeholder="0"
                    >
                </div>

                <div class="col-6 col-md-4">
                    <label for="max_price" class="form-label">
                        Maximum price (₱)
                    </label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        name="max_price"
                        id="max_price"
                        class="form-control"
                        value="<?php echo e(request('max_price')); ?>"
                        placeholder="No limit"
                    >
                </div>

                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark grow">
                        Apply Filters
                    </button>

                    <a href="<?php echo e(route('shop')); ?>"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </section>

    
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h2 class="collection-heading mb-1">
                <?php if(request()->filled('category')): ?>
                    <?php echo e(request('category')); ?>

                <?php else: ?>
                    Our Collection
                <?php endif; ?>
            </h2>

            <p class="text-secondary mb-0">
                <?php echo e($gowns->total()); ?>

                <?php echo e($gowns->total() === 1 ? 'item' : 'items'); ?> found
            </p>
        </div>

        <?php if(request()->filled('category')): ?>
            <a href="<?php echo e(route('shop')); ?>"
               class="text-decoration-none small">
                Clear category filter &times;
            </a>
        <?php endif; ?>
    </div>

    <?php if($gowns->count() > 0): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $gowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <article class="product-card">

                        <div class="product-image-wrap">
                            <a href="<?php echo e(route('shop.show', $gown)); ?>">
                                <?php if($gown->image): ?>
                                    <img
                                        src="<?php echo e(asset('storage/' . $gown->image)); ?>"
                                        alt="<?php echo e($gown->name); ?>"
                                        class="product-image"
                                        loading="lazy"
                                    >
                                <?php else: ?>
                                    <div class="product-image-placeholder">
                                        No image available
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="product-info">
                            <div class="product-category mb-1">
                                <?php echo e($gown->category); ?>

                            </div>

                            <a href="<?php echo e(route('shop.show', $gown)); ?>"
                               class="product-name">
                                <?php echo e($gown->name); ?>

                            </a>

                            <p class="product-meta mt-2 mb-2">
                                <?php echo e($gown->color); ?> · Size <?php echo e($gown->size); ?>

                            </p>

                            <div class="product-price mb-3">
                                ₱<?php echo e(number_format((float) $gown->rental_price, 2)); ?>

                                <span class="product-meta fw-normal">
                                    / rental
                                </span>
                            </div>

                            <a href="<?php echo e(route('shop.show', $gown)); ?>"
                               class="shop-button">
                                VIEW DETAILS
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="d-flex justify-content-center">
            <?php echo e($gowns->links()); ?>

        </div>
    <?php else: ?>
        <div class="empty-products">
            <h3>No matching products found</h3>

            <p class="text-secondary">
                There are no available products matching your selected
                category and filters.
            </p>

            <a href="<?php echo e(route('shop')); ?>" class="btn btn-dark mt-2">
                View All Products
            </a>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
```
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\SIA_FINALS\Gownease\resources\views/shops/index.blade.php ENDPATH**/ ?>