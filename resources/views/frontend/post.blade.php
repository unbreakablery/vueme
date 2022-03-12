@extends('layouts.app')

@section('content')



<post :id="{{json_encode($id)}}" :user="{{json_encode($user)}}" :guest="{{json_encode($guest)}}"></post>

{{-- <div id="videos">
        <div id="subscriber"></div>
        <div id="publisher"></div>
    </div>--}}
{{--<script type="text/javascript">
     var apiKey = '{{ env('OPENTOK_APIKEY') }}';
var sessionId = '{{$session_token}}';
var token = '{{$opentok_token}}';

// (optional) add server code here
initializeSession();

// Handling all of our errors here by alerting them
function handleError(error) {
if (error) {
alert(error.message);
}
}

function initializeSession() {
var session = OT.initSession(apiKey, sessionId);

// Subscribe to a newly created stream
session.on('streamCreated', function(event) {
session.subscribe(event.stream, 'subscriber', {
insertMode: 'append',
width: '100%',
height: '100%'
}, handleError);
});

// Create a publisher
var publisher = OT.initPublisher('publisher', {
insertMode: 'append',
width: '100%',
height: '100%'
}, handleError);

// Connect to the session
session.connect(token, function(error) {
// If the connection is successful, publish to the session
if (error) {
handleError(error);
} else {
session.publish(publisher, handleError);
}
});
}
</script>--}}

@endsection