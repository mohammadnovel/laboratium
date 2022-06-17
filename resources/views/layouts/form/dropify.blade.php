<div class="form-group">    
    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>
    <input type="file" class="dropify" id="{{ $name }}" name="{{ $name }}" {!! buildTag($options['attr']) !!}  data-default-file="{{ $options['value'] }}" />
</div>