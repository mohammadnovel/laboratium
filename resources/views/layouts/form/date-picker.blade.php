<div class="form-group">
    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>
    <input type="text" class="form-control datepicker-input" id="{{ $name }}" name="{{ $name }}"
        data-toggle="datetimepicker" data-target="#{{ $name }}" />
</div>
