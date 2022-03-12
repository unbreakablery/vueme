@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com/about">
<meta name="keywords" content="first psychic reading">
<meta name="description" content="Enjoy personal and private readings, including $5 off your first psychic reading with a spiritual advisor, using Respectfully’s™ modern platform today.">
@endsection
@section('title', 'First Model Reading | Online Models | ')
@section('content')
<home-top></home-top>
<section class="fourColSection" style="background: #fff">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="fourColContainer iconContainerAbout">
                    <div class="fourColItem">
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/sign-up.png" alt="Sign up" class="img-fluid">
                        </div>
                        <p>Signup and browse our providers for free.</p>
                    </div>
                    <div class="fourColItem">
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/browse.png" alt="Browse" class="img-fluid">
                        </div>
                        <p>When you find a trusted advisor, we’ll add $5 extra towards your first reading for free!</p>
                    </div>
                    <div class="fourColItem">
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/discover.png" alt="Discover" class="img-fluid">
                        </div>
                        <p>Sort and view our directory of advisors by specialty, tools used, and reading style.</p>
                    </div>
                    <div class="fourColItem">
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/advice.png" alt="Advice" class="img-fluid">
                        </div>
                        <p>Get the advice and guidance you want on demand, from wherever you are..</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="thirdSectionHeading thirdSectionHeading-about">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer">
                    <h2>more answers, better clarity, stronger guidance</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="thirdSectionHeading thirdSectionHeading-about" style="background: #fff">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer mt-4">
                    <p>
                    Respectfully™ was founded with the belief that engaging with highly-rated spiritual advisors should be simple, private, and affordable. We have experienced tremendous growth since our launch, thanks to our unique and tech-forward approach to filling the needs of an evolving industry, our wide range of compassionate and empowered spiritual advisors to choose from, and our extremely satisfied clients. 
                        
                    <br><br>
                        Whether you are looking to experience your first psychic reading or simply need guidance during a difficult time in your life, Respectfully’s™ more than 2,000 spiritual advisors are easily accessible via our innovative chat, audio and video calling platform. We’ve made connecting you with a spiritual advisor that fits your personal needs the number one priority, and as a bonus get $5 off your first reading!

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="thirdSection thirdSectionHeading-about" style="background: #fff">
    <div class="container">
        <div class="row">
            <div class="col p-0">
                <div class="thirdSecContainer">
                    <div class="itemContainer">
                        <div class="imgContainer">
                            <img src="{{ env('APP_URL') }}/images/top-quality-about.png" alt="Top Quality Network" class="img-fluid">
                        </div>
                        <div class="itemContent">
                            <h4>Top Quality Network</h4>
                            <p>Our top-tier network of experienced and compassionate professionals is here to give you the direct attention you deserve.</p>
                        </div>
                    </div>
                    <div class="itemContainer">
                        <div class="imgContainer">
                            <img src="{{ env('APP_URL') }}/images/available-about.png" alt="Always Available" class="img-fluid">
                        </div>
                        <div class="itemContent">
                            <h4>Always Available</h4>
                            <p>Anywhere in the world, anytime of day - our experts are here for you when you need them the most. Providing best in class readings, answers and advice.</p>
                        </div>
                    </div>
                    <div class="itemContainer">
                        <div class="imgContainer">
                            <img src="{{ env('APP_URL') }}/images/upfront-rates-about.png" alt="Simple Upfront Rates" class="img-fluid">
                        </div>
                        <div class="itemContent">
                            <h4>Simple Upfront Rates</h4>
                            <p>No guessing games and no surprise charges later on. Just clear Services and Rates on each profile so you know exactly how much you’re spending.</p>
                        </div>
                    </div>
                    <div class="itemContainer">
                        <div class="imgContainer">
                            <img src="{{ env('APP_URL') }}/images/clarity-about.png" alt="Clarity Where You Need It" class="img-fluid">
                        </div>
                        <div class="itemContent">
                            <h4>Clarity Where You Need It</h4>
                            <p>Our growing gallery of Models, Mediums, Healers and Astrologers offers everything you’re looking for – from spiritual readings to relationship guidance to dream interpretation and horoscope navigation. It’s all here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="thirdSectionHeading thirdSectionHeading-about">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer">
                    <h2>Empower Your Future</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<home-section-4></home-section-4>

<section class="fifthSection thirdSectionHeading-about" >
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="fifthSecContainer">
                    <h3>Connect Your Way</h3>
                    <h4>It’s easy, secure and free to get started.</h4>
                    <div class="fifthSecItemContainer">
                        <div class="conItemContainer">
                            <div class="imgContainer">
                                <img src="{{ env('APP_URL') }}/images/messaging-about.png" alt="Messaging" class="img-fluid">
                            </div>
                            <div class="itemContent">
                                <h5>Messaging</h5>
                                <p>Immediate answers and insight wherever you are – plus added ability to send
                                    photos and videos.</p>
                            </div>
                        </div>
                        <div class="conItemContainer">
                            <div class="imgContainer">
                                <img src="{{ env('APP_URL') }}/images/calls-about.png" alt="Calls" class="img-fluid">
                            </div>
                            <div class="itemContent">
                                <h5>Calls</h5>
                                <p>Let your voice tell the story and get the answers you’re looking for.</p>
                            </div>
                        </div>
                        <div class="conItemContainer">
                            <div class="imgContainer">
                                <img src="{{ env('APP_URL') }}/images/videocal-about.png" alt="Video Chat" class="img-fluid">
                            </div>
                            <div class="itemContent">
                                <h5>Video Chat</h5>
                                <p>Live 1:1 video chat so you can connect visually and enjoy even more in-depth
                                    readings.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="thirdSectionHeading thirdSectionHeading-about pt-5 pb-5" style="background: #fff">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer">
                    <h2 style="padding-bottom: 30px">Model Advice Exactly When You Need It</h2>
                    <p  class="textMobAbout">
                        
                        Our clients rave about the streamlined appearance and user-friendly functionality of our platform, which makes getting the advice and guidance you want exactly when you need it a total breeze. Connecting with our top-tier network of experienced and compassionate professionals, who are located all around the world and available any time of day, means you will receive trusted readings, answers, and advice for your first psychic readings and beyond. 
                        <br><br>
                        Thanks to Respectfully’s™ simple upfront rates and $5 off your first reading with any of the thousands of spiritual advisors in our network, finding the clarity you need to tackle life’s biggest hurdles is just a click away.
                        
                    </p>
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

<home-section-6></home-section-6>

{{-- <home-section-7></home-section-7> --}}



@endsection