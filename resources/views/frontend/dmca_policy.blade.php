@extends('layouts.app')

@section('content')
<div class="container px-5 py-5 my-5" style="margin-top: @if(Auth::user()){{'96px!important'}}@else{{'56px!important'}}@endif">
    <h1 style="font-size: 1.5rem;">VueMe™ DMCA Policy</h1>
    <p>Date Updated: </p>
    <p>We comply with the Digital Millennium Copyright Act of 1998, as amended (the “DMCA”) at all times and maintain a repeat offender policy which may result in the termination, where appropriate, of your right to use the Services if you violate such policy. If you believe that your work has been copied, posted or otherwise made available through the Services in a way that constitutes copyright infringement, please notify our DMCA Copyright Agent of your complaint, as set forth in the DMCA. Please consult with the DMCA to confirm these requirements.</p>
    <p>
        You must provide our DMCA Copyright Agent with the following information in writing, to the extent required by the DMCA: </p>

    <p class="ml-5">
        1. An electronic or physical signature of the person authorized to act on behalf of the copyright owner that is allegedly infringed; </p>
    <p class="ml-5">2. A description of the copyrighted work that you claim has been infringed (or, if multiple copyrighted works on the Site are covered by a single complaint, a representative list of the allegedly infringed works on the Site);</p>
    <p class="ml-5">
        3. Identification of the material that is claimed to be infringing and to be removed, and information reasonably sufficient to permit us to locate the material;</p>
    <p class="ml-5">4. Information reasonably sufficient to permit us to contact you, such as your address, telephone number, and e-mail address;</p>
    <p class="ml-5">
        5. A written statement by you that you have a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent or the law; and</p>
    <p class="ml-5">6. A statement by you, made under penalty of perjury, that the above information in your notice and complaint is accurate and that you are the copyright owner or authorized to act on the copyright owner’s behalf.</p>

    <p>Please be aware that the foregoing information in your notice and complaint may be forwarded to the person who provided the allegedly infringing material. The foregoing information must be submitted to our DMCA Copyright Agent as follows:</p>

    <p class="mb-0">Michael E. Neukamm, Esq. </p>
    <p class="mb-0">GrayRobinson, PA</p>
    <p class="mb-0">301 East Pine Street, Suite 1400 </p>
    <p class="mb-0">Post Office Box 3068 (32803-3068)</p>
    <p class="mb-0">Orlando, Florida 32801</p>
    <p>Fax: (407) 244-5690</p>
    <p>Please do not send any other inquiries or information to our DMCA Copyright Agent.</p>

    <p>Notification and Take Down Procedures. Upon receipt of a DMCA compliant notice of infringement, the subject content will be removed from the Site and a notice will be sent to the person responsible for uploading the subject content (the “Uploader”). The Uploader will then have the opportunity to submit a counter-notification, more fully detailed below, in compliance with the DMCA. Upon receipt of a counter-notification, the applicable Uploader will be permitted to re-upload the subject content and a copy of the counter-notification will be sent to the original party claiming infringement. In the event that a non-DMCA compliant notice is received, we reserve the right, in our sole discretion to remove the content and inform the responsible Uploader; further, we reserve the right, but do not undertake the obligation to, communicate with the original complainant any response received from the responsible Uploader. We have and observe a repeat offender policy and will terminate the Account of anyone using the Services who violates such policy, where appropriate.</p>
    <p>DMCA Counter-Notification Procedure. Upon receipt of a DMCA compliant notice of infringement, we will inform the responsible Uploader of such claim, including, at our election, providing a copy of the claim of infringement. At that time, if the Uploader believes that the claim of infringement is erroneous or false, and/or that the allegedly infringing content has been wrongly removed in response to such claim, the Uploader shall have the opportunity to submit a counter-notification pursuant to Section 512(g)(2) and (3) of the DMCA. The information that an Uploader provides in a counter-notification must be accurate and truthful, and the Uploader will be liable for any misrepresentations that may cause any claims to be brought against us relating to the reported content. To submit a counter-notification, please provide our DMCA Copyright Agent the following information:</p>
    <p class="ml-5">1. A specific description of the material that was removed or disabled pursuant to the DMCA notice;</p>
    <p class="ml-5">2. A description of where the material was located within the Site before such material was removed and/or disabled (please provide the specific URL, if possible); and</p>
    <p class="ml-5">3. A statement reflecting the Uploader’s belief that the removal or disabling of the material was done so erroneously. For convenience, the following format may be used: “I swear, under penalty of perjury, that I have a good faith belief that the referenced material was removed or disabled by the Site provider as a result of mistake or misidentification of the material to be removed or disabled.”</p>
    <p class="ml-5">4. The Uploader’s address, telephone number, and e-mail address.</p>
    <p>Written notification containing the above information must be signed and sent to our DMCA Copyright Agent as set forth above.</p>
    <p>After receiving a DMCA compliant counter-notification, our DMCA Copyright Agent will forward it to us, and we will then provide the counter-notification to the original party claiming infringement. </p>
    <p>Additionally, within 10-14 days of our receipt of the counter-notification, we will replace or cease disabling access to the disputed material provided that our DMCA Copyright Agent has not received notice from the original party claiming infringement that such party has filed a legal action pertaining to the disputed material.</p>
    <p>We reserve the right to modify, alter or add to this policy, and all Users should regularly check back to stay current on any such changes.</p>

</div>
@endsection