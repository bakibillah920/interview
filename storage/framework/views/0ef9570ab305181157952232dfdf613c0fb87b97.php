<?php $__env->startSection('content'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
    <form action="" method="get" class="card-header">
        <div class="form-row justify-content-between">
            <div class="col-md-2">
                <input type="text" name="title" placeholder="Product Title" class="form-control" value="<?php echo e(Request::get('title')); ?>">
            </div>
            <div class="col-md-2">
                <select name="variant_id" id="" class="form-control">
                    <?php if(!empty($variantListArr)): ?>

                    <option value="">--Select Variant--</option>
                    <?php $__currentLoopData = $variantListArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vId =>$vArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <optgroup label="<?php echo $variantNameArr[$vId]; ?>">
                        <?php $__currentLoopData = $vArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($variant); ?>" <?php echo e(($variant==Request::get('variant_id'))?'selected':''); ?>><?php echo $variant; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </optgroup>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control" value="<?php echo e(Request::get('price_from')); ?>">
                    <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control" value="<?php echo e(Request::get('price_to')); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" class="form-control" value="<?php echo e(Request::get('date')); ?>">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!$targetArr->isEmpty()): ?>
                    <?php
                    $page = Request::get('page');
                    $page = empty($page) ? 1 : $page;
                    $sl = ($page - 1) * 3;
                    ?>
                    <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(++$sl); ?></td>
                        <td width="20%"><?php echo $target->title; ?> <br> Created at : <?php echo date_format($target->created_at,"d M Y"); ?></td>
                        <td><?php echo $target->description; ?></td>
                        <td width="35%">
                            <?php if(!empty($target->ProductVariantPrice)): ?>
                            <?php $__currentLoopData = $target->ProductVariantPrice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productVariant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <dl class="row mb-0" style="height: 70px; overflow: hidden" id="variant">
                                <dt class="col-sm-3 pb-0">
                                    <?php echo e($productVariant->one_variant); ?> /
                                    <?php echo e($productVariant->two_variant); ?> 
                                    <?php echo e(!empty($productVariant->three_variant)?'/'.$productVariant->three_variant:''); ?>

                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">Price : <?php echo e(number_format($productVariant->price,2)); ?></dt>
                                        <dd class="col-sm-8 pb-0">InStock : <?php echo e(number_format($productVariant->stock,2)); ?></dd>
                                    </dl>
                                </dd>
                            </dl>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('product.edit', $target->id)); ?>" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <?php
                $start = empty($targetArr->total()) ? 0 : (($targetArr->currentPage() - 1) * $targetArr->perPage() + 1);
                $end = ($targetArr->currentPage() * $targetArr->perPage() > $targetArr->total()) ? $targetArr->total() : ($targetArr->currentPage() * $targetArr->perPage());
                ?>
                <p>Showing <?php echo e($start); ?> to <?php echo e($end); ?> out of <?php echo e($targetArr->total()); ?></p>
            </div>
            <div class="col-md-3">
                <?php echo e($targetArr->appends(Request::all())->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7412\htdocs\interview\resources\views/products/index.blade.php ENDPATH**/ ?>