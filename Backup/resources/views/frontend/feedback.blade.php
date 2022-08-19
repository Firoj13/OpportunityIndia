@extends('frontend.layouts.master')
@section('content')
    <div class="maininnver homeh">
        <div class="maininnver homeh">
            <div class="container">
                <h1 class="cathead">Feedback</h1>
                <hr>
                <h3>Tell us what you think!</h3>
                <p>Your opinions and comments are very important to us and we read every message that we receive. Due to a high volume of messages, we're not always able to provide a personal response, but your few minutes for filling the feedback form will help us to provide you with improved quality services.
                </p>
                <p>
                    i'm writing about something i saw on opportunityindia.franchiseindia.com</p>
                <form class="form-horizontal mt-5" id="feedbackForm" action="{{url('feedbacksubmit')}}" method="post">
                   @csrf
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-4 col-md-4 com4mod control-label mandatory">Name</label>
                        <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control blur" name="name" placeholder="Enter Your Name" maxlength="25">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-4 com4mod control-label mandatory">Email
                        </label>
                        <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="input-group"><input type="text" class="form-control blur" name="email" placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-4 col-md-4 com4mod control-label mandatory">Mobile</label>
                        <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control blur" name="mobile" placeholder="Enter Mobile" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-4 col-md-4 com4mod control-label mandatory">Feedback topic</label>
                        <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control blur" id="ftopic" name="ftopic" placeholder="Enter feedback topic" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-4 col-md-4 com4mod control-label mandatory">Feedback</label>
                        <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="input-group">
                                <textarea class="form-control height100 blur" id="feedback" name="feedback" placeholder="Enter Your feedback"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="text-align:center">
                        <input type="submit" id="btnhome" class="btn-expert valid" value="Submit" >
                    </div>
                </form>


            </div>

        <!-- mag block strat  -->
        @include("frontend.includes.magblock")
    </div>
    @push('child-scripts')
    <script>
        $( document ).ready(function() {
            $("#feedbackForm").validate(
                {
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        mobile: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        contreason: {
                            required: true
                        },
                        is_termsagree: {
                            required: true
                        },
                        ftopic: {
                            required: true
                        },
                        feedback: {
                            required: true
                        }
                    }
                }
            );
        });

    </script>
    @endpush
@stop

