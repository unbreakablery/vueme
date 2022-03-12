@extends('layouts.app')

@section('content')
<write-review :appointment="{{json_encode($appointment)}}">


</write-review>



@endsection