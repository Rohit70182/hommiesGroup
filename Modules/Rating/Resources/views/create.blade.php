@extends('admin.layouts.app')

@section('content')
<style type="text/css">    
.rating-star,
.rating:hover .rating-star {
    cursor: pointer;
    float: right;
    display: block;
    margin-right: 3px;
    width: 37px;
    height: 37px;
    background: url('../../images/starss.svg') 0 -38px;
}

.rating-input:checked~.rating-star {
    background-position: 0 0;
}
.rating:hover .rating-star:hover, .rating:hover .rating-star:hover ~ .rating-star, .rating-input:checked ~ .rating-star {
    background-position: 0 0;
}
</style>
<form action="{{ url('/rating/store-rating') }}" method="POST" >
    @csrf
    <div class="box_general_3 write_review mt-3">
        <div class="rating_submit">
            <div class="form-group">
                <input type="hidden" name="model_id" value="1">
                <input type="hidden" name="model_type" value="post">
                <label class="d-block">Overall rating</label>
                <span class="rating dr-rate">
                    <input type="radio" class="rating-input" id="1_star"
                        name="rating[1]" ><label for="1_star"
                        class="rating-star"></label>
                    <input type="radio" class="rating-input" id="2_star"
                        name="rating[2]"><label for="2_star"
                        class="rating-star"></label>
                    <input type="radio" class="rating-input" id="3_star"
                        name="rating[3]" ><label for="3_star"
                        class="rating-star"></label>
                    <input type="radio" class="rating-input" id="4_star"
                        name="rating[4]" ><label for="4_star"
                        class="rating-star"></label>
                    <input type="radio" class="rating-input" id="5_star"
                        name="rating[5]" ><label for="5_star"
                        class="rating-star"></label>
                </span>
            </div>
        </div>
        <!-- /rating_submit -->
        
        <div class="form-group">
            <label>Your review</label>
            <textarea class="form-control sentancee" name="title" style="height: 180px;"
                placeholder="Write your review here ..."></textarea>
                @if($errors->has('title'))
                    <div class="error text-danger">{{ $errors->first('title') }}</div>
                @endif
        </div>
        <button type="submit" class="btn btn-bg">Submit Review</button>
    </div>
</form>

@endsection
