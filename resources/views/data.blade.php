@extends('layouts.template')
@section('navmenu')
    @if(Gate::check('dashboard'))
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    @endif

    @if(Gate::check('master-data'))
    <li class="list-selected">Master Data</li>
    @endif

    @if(Gate::check('master-data-type'))
    <li> <a href="">Master Data Type</a></li>
    @endif

    @if(Gate::check('master-branch'))
    <li> <a href="{{route('branch')}}">Master Branch</a></li>
    @endif

    @if(Gate::check('master-cso'))
    <li> <a href="">Master CSO</a></li>
    @endif

    @if(Gate::check('master-user'))
    <li> <a href="">Master User</a></li>
    @endif

    @if(Gate::check('report'))
    <li> <a href="">Report</a></li>
    @endif
@endsection
@section('content')
<div class="container contact-clean" id="form-addMember">
    <div class="tab-content">
        <ul class="nav nav-tabs">
            @if(Gate::check('find-data-undangan'))
            <li class="nav-item">
                <a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1" aria-selected="true">Data Undangan</a>
            </li>
            @endif
            @if(Gate::check('find-data-outsite'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-2" aria-selected="true">Data Outsite</a>
            </li>
            @endif
            @if(Gate::check('find-data-therapy'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-3" aria-selected="true">Data Therapy</a>
            </li>
            @endif
            @if(Gate::check('find-mpc'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-4" aria-selected="true">MPC</a>
            </li>
            @endif
        </ul>
        <div class="tab-pane active" role="tabpanel" id="tab-1">
            @if(Gate::check('find-data-undangan'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Undangan</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keywordDataUndangan" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;" id="txt-keywordDataUndangan">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" id="btnFind-data-undangan">Search</button>
                    </div>
                    <span class="invalid-feedback">
                        <strong style="margin-left: 40px; font-size: 12pt;"></strong>
                    </span>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data undangan -->
            @if(Gate::check('add-data-undangan'))
            <form id="actionAddDataUndangan" name="frmAddDataUndangan" method="POST" action="{{ route('store_dataundangan') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Undangan</h1>
                <br>
                <div class="form-group">
                    <span>TIPE UNDANGAN</span>
                    <select id="txttype-cust-dataundangan" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE UNDANGAN"> 
                            <option value="" disabled selected>SELECT TIPE UNDANGAN</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "UNDANGAN")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div id="input-DataUndangan" class="d-none">
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input type="date" name="registration_date" class="text-uppercase form-control" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                     <div class="form-group">
                        <span>BIRTH DATE</span>
                        <input type="date" name="birth_date" class="text-uppercase form-control"required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>ADDRESS</span>
                        <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div id="Undangan-Bank" class="form-group">
                        
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="txtcountry-dataundangan" class="text-uppercase form-control" name="country" required>
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="txtbranch-dataundangan" class="text-uppercase form-control" name="branch" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-undangan')
                                    @can('all-country-data-undangan')
                                        <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                    @endcan
                                    @cannot('all-country-data-undangan')
                                        <option value="" selected disabled>SELECT YOUR OPTION</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    @endcan
                                @endcan
                                @cannot('all-branch-data-undangan')
                                    <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>


                    <!-- CSO -->
                    <div class="form-group">
                        <span>CSO</span>
                        <select id="txtcso-dataundangan" class="text-uppercase form-control" name="cso" required>
                            <optgroup label="Cso">
                                @can('all-branch-data-undangan')
                                    <option value="" disabled selected>SELECT BRANCH FIRST</option>
                                @endcan
                                @cannot('all-branch-data-undangan')
                                <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($csos as $cso)
                                        @if($cso->branch_id == Auth::user()->branch_id)
                                            <option value="{{$cso->id}}">{{$cso->name}}</option>
                                        @endif
                                    @endforeach
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <!-- Khusus untuk Indo untuk sementara -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="txtprovince-dataundangan" class="text-uppercase form-control" name="province" required>
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="txtdistrict-dataundangan" class="form-control text-uppercase" name="district"required>
                            <optgroup label="District">
                                <option disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>PHONE</span>
                        <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <button id="btn-actionAddDataUndangan" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                    </div>
                </div>
            </form>
            @endif

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-2">
            @if(Gate::check('find-data-outsite'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Outsite</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data Outsite -->
            @if(Gate::check('add-data-outsite'))
            <form id="actionAddDataOutsite" name="frmAddDataOutsite" method="POST" action="{{ route('store_dataoutsite') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Out-Site</h1>
                <br>
                <div class="form-group">
                    <span>TIPE OUT-SITE</span>
                    <select id="txttype-cust-dataoutsite" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE OUT-SITE"> 
                            <option value="" disabled selected>SELECT TIPE OUT-SITE</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "OUT-SITE")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div id="input-DataOutsite" class="d-none">
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input type="date" name="registration_date" class="text-uppercase form-control" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div id="Outsite-Location" class="form-group">
                        
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="txtcountry-dataoutsite" class="text-uppercase form-control" name="country" required>
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="txtbranch-dataoutsite" class="text-uppercase form-control" name="branch" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-outsite')
                                    @can('all-country-data-outsite')
                                        <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                    @endcan
                                    @cannot('all-country-data-outsite')
                                        <option value="" selected disabled>SELECT YOUR OPTION</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    @endcan
                                @endcan
                                @cannot('all-branch-data-outsite')
                                    <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>


                    <!-- CSO -->
                    <div class="form-group">
                        <span>CSO</span>
                        <select id="txtcso-dataoutsite" class="text-uppercase form-control" name="cso" required>
                            <optgroup label="Cso">
                                @can('all-branch-data-outsite')
                                    <option value="" disabled selected>SELECT BRANCH FIRST</option>
                                @endcan
                                @cannot('all-branch-data-outsite')
                                <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($csos as $cso)
                                        @if($cso->branch_id == Auth::user()->branch_id)
                                            <option value="{{$cso->id}}">{{$cso->name}}</option>
                                        @endif
                                    @endforeach
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <!-- Khusus untuk Indo untuk sementara -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="txtprovince-dataoutsite" class="text-uppercase form-control" name="province" required>
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="txtdistrict-dataoutsite" class="form-control text-uppercase" name="district"required>
                            <optgroup label="District">
                                <option disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>PHONE</span>
                        <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <button id="btn-actionAddDataOutsite" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                    </div>
                </div>
            </form>
            @endif

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-3">
            @if(Gate::check('find-data-therapy'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Therapy</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data Therapy -->
            @if(Gate::check('add-data-therapy'))
            <form id="actionAddDataTherapy" name="frmAddDataTherapy" method="POST" action="{{ route('store_datatherapy') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Therapy</h1>
                <br>
                <div class="form-group">
                    <span>TIPE THERAPY</span>
                    <select id="txttype-cust-datatherapy" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE THERAPY"> 
                            <option value="" disabled selected>SELECT TIPE THERAPY</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "THERAPY")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <span>REGISTRATION DATE</span>
                    <input type="date" name="registration_date" class="text-uppercase form-control" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>NAME</span>
                    <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>ADDRESS</span>
                    <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>COUNTRY</span>
                    <select id="txtcountry-datatherapy" class="text-uppercase form-control" name="country" required>
                        <optgroup label="Country">
                            @include('etc.select-country')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>BRANCH</span>
                    <select id="txtbranch-datatherapy" class="text-uppercase form-control" name="branch" required>
                        <optgroup label="Branch">
                            @can('all-branch-data-therapy')
                                @can('all-country-data-therapy')
                                    <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                @endcan
                                @cannot('all-country-data-therapy')
                                    <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                    @endforeach
                                @endcan
                            @endcan
                            @cannot('all-branch-data-therapy')
                                <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>


                <!-- CSO -->
                <div class="form-group">
                    <span>CSO</span>
                    <select id="txtcso-datatherapy" class="text-uppercase form-control" name="cso" required>
                        <optgroup label="Cso">
                            @can('all-branch-data-therapy')
                                <option value="" disabled selected>SELECT BRANCH FIRST</option>
                            @endcan
                            @cannot('all-branch-data-therapy')
                            <option value="" selected disabled>SELECT YOUR OPTION</option>
                                @foreach ($csos as $cso)
                                    @if($cso->branch_id == Auth::user()->branch_id)
                                        <option value="{{$cso->id}}">{{$cso->name}}</option>
                                    @endif
                                @endforeach
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <!-- Khusus untuk Indo untuk sementara -->
                <div class="form-group frm-group-select">
                    <span>PROVINCE</span>
                    <select id="txtprovince-datatherapy" class="text-uppercase form-control" name="province" required>
                        <optgroup label="Province">
                            @include('etc.select-province')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>DISTRICT</span>
                    <select id="txtdistrict-datatherapy" class="form-control text-uppercase" name="district"required>
                        <optgroup label="District">
                            <option disabled selected>SELECT PROVINCE FIRST</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <div class="form-group">
                    <span>PHONE</span>
                    <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <button id="btn-actionAddDataTherapy" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                </div>
            </form>
            @endif

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-4">
            @if(Gate::check('find-mpc'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find MPC</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keywordMpc" value="{{ app('request')->input('keywordMpc') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store MPC -->
            @if(Gate::check('add-mpc'))
            <form id="actionAddMpc" name="frmAddMpc" method="POST" action="{{ route('store_mpc') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add MPC</h1>
                <br>
                <div class="form-group">
                    <span>REGISTRATION DATE</span>
                    <input type="date" name="registration_date" class="text-uppercase form-control" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>MPC CODE</span>
                    <input type="text" id="txtcode-mpc" class="text-uppercase form-control" name="code" placeholder="MPC CODE" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>KTP</span>
                    <input type="number" id="txtktp-mpc" class="form-control text-uppercase" name="ktp"  placeholder="KTP" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>NAME</span>
                    <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>BIRTH DATE</span>
                    <input type="date" name="birth_date" class="text-uppercase form-control"required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>GENDER</span>
                    <select class="text-uppercase form-control" name="gender" required>
                        <optgroup label="Gender">
                            <option value="" disabled selected>SELECT GENDER</option>
                            <option value="PRIA">PRIA</option>
                            <option value="WANITA">WANITA</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>ADDRESS</span>
                    <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>COUNTRY</span>
                    <select id="txtcountry-mpc" class="text-uppercase form-control" name="country" required>
                        <optgroup label="Country">
                            @include('etc.select-country')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>BRANCH</span>
                    <select id="txtbranch-mpc" class="text-uppercase form-control" name="branch" required>
                        <optgroup label="Branch">
                            @can('all-branch-mpc')
                                @can('all-country-mpc')
                                    <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                @endcan
                                @cannot('all-country-mpc')
                                    <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                    @endforeach
                                @endcan
                            @endcan
                            @cannot('all-branch-mpc')
                                <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>


                <!-- CSO -->
                <div class="form-group">
                    <span>CSO</span>
                    <select id="txtcso-mpc" class="text-uppercase form-control" name="cso" required>
                        <optgroup label="Cso">
                            @can('all-branch-mpc')
                                <option value="" disabled selected>SELECT BRANCH FIRST</option>
                            @endcan
                            @cannot('all-branch-mpc')
                            <option value="" selected disabled>SELECT YOUR OPTION</option>
                                @foreach ($csos as $cso)
                                    @if($cso->branch_id == Auth::user()->branch_id)
                                        <option value="{{$cso->id}}">{{$cso->name}}</option>
                                    @endif
                                @endforeach
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <!-- Khusus untuk Indo untuk sementara -->
                <div class="form-group frm-group-select">
                    <span>PROVINCE</span>
                    <select id="txtprovince-mpc" class="text-uppercase form-control" name="province" required>
                        <optgroup label="Province">
                            @include('etc.select-province')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>DISTRICT</span>
                    <select id="txtdistrict-mpc" class="form-control text-uppercase" name="district"required>
                        <optgroup label="District">
                            <option disabled selected>SELECT PROVINCE FIRST</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <div class="form-group">
                    <span>PHONE</span>
                    <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <button id="btn-actionAddMpc" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

@if(Gate::check('browse-data-undangan'))

@endif

<!-- modal Find Data Undangan -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-DataUndangan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Undangan Found</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Name</b> : Budi Santoso</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Address</b> : Jl. Kelapa Muda 12</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Phone</b> : 081544468999</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Birth Date</b> : 6-June-1966</p>

                <!-- untuk table data -->
                <div class="table-responsive table table-striped">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Exchange Date</th>
                                <th>Branch</th>
                            </tr>
                        </thead>
                        <tbody name="collection">
                            <tr>
                                <td>16-July-2018</td>
                                <td>(F02) Tim Basori</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- SCRIPT SECTION -->
@section('script')

@cannot('all-country-data-undangan')
<script type="text/javascript">
    $("#txtcountry-dataundangan > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-data-outsite')
<script type="text/javascript">
    $("#txtcountry-dataoutsite > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-data-therapy')
<script type="text/javascript">
    $("#txtcountry-datatherapy > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-mpc')
<script type="text/javascript">
    $("#txtcountry-mpc > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan


<script type="text/javascript">
    $(document).ready(function () {
        /*METHOD - METHOD UMUM ATAU KESELURUHAN
        * Khusus method" PENOPANG PADA HALAMAN INI
        */

        function _(el){
            return document.getElementById(el);
        };

        // COUNTRY METHOD
        $('#txtcountry-dataundangan').change(function (e){
            var countryVal = $('#txtcountry-dataundangan').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-dataoutsite').change(function (e){
            var countryVal = $('#txtcountry-dataoutsite').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-datatherapy').change(function (e){
            var countryVal = $('#txtcountry-datatherapy').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-mpc').change(function (e){
            var countryVal = $('#txtcountry-mpc').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });

        // BRANCH METHOD
        $('#txtbranch-dataundangan').change(function (e){
            var branchVal = $('#txtbranch-dataundangan').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-dataundangan").html("");
                        $("#txtcso-dataundangan").append(csos);
                    }
                    else
                    {
                        $("#txtcso-dataundangan").html("");
                        $("#txtcso-dataundangan").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-dataoutsite').change(function (e){
            var branchVal = $('#txtbranch-dataoutsite').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-dataoutsite").html("");
                        $("#txtcso-dataoutsite").append(csos);
                    }
                    else
                    {
                        $("#txtcso-dataoutsite").html("");
                        $("#txtcso-dataoutsite").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-datatherapy').change(function (e){
            var branchVal = $('#txtbranch-datatherapy').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-datatherapy").html("");
                        $("#txtcso-datatherapy").append(csos);
                    }
                    else
                    {
                        $("#txtcso-datatherapy").html("");
                        $("#txtcso-datatherapy").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-mpc').change(function (e){
            var branchVal = $('#txtbranch-mpc').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-mpc").html("");
                        $("#txtcso-mpc").append(csos);
                    }
                    else
                    {
                        $("#txtcso-mpc").html("");
                        $("#txtcso-mpc").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });

        // PROVINCE METHOD
        $('#txtprovince-dataundangan').change(function (e) {
            $("#txtdistrict-dataundangan > optgroup").html("");
            var provinceVal = $('#txtprovince-dataundangan').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-dataundangan > optgroup").append(data);
            });
        });
        $('#txtprovince-dataoutsite').change(function (e) {
            $("#txtdistrict-dataoutsite > optgroup").html("");
            var provinceVal = $('#txtprovince-dataoutsite').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-dataoutsite > optgroup").append(data);
            });
        });
        $('#txtprovince-datatherapy').change(function (e) {
            $("#txtdistrict-datatherapy > optgroup").html("");
            var provinceVal = $('#txtprovince-datatherapy').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-datatherapy > optgroup").append(data);
            });
        });
        $('#txtprovince-mpc').change(function (e) {
            $("#txtdistrict-mpc > optgroup").html("");
            var provinceVal = $('#txtprovince-mpc').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-mpc > optgroup").append(data);
            });
        });
        /*===================================================*/


        /*METHOD - METHOD DATA UNDANGAN
        * Khusus method" undangan dari awal sampai akhir
        */
        var frmAddUndangan;

        $('#btnFind-data-undangan').click(function(e){
            e.preventDefault();
        });

        $("#txttype-cust-dataundangan").change(function (e) {
            $("#input-DataUndangan").removeClass("d-none");
            if($('#txttype-cust-dataundangan option:selected').val() == 8){//undangan id 8
                $("#Undangan-Bank").html(
                    "<span>BANK NAME</span><input list=\"bank_list\" name=\"bank_name\" class=\"text-uppercase form-control\" placeholder=\"example. BCA, CIMB, etc.\" required=\"\"><datalist id=\"bank_list\"><span class=\"invalid-feedback\"><strong></strong></span>@foreach ($banks as $bank)<option value=\"{{$bank->name}}\">@endforeach</datalist>"
                );
            }
            else{
                $("#Undangan-Bank").html("");
            }
        });

        $("#actionAddDataUndangan").on("submit", function (e) {
            e.preventDefault();
            frmAddUndangan = _("actionAddDataUndangan");
            frmAddUndangan = new FormData(frmAddUndangan);
            var URLNya = $("#actionAddDataUndangan").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerUndangan, false);
            ajax.addEventListener("load", completeHandlerUndangan, false);
            ajax.addEventListener("error", errorHandlerUndangan, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddUndangan);
        });
        function progressHandlerUndangan(event){
            document.getElementById("btn-actionAddDataUndangan").innerHTML = "UPLOADING...";
        }
        function completeHandlerUndangan(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddUndangan.keys()) {
                $("#actionAddDataUndangan").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataUndangan").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataUndangan").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddDataUndangan").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataUndangan").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataUndangan").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddUndangan.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddDataUndangan").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataUndangan").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataUndangan").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddDataUndangan").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataUndangan").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataUndangan").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
            }

            document.getElementById("btn-actionAddDataUndangan").innerHTML = "SAVE";
            console.log(event.target.responseText);
        }
        function errorHandlerUndangan(event){
            document.getElementById("btn-actionAddDataUndangan").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
        }
        /*===================================================*/


        /*METHOD - METHOD DATA OUTSITE
        * Khusus method" outsite dari awal sampai akhir
        */
        var frmAddOutsite;

        $('#btnFind-data-outsite').click(function(e){
            e.preventDefault();
        });

        $("#txttype-cust-dataoutsite").change(function (e) {
            $("#input-DataOutsite").removeClass("d-none");
            if($('#txttype-cust-dataoutsite option:selected').val() == 2 || $('#txttype-cust-dataoutsite option:selected').val() == 4){//Ms. Rumah id 2 dan CFD id 4
                $("#Outsite-Location").html(
                    "<span>LOCATION NAME</span><input list=\"location_list\" name=\"location_name\" class=\"text-uppercase form-control\" placeholder=\"example. CITRALAND, PAKUWON, etc.\" required=\"\"><datalist id=\"location_list\"><span class=\"invalid-feedback\"><strong></strong></span>@foreach ($locations as $location)<option value=\"{{$location->name}}\">@endforeach</datalist>"
                );
            }
            else{
                $("#Outsite-Location").html("");
            }
        });

        $("#actionAddDataOutsite").on("submit", function (e) {
            e.preventDefault();
            frmAddOutsite = _("actionAddDataOutsite");
            frmAddOutsite = new FormData(frmAddOutsite);
            var URLNya = $("#actionAddDataOutsite").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerOutsite, false);
            ajax.addEventListener("load", completeHandlerOutsite, false);
            ajax.addEventListener("error", errorHandlerOutsite, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddOutsite);
        });
        function progressHandlerOutsite(event){
            document.getElementById("btn-actionAddDataOutsite").innerHTML = "UPLOADING...";
        }
        function completeHandlerOutsite(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddOutsite.keys()) {
                $("#actionAddDataOutsite").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataOutsite").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataOutsite").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddDataOutsite").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataOutsite").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataOutsite").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddOutsite.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddDataOutsite").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataOutsite").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataOutsite").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddDataOutsite").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataOutsite").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataOutsite").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
            }

            document.getElementById("btn-actionAddDataOutsite").innerHTML = "SAVE";
            console.log(event.target.responseText);
        }
        function errorHandlerOutsite(event){
            document.getElementById("btn-actionAddDataOutsite").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
        }
        /*===================================================*/


        /*METHOD - METHOD DATA THERAPY
        * Khusus method" therapy dari awal sampai akhir
        */
        var frmAddTherapy;

        $('#btnFind-data-therapy').click(function(e){
            e.preventDefault();
        });

        $("#actionAddDataTherapy").on("submit", function (e) {
            e.preventDefault();
            frmAddTherapy = _("actionAddDataTherapy");
            frmAddTherapy = new FormData(frmAddTherapy);
            var URLNya = $("#actionAddDataTherapy").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerTherapy, false);
            ajax.addEventListener("load", completeHandlerTherapy, false);
            ajax.addEventListener("error", errorHandlerTherapy, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddTherapy);
        });
        function progressHandlerTherapy(event){
            document.getElementById("btn-actionAddDataTherapy").innerHTML = "UPLOADING...";
        }
        function completeHandlerTherapy(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddTherapy.keys()) {
                $("#actionAddDataTherapy").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataTherapy").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataTherapy").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddDataTherapy").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataTherapy").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataTherapy").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddTherapy.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddDataTherapy").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataTherapy").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataTherapy").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddDataTherapy").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataTherapy").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataTherapy").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
            }

            document.getElementById("btn-actionAddDataTherapy").innerHTML = "SAVE";
            console.log(event.target.responseText);
        }
        function errorHandlerTherapy(event){
            document.getElementById("btn-actionAddDataTherapy").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
        }
        /*===================================================*/


        /*METHOD - METHOD MPC
        * Khusus method" mpc dari awal sampai akhir
        */
        var frmAddMpc;

        $('#btnFind-mpc').click(function(e){
            e.preventDefault();
        });

        $("#actionAddMpc").on("submit", function (e) {
            e.preventDefault();
            frmAddMpc = _("actionAddMpc");
            frmAddMpc = new FormData(frmAddMpc);
            var URLNya = $("#actionAddMpc").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerMpc, false);
            ajax.addEventListener("load", completeHandlerMpc, false);
            ajax.addEventListener("error", errorHandlerMpc, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddMpc);
        });
        function progressHandlerMpc(event){
            document.getElementById("btn-actionAddMpc").innerHTML = "UPLOADING...";
        }
        function completeHandlerMpc(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddMpc.keys()) {
                $("#actionAddMpc").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddMpc").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddMpc").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddMpc").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddMpc").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddMpc").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddMpc.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddMpc").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddMpc").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddMpc").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddMpc").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddMpc").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddMpc").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
            }

            document.getElementById("btn-actionAddMpc").innerHTML = "SAVE";
            console.log(event.target.responseText);
        }
        function errorHandlerMpc(event){
            document.getElementById("btn-actionAddMpc").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
        }
        /*===================================================*/
    });
</script>
@endsection
