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
                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone 2:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="" >
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
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($maritalstatuses as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">Occupation: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Choose.." class="select-search form-control" name="state_id" id="state_id">
                                <option value=""></option>
                                @foreach($occupations as $st)
                                    <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">Highest Education: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Select Highest Education" class="select-search form-control" name="lga_id" id="lga_id">
                                <option value=""></option>
                                @foreach($education as $ed)
                                    <option {{ (old('state_id') == $ed->id ? 'selected' : '') }} value="{{ $ed->id }}">{{ $ed->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">NIN: </label>
                                <input value="{{ old('address') }}" class="form-control" placeholder="NIN" name="nin" type="text">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Upload Passport Photo:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
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
                            <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($districts as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sub County:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($subcounties as $sc)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $sc->id }}">{{ $sc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Parish:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($parishes as $pr)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $pr->id }}">{{ $pr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($villages as $vl)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $vl->id }}">{{ $vl->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <h4>Origin District</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">District: </label>
                            <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($districts as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sub County:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($subcounties as $sc)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $sc->id }}">{{ $sc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Parish:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($parishes as $pr)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $pr->id }}">{{ $pr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village:</label>
                                <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($villages as $vl)
                                        <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $vl->id }}">{{ $vl->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h6>Needs & Support</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Challenge: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    @foreach($challenges as $ch)
                                        <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $ch->id }}">{{ $ch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Details about the Challenge:</label>
                                <textarea class="form-input-styled form-control" name="notes">{{ old('photo') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Area of Support: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    @foreach($support as $sp)
                                        <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $sp->id }}">{{ $sp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Details:</label>
                                <textarea class="form-input-styled form-control" name="notes">{{ old('photo') }}</textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    @endsection
