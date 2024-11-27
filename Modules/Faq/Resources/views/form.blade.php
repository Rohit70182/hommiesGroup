<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            <label>Question</label>
            <input type="text" class="form-control" name="question" value="{{ isset($faq) ? $faq->question : '' }}" >
            {!! $errors->first('question', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            <label>Answer</label>
            <textarea class="form-control" name="answer" rows="6" >{{ isset($faq) ? $faq->answer : '' }}</textarea>
            {!! $errors->first('answer', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-bg">Submit</button>
    </div>
</div>
