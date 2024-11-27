<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="{{$page->title}}">
                    {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type_id" id="type_id">
                        <option value="">Select type</option>
                        @foreach(@$types as $key=>$type)
                        <option value="{{ @$key }}" @if($page->type_id == $key) selected='selected' @endif >{{ @$type }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('type_id', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="editor1">{{$page->description}}</textarea>
                    {!! $errors->first('editor1', '<div class="invalid-feedback">The Description field is required.</div>') !!}

                </div>
            </div>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-bg">Submit</button>
    </div>
</div>