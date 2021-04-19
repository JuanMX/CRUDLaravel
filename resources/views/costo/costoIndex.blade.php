@extends('layouts.app')
@section('title','Costo')
@section('content')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<input type="text" name="daterange" value="01/01/2018 - 01/15/2018" />

<script>

  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    "singleDatePicker": true,
    "showDropdowns": true,
    "timePicker": true,
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
</script>
@endsection