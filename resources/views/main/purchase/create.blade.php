@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Purchase') }}
@endsection
@section('page-style')
    <style type="text/css">
        td {
            padding: 0 !important;
            width: 20rem !important;
        }
    </style>
@endsection
@section('content')
    @include('utils.purchase_form')
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Navigate-Table-Arrow-Keys/dist/arrow-table.js"></script>

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
                        $(this).slideUp(deleteElement);
                    },
                });
                addRowX($('#rowCount').val());
                $('.table').arrowTable({
                    focusTarget: 'input, textarea, select',
                    listenTarget: 'input, select',
                });
            });
        });

        function addRowX(count = 1) {
            for (let i = 0; i < count; i++) {
                $('.btn-addRow').click();
            }
            focusElement();
        }

        function focusElement(){
            let list = $('#purchase_items_list');
            let valueChecker = list.children('tr:first-child').children('td:first-child').children(':first-child');
            let elementToBeFocused;
            if(valueChecker.val().length === 0){
                elementToBeFocused = list.children('tr:first-child');
            }else{
                elementToBeFocused = list.children('tr:last-child');
            }
            elementToBeFocused.children('td:first-child').children(":first-child").focus();
        }

    </script>
@endsection
