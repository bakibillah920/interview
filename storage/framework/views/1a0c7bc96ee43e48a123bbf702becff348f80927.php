<?php $__env->startSection('content'); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product Variant</h1>
        <a href="<?php echo e(route('product-variant.create')); ?>" class="float-right btn btn-primary">+ New Variant</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="form-row">
                <div class="col-md-3">
                    <input type="text" placeholder="Serch" class="form-control">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key +1); ?></td>
                            <td><?php echo e($variant->title); ?></td>
                            <td><?php echo e(nl2br($variant->description)); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('product-variant.edit',$variant)); ?>" class="btn btn-primary">Edit</a>
                                    <button class="btn btn-danger">delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-sm-flex align-items-center justify-content-between mb-4">
            <p>1 to 10 out of 100</p>
            <?php echo e($variants->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7412\htdocs\interview\resources\views/products/variant/index.blade.php ENDPATH**/ ?>