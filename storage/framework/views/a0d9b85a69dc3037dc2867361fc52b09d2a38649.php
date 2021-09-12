<?php $__env->startSection('content'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
</div>
<section>
    <form method="POST" action="<?php echo e(url('product/update')); ?>" accept-charset="UTF-8" class="form-horizontal" id="userId" enctype="multipart/form-data">
    <?php echo e(method_field('PUT')); ?>

    <?php echo csrf_field(); ?>  
        <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text"  placeholder="Product Name" class="form-control" name="title" value="<?php echo $targetArr->title; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Product SKU</label>
                        <input type="text" placeholder="Product Name" class="form-control" name="sku" value="<?php echo $targetArr->sku; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea id="" cols="30" rows="4" class="form-control" name="description" ><?php echo $targetArr->description; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                </div>
                <div class="card-body border">

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Variants</h6>
                </div>
                <div class="card-body">

                    <div class="row" id="k">
                        <?php if(!empty($variantListArr)): ?>
                        <?php $__currentLoopData = $variantListArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vId =>$vArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $totalVar = count($variantListArr);
                        ?>
                        <div class="col-md-12 variant-<?php echo e($vId); ?>">
                            <div class="col-md-6 pull-left">
                                <div class="form-group">
                                    <label class="text-primary" for="">Option</label>
                                    <br />
                                    <select class="form-control variantid" name="variant_id[<?php echo $vId; ?>]" id="variantid">
                                        <?php if(!empty($variants)): ?>
                                        <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k); ?>" <?php echo e(($vId==$k)?'selected':''); ?>>
                                            <?php echo e($variant); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="form-group">
                                    <label class="float-right text-primary remove" data-id="<?php echo e($vId); ?>" style="cursor: pointer;">Remove</label>
                                    <select class="form-control" name="variant_name[<?php echo $vId; ?>][]" multiple >
                                        <?php $__currentLoopData = $vArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($variant); ?>" selected>
                                            <?php echo e($variant); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" id="addVariant" type="button">Add another option</button>
                </div>

                <div class="card-header text-uppercase">Preview</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Variant</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                </tr>
                            </thead>
                            <tbody> 

                                <?php if(!empty($previewArr->ProductVariantPrice)): ?>
                                <?php $__currentLoopData = $previewArr->ProductVariantPrice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productVariant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> 
                                        <?php echo e($productVariant->one_variant); ?> /
                                        <?php echo e($productVariant->two_variant); ?> 
                                        <?php echo e(!empty($productVariant->three_variant)?'/'.$productVariant->three_variant:''); ?>

                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo e(number_format($productVariant->price,2)); ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo e(number_format($productVariant->stock,2)); ?>">
                                    </td>
                                </tr> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Save</button>
    <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
    </form>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $(".js-example-responsive").select2({
            width: 'resolve' // need to override the changed default
        });
        $(document).on("click", '#addVariant', function (e) {
            $('.js-example-responsive').select2();
        });
        $(document).on("click", '.remove', function (e) {
            var id = $(this).attr("data-id");
            $(".variant-" + id).remove();
            return false;
        });

    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7412\htdocs\interview\resources\views/products/edit.blade.php ENDPATH**/ ?>