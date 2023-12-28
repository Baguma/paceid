@extends('layouts.master')
@section('page_title', 'Register Learners')
@section('content')
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Please fill The form Below To</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
               @csrf
                <h6>Personal data</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Full Name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address: <span class="text-danger">*</span></label>
                                <input value="{{ old('address') }}" class="form-control" placeholder="Address" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email address: </label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone 1:</label>
                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" placeholder="(0777) 777-777"
                                       data-mask="(9999) 999-999">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone 2:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="(0777) 777-777"
                                       data-mask="(9999) 999-999" >
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">Marital Status: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="marital_status" id="marital_status" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($maritalstatuses as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">Occupation: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Choose.." class="select-search form-control" name="occupation" id="occupation">
                                <option value=""></option>
                                @foreach($occupations as $st)
                                    <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">Highest Education: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Select Highest Education" class="select-search form-control" name="education_level" id="lga_id">
                                <option value=""></option>
                                @foreach($education as $ed)
                                    <option {{ (old('state_id') == $ed->id ? 'selected' : '') }} value="{{ $ed->id }}">{{ $ed->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Type of ID: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select Identification Type" class="select-search form-control" name="idtype" id="idtype">
                                    <option value="nin" selected>National ID</option>
                                    <option value="rin">Refugee ID</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Identification No.: <span class="text-danger">*</span></label>
                                <input value="{{ old('nin') }}" required class="form-control" placeholder="Identification Number"
                                       name="nin" type="text">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">Upload Passport Photo:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled"
                                       data-fouc>
                                <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <h6>Residence & Origin</h6>
                <fieldset>
                    <h4>Current Residence</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">District: </label>
                            <select data-placeholder="Choose..."  name="district" id="districtid" class="select-search form-control">
                                <option value=""></option>
                                @foreach($districts as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sub County:</label>
                                <select data-placeholder="Choose..."  name="subcounty" id="subcountyid" class="select-search form-control">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Parish:</label>
                                <select data-placeholder="Choose..."  name="parish" id="parishid" class="select-search form-control">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village:</label>
                                <input value="{{ old('villagehid') }}" type="text" name="village" id="villageid" placeholder="Village Name"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <h4>Origin District</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">District: </label>
                            <select data-placeholder="Choose..."  name="districth" id="districthid" class="select-search form-control">
                                <option value=""></option>
                                @foreach($districts as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sub County:</label>
                                <select data-placeholder="Choose..."  name="subcountyh" id="subcountyhid" class="select-search form-control">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Parish:</label>
                                <select data-placeholder="Choose..."  name="parishh" id="parishhid" class="select-search form-control">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village:</label>
                                <input value="{{ old('villagehid') }}" type="text" name="villageh" id="villagehid" placeholder="Village Name"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <h4>Refugee Status</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="isrefugee">Is Refugee: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="isrefugeeid" name="isrefugee" data-fouc data-placeholder="Choose..">
                                    <option {{ (old('isrefugee') == 'No') ? 'selected' : '' }} value="No">No</option>
                                    <option {{ (old('isrefugee') == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Refugee Camp:</label>
                                <select data-placeholder="Choose..."  name="refugee_camp" id="campsid" class="select-search form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h6>Next of Kin</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('nok_fname') }}" required type="text" name="nok_fname" placeholder="First Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('nok_lname') }}" required type="text" name="nok_lname" placeholder="Last Name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone 1:</label>
                                <input value="{{ old('nok_phone') }}" type="text" name="nok_phone" class="form-control" placeholder="(0777) 777-777"
                                       data-mask="(9999) 999-999">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone 1:</label>
                                <input value="{{ old('nok_phon2') }}" type="text" name="nok_phon2" class="form-control" placeholder="(0777) 777-777"
                                       data-mask="(9999) 999-999">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Relationship: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select Identification Type" class="select-search form-control" name="nok_relationship" id="idtype">
                                    <option value="">Choose One</option>
                                    @foreach($relationships as $relationship)
                                        <option value="{{ $relationship->id }}">{{ $relationship->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address: <span class="text-danger">*</span></label>
                                <input value="{{ old('nok_address') }}" class="form-control" placeholder="Address" name="nok_address" type="text" required>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h6>Business Development Information</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Business Category: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select Business Category" class="select-search form-control"
                                        name="business_type" id="business_type">
                                    <option value="">Choose One</option>
                                    @foreach($business_types as $business_type)
                                        <option value="{{ $business_type->id }}">{{ $business_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">Business Name: <span class="text-danger">*</span></label>
                                <textarea class="form-input-styled form-control" name="business_name">{{ old('business_name') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block">Is Registered Business?: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select One" class="select-search form-control"
                                        name="registration" id="registration">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Address of Business: <span class="text-danger">*</span></label>
                                <textarea class="form-input-styled form-control" name="support_area_notes">{{ old('business_location') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Duration of Operation: <span class="text-danger">*</span></label>
                                <input value="{{ old('business_age') }}" class="form-control" placeholder="e.g 1 Year" name="business_age"
                                       type="text" required>
                            </div>
                        </div>
                    </div>
                    <h4>Business Revenue</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Current Annual Revenue: </label>
                                <input value="{{ old('revenue_now') }}" class="form-control" name="revenue_now"
                                       type="number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Do you Have Access to Financial Services: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select One" class="select-search form-control"
                                        name="financial_access" id="financial_access">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Category of Financing: </label>
                                <select data-placeholder="Select One" class="select-search form-control"
                                        name="finance_type" id="finance_type">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Male Employees: </label>
                                <input value="{{ old('male_employed') }}" class="form-control" name="male_employed"
                                       type="number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Female Employees: </label>
                                <input value="{{ old('female_employed') }}" class="form-control" name="female_employed"
                                       type="number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Do you Use the Bank: <span class="text-danger">*</span></label>
                                <select required data-placeholder="Select One" class="select-search form-control"
                                        name="use_bank" id="use_bank">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Do you Use Digitilization?: </label>
                                <select required data-placeholder="Select One" class="select-search form-control"
                                        name="digital" id="digital">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Digitilization Usage: </label>
                                <select data-placeholder="Select One" multiple class="select-search form-control"
                                        name="digital_usage[]" id="digital_usage">

                                </select>
                            </div>
                        </div>
                    </div>
                    <h4>Business Development Skills</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Type of Training Attained: <span class="text-danger">*</span></label>
                                <select data-placeholder="Select Type of Training Attained" class="select-search form-control"
                                        name="business_training" id="digital_usage" required>
                                    @foreach($business_trainings as $business_training)
                                        <option value="{{ $business_training->id }}" @if($business_training->id == 100) selected @endif>{{ $business_training->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bg_id">Who Trained You </label>
                                <textarea class="form-input-styled form-control" name="business_dev_skills">{{ old('business_dev_skills') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">What Skills Do you Requrire to Be trained in:<i>"sepatae with comma(,)":
                                        <span class="text-danger">*</span></i> </label>
                                <textarea class="form-input-styled form-control" name="business_dev_skills" required>{{ old('business_dev_skills') }}</textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on('change', '#districtid', function(){
                    var districtid = $(this).val();
                    var select = $(this).parent();

                    console.log(districtid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findSubcounty') }}",
                        data: {'id':districtid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }

                            $("#subcountyid").html(opt);
                            $('.subcountyid').append(opt);
                            //$("#subcountyid").selectpicker('refresh');
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#subcountyid', function(){
                    var subcountyid = $(this).val();
                    var select = $(this).parent();

                    console.log(subcountyid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findParish') }}",
                        data: {'id':subcountyid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }
                            $("#parishid").html("");
                            $("#parishid").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#parishid', function(){
                    var parishid = $(this).val();
                    var select = $(this).parent();

                    console.log(parishid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findVillage') }}",
                        data: {'id':parishid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }
                            $("#villageid").html("");
                            $("#villageid").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#districthid', function(){
                    var districtid = $(this).val();
                    var select = $(this).parent();

                    console.log(districtid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findSubcounty') }}",
                        data: {'id':districtid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }

                            $("#subcountyhid").html(opt);
                            $('.subcountyhid').append(opt);
                            //$("#subcountyid").selectpicker('refresh');
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#subcountyhid', function(){
                    var subcountyid = $(this).val();
                    var select = $(this).parent();

                    console.log(subcountyid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findParish') }}",
                        data: {'id':subcountyid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }
                            $("#parishhid").html("");
                            $("#parishhid").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#parishhid', function(){
                    var parishid = $(this).val();
                    var select = $(this).parent();

                    console.log(parishid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findVillage') }}",
                        data: {'id':parishid},
                        success: function(data){
                            console.log(data);
                            opt += '<option value=""> Choose One</option>';
                            for (var i = 0; i < data.length; i++) {
                                opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                            }
                            $("#villagehid").html("");
                            $("#villagehid").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#isrefugeeid', function(){
                    var isrefugeeid = $(this).val();
                    var select = $(this).parent();

                    console.log(isrefugeeid);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findCamps') }}",
                        data: {'id':isrefugeeid},
                        success: function(data){
                            console.log(data);
                            if(isrefugeeid == "Yes") {
                                opt += '<option value=""> Choose One</option>';
                                for (var i = 0; i < data.length; i++) {
                                    opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                                }
                            }
                            $("#campsid").html("");
                            $("#campsid").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#financial_access', function(){
                    var financial_access = $(this).val();
                    var select = $(this).parent();

                    console.log(financial_access);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findFinanceType') }}",
                        data: {'id':financial_access},
                        success: function(data){
                            console.log(data);
                            if(financial_access == "Yes") {
                                opt += '<option value=""> Choose One</option>';
                                for (var i = 0; i < data.length; i++) {
                                    opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                                }
                            }
                            $("#finance_type").html("");
                            $("#finance_type").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

                $(document).on('change', '#digital', function(){
                    var digital = $(this).val();
                    var select = $(this).parent();

                    console.log(digital);
                    var opt = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('/findDigitalUsage') }}",
                        data: {'id':digital},
                        success: function(data){
                            console.log(data);
                            if(digital == "Yes") {
                                opt += '<option value=""> Choose One</option>';
                                for (var i = 0; i < data.length; i++) {
                                    opt += '<option value="' + data[i].id + '"> ' + data[i].name + '</option>';
                                }
                            }
                            $("#digital_usage").html("");
                            $("#digital_usage").append(opt);
                        },
                        error: function(){
                            console.log('Failed');
                        }
                    });
                });

            });
        </script>
    @endsection
