<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(Admin::title()); ?> <?php if($header): ?> | <?php echo e($header); ?><?php endif; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php echo Admin::css(); ?>


    <script src="<?php echo e(Admin::jQuery()); ?>"></script>
    <?php echo Admin::headerJs(); ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition <?php echo e(config('admin.skin')); ?> <?php echo e(join(' ', config('admin.layout'))); ?>">
<div class="wrapper">

    <?php echo $__env->make('admin::partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('admin::partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content-wrapper" id="pjax-container">
        <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
        </div>
        <?php echo Admin::script(); ?>

    </div>

    <?php echo $__env->make('admin::partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>

<button id="totop" title="Go to top" style="display: none;"><i class="fa fa-angle-double-up"></i></button>

<script>
    function LA() {}
    LA.token = "<?php echo e(csrf_token()); ?>";
</script>

<!-- REQUIRED JS SCRIPTS -->
<?php echo Admin::js(); ?>


</body>
</html>
