@extends('frontend.layouts.master')
@section('content')
    <div class="maininnver homeh">
        <div class="container">
            <h1 class="cathead">Contact Us</h1>
            <form class="form-horizontal mt-5" id="contactForm" action="{{url('contactsubmit')}}" method="post">
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
                    <label for="contreason" class="col-xs-12 col-sm-4 col-md-4 com4mod control-label mandatory">I want to </label>
                    <div class="col-sm-1 com1mod padtop20 hidden-xs">:</div>
                    <div class="col-xs-12 col-sm-7 col-md-6">
                        <div class="input-group">
                            <select name="contreason" id="contreason" class="form-control myselectclass blur">
                                <option value="">--Select contact reason--</option>
                                <option value="Advertise with www.franchiseindia.com">Advertise with www.franchiseindia.com</option>
                                <option value="Advertise in Magazine">Advertise in Magazine</option>
                                <option value="Exhibit in Shows">Exhibit in Shows</option>
                                <option value="Expand my Company through Franchising">Expand my Company through Franchising</option>
                                <option value="Buy a Franchise (Business)">Buy a Franchise (Business)</option>
                                <option value="Sell my Existing Business">Sell my Existing Business</option>
                                <option value="Subscribe to the Magazine">Subscribe to the Magazine</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contreason" class="col-xs-12 col-sm-4 col-md-4 com4mod control-label"></label>
                    <div class="col-sm-1 com1mod padtop20 hidden-xs"></div>
                    <div class="col-xs-12 col-sm-7 col-md-6">
                        <input type="checkbox" name="is_termsagree" id="is_termsagree" value="1">
                        I agree to the <a href="https://www.franchiseindia.com/terms" target="_blank">Term of services</a>
                    </div>
                </div>
                <div style="text-align:center">
                    <input type="submit" id="btnhome" class="btn-expert valid" value="Submit">
                </div>
            </form>

            <p class="text-left"><b>For Contact:</b> <br><br><i class=" fa fa-envelope"></i> Mail us at <a href="mailto:info@franchiseindia.com">info@franchiseindia.com</a></p>
        </div>

    <!-- mag block strat  -->
    @include("frontend.includes.magblock")
    </div>
    @push('child-scripts')
    <script>
        $( document ).ready(function() {
            $("#contactForm").validate(
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
                        }
                    }
                }
            );
        });

    </script>
    @endpush
@stop

