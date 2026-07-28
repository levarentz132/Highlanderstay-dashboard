<?php $attributes = $attributes->exceptProps(['label', 'value', 'note', 'tone' => 'teal']); ?>
<?php foreach (array_filter((['label', 'value', 'note', 'tone' => 'teal']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<article class="metric-card">
    <span class="metric-icon <?php echo e($tone); ?>">▣</span>
    <p><?php echo e($label); ?></p>
    <strong><?php echo e($value); ?></strong>
    <small><?php echo e($note); ?></small>
</article>
<?php /**PATH C:\xampp\htdocs\Highlanderstay dashboard\resources\views/components/metric.blade.php ENDPATH**/ ?>