@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h4 class="link_intro">Payment Method</h4>
    <h1 class="link_intro_mobile">Payment Method</h1>
    <payment :cards={{json_encode($cards)}}></payment>
</div>
@endsection
