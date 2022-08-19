@extends('frontend.layouts.master')
@section('content')
    <div class="maininnver">
        <div class="container text-center"><br><br><br>
            <h2>Thank You</h2><br>
            For Submitting information for Free Advice!
            <br><br><br>
        </div>

       <!--  <div class="listblk">
            <div class="container">
                <p>Our customer care executives will get in touch with you shortly.</p>
            </div>
        </div> -->

        @include("frontend.includes.topfranchisecategories")
        <!-- mag block strat  -->
        @include("frontend.includes.magblock")
    </div>

@stop
