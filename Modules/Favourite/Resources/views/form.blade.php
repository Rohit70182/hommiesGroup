<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('model_id') }}
            {{ Form::text('model_id', $item->model_id, ['class' => 'form-control' . ($errors->has('model_id') ? ' is-invalid' : ''), 'placeholder' => 'Model']) }}
            {!! $errors->first('model_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Model Class') }}
            {{ Form::text('model_type', $item->model_type, ['class' => 'form-control' . ($errors->has('model_type') ? ' is-invalid' : ''), 'placeholder' => 'Model class']) }}
            {!! $errors->first('model_type', '<div class="invalid-feedback">:message</div>') !!}
        </div>
   

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-bg">Submit</button>
    </div>
</div>