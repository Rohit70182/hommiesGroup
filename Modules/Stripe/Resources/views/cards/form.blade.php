@extends('admin.layouts.app')
@section('content')

<h2>{{ isset($settings) ? 'Update' : 'Add' }}</h2><br>

<div class="card p-5">
    <div id="payment-stripe" class="container">
        <div class="row text-left">
            <div class="col-sm-12">
                <div class="text-danger" id="stripe_message"></div>
                <div class="form-group">
                    <label">Card Number</label>
                        <div class="input-group">
                            <input id="cc-number" type="number" class="form-control" placeholder="•••• •••• •••• ••••" required>
                        </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Expiration (MM)</label>
                    <div class="input-group">
                        <input id="cc-month" type="number" class="form-control" placeholder="••" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Expiration (YYYY)</label>
                    <div class="input-group">
                        <input id="cc-year" type="number" class="form-control" placeholder="••••" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>CVC Code</label>
                    <div class="input-group">
                        <input id="cc-cvc" type="tnumberel" class="form-control" placeholder="•••" required>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-bg" id="card-button" type="button" id="validate">Save</button>
    </div>
</div>
@endsection
@push('style')
@endpush
@push('scripts')
<script src="{{ url('/Modules/Stripe/public/js/card-validation.js') }}" defer></script>
<script>
    var SITEURL = "{{url('/')}}";
</script>
@endpush