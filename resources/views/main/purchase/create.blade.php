@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Purchase') }}
@endsection
@section('content')
@include('utils.purchase_form')
@endsection
@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            $('.items-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm(
                            "{{ __('Are you sure you want to delete this element?') }}"
                        )) {
                        $(this).slideUp(deleteElement);
                    }
                },

            });
        });
    });
</script>
@endsection
