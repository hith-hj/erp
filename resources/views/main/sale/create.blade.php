@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Sale') }}
@endsection
@section('vendor-style')
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
@endsection
@section('content')
@include('utils.sale_form')
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                'use strict';
                // form repeater jquery
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
