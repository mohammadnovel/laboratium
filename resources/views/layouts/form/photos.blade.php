  
<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>
<div class="input-group image-preview">
    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
    <span class="input-group-btn">
        <!-- image-preview-clear button -->
        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
            <span class="glyphicon glyphicon-remove"></span> Clear
        </button>
        <!-- image-preview-input -->
        <div class="btn btn-default image-preview-input">
            <span class="glyphicon glyphicon-folder-open"></span>
            <span class="image-preview-input-title">Browse</span>
            <input type="file" accept="image/png, image/jpeg, image/gif" data-target="#image-view" class="photo-file" name="<?=$name?>"/> <!-- rename it -->
        </div>
    </span>
</div><!-- /input-group image-preview [TO HERE]--> 
<span id="images-error" class="invalid-feedback"></span>
<div id="image-view" class="row"></div>
<style>
.container{
    margin-top:20px;
}
.image-preview-input {
    position: relative;
	overflow: hidden;
	margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input .invalid-feedback{
    display: none !important;
}
.image-preview-input input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}
#image-view .list{
    position: relative;
    margin-top: 10px;
    height: 70px;
    overflow: hidden;
}
#image-view .list span{
    position: absolute;
    width: 20px;
    height: 20px;
    background: red;
    text-align: center;
    right: 10px;
    top: 0;
    font-size: 12px;
    color: white;
    cursor: pointer;
}
#image-view .list{
    margin-bottom: 10px;
}
</style>