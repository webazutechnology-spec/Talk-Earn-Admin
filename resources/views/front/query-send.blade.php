@extends('front.layouts.app')

@section('content')
    
<style>
	.tabs { 
		display: flex; 
		background: #f8f9fa; 
		border-radius: 36px; 
		border: 0.2px solid #439f58;
	}
	.tab-btn { 
		flex: 1; 
		padding: 15px; 
		text-align: 
		center; 
		cursor: pointer; 
		border: none; 
		background: none; 
		font-size: 1em; 
		font-weight: 500; 
		color: #666; 
		transition: all 0.3s; 
	}
	.tab-btn.active { 
		color: #399a50;
		border: 2px solid #399a50;
		background: #399a5021;
		border-radius: 28px;
		margin: 11px;
		padding: 2px;
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}

    .car-img {
        height:500px;
    }
    
    .card .form-control {
        border: 0.2px solid #939292 !important;
        border-radius: 8px !important;
        color: black;
        height:38px ;
    }

    .card .form-select {
        border: 0.2px solid #939292 !important;
        border-radius: 8px !important;
    }
    .card .form-control:hover {
       border-color: #439f58 !important;
    }
    .check-bg:checked {
        background-color: #439f58;
        border-color: #439f58;
    }

   .role-btn {
        border-radius: 8px !important;
        background: #fff !important;
        border: 1px solid #939292 !important;
        font-weight: 400;
    }

    .btn-check:checked + .role-btn {
        background: #439f58 !important;
        color: #fff !important;
        border-color: #439f58 !important;
    }
    .black-link, 
    .black-link:hover {
      color: rgb(76, 75, 75);
      text-decoration: underline;
    }
	.tab-content { display: none; padding-top: 20px; }
	.tab-content.active { display: block; animation: fadeIn 0.3s; }

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
	}

	/* Firefox */
	input[type=number] {
	-moz-appearance: textfield;
	}
</style>

<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime">Contact us</h1>
                    <nav class="wow fadeInUp" data-wow-delay="0.25s">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                        </ol>
                    </nav>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="contact-information">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Contact Details</h3>
                    <h2 class="text-anime">Your Solar Savings Calculator</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>
        <div class="about-layout2 pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- About Image Slider Start -->
                        <div class="about-image-slider">
                            <!-- About Carousel Start -->
                            <div class="about-carousel">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <!-- About Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="about-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('assets/images/1.png') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <!-- About Slide End -->

                                        <!-- About Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="about-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('assets/images/2.png') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <!-- About Slide End -->
                                        <!-- About Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="about-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('assets/images/3.png') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <!-- About Slide End -->
                                        <!-- About Slide Start -->
                                        <div class="swiper-slide">
                                            <div class="about-image">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('assets/images/4.png') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <!-- About Slide End -->
                                    </div>
                                    
                                    <div class="about-button-prev"></div>
                                    <div class="about-button-next"></div>
                                </div>
                            </div>
                            <!-- About Carousel End -->
                        </div>
                        <!-- About Image Slider End -->
                    </div>

                    <div class="col-lg-6 card rounded-4">
                        <div class="solar-form py-3">
                            <div class="tabs">
                                <button class="tab-btn active" onclick="switchTab('residential')">Residential</button>
                                <button class="tab-btn" onclick="switchTab('commercial')">Commercial</button>
                                <button class="tab-btn" onclick="switchTab('industrial')">Industrial</button>
                            </div>
                            <!-- RESIDENTIAL TAB -->
                            <div id="residential" class="tab-content active">
                                <form id="residentialForm" action="{{route('request-store')}}" method="Post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" id=""  value="residential">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                            <label for="name" class="mb-2">Full Name <code>*</code></label>
                                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{old('name')}}">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="whatsapp_number" class="mb-2">WhatsApp number <code>*</code></label>
                                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" id="whatsapp_number" name="whatsapp_number" placeholder="e.g. 9835680912" value="{{old('whatsapp_number')}}">
                                            @error('whatsapp_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="pincode" class="mb-2" >Pin Code <code>*</code></label>
                                            <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" placeholder="e.g. 274802" value="{{old('pincode')}}">
                                            @error('pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="country" class="form-label">country <span class="text-danger">*</span></label>
                                            <select name="country" class="form-select single-select @error('country') is-invalid   @enderror" id="country" onchange="getStates(this.value)">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach ($countrie as $country)
                                                <option value="{{ $country->id }}" @selected($country->id == old('country', $country_id))>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <select name="state" class="form-select single-select @error('state') is-invalid  @enderror" id="state">
                                                <option selected disabled value="">Choose...</option>                    
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}" @selected($state->id == old('state'))>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 mb-2">
                                            <label class="mb-2">What is your average monthly bill? <img height="21" width="20" id="tooltip-info-homes" src="https://www.solarsquare.in/images/info.svg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-custom" style="cursor: pointer;" alt="Info Image" aria-label="Consider bills for the last 12 months of all electricity meters." data-bs-original-title="Consider bills for the last 12 months of all electricity meters.">
                                            </label>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <input type="radio" class="btn-check @error('bill') is-invalid @enderror" name="bill" id="bill1" value="Less than ₹1500" autocomplete="off">
                                            <label class=" btn role-btn" for="bill1">Less than ₹1500</label>

                                            <input type="radio" class="btn-check @error('bill') is-invalid @enderror" name="bill" id="bill2" value="₹1500-₹2500" autocomplete="off" >
                                            <label class="btn role-btn" for="bill2">₹1500-₹2500</label>

                                            <input type="radio" class="btn-check @error('bill') is-invalid @enderror" name="bill"  value="₹2500-₹4000" id="bill3" autocomplete="off">
                                            <label class="btn role-btn" for="bill3">₹2500-₹4000</label>
                                                                
                                            <input type="radio" class="btn-check @error('bill') is-invalid @enderror" name="bill" id="bill4" value="₹4000-₹8000" autocomplete="off">
                                            <label class="btn role-btn" for="bill4">₹4000-₹8000</label>

                                            <input type="radio" class="btn-check @error('bill') is-invalid @enderror" name="bill" id="bill5" value="more than ₹8000" autocomplete="off">
                                            <label class="btn role-btn" for="bill5">more than ₹8000</label>
                                            @error('bill')
                                             <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                    </div>
                                    <div class="form-check my-check mt-3">
                                        <input class="form-check-input check-bg" type="checkbox" id="agree1" checked >
                                        <label class="form-check-label" for="agree">
                                            I agree to kundan solar's the <a href="#" class="black-link">terms of Service</a> & <a href="#" class="black-link">privacy policy</a>
                                        </label>
                                    </div>
                                    <button type="button" class="btn-default mt-4" onclick="calculate('residential')">Submit Details</button>
                                </form>
                                <div id="residentialResults" class="results"></div>
                            </div>
                            <!-- COMMERCIAL TAB -->
                            <div id="commercial" class="tab-content">
                                <form id="commercialForm" action="{{route('request-store')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                    <input type="hidden" name="type" id="" value="commercial" >
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                          <label for="name" class="mb-2">Full Name <code>*</code></label>
                                            <input type="name" class="form-control  @error('name') is-invalid @enderror"  name="name" placeholder="Full name" value="{{old('name')}}">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="whatsapp_number" class="mb-2">WhatsApp number <code>*</code></label>
                                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" name="whatsapp_number" step="10" placeholder="e.g. 9835680912" value="{{old('whatsapp_number')}}">
                                            @error('whatsapp_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="electricity_bill" class="mb-2"> Monthly Electricity Bill <code>*</code></label>
                                            <select name="electricity_bill" id="electricity_bill" class="form-select @error('electricity_bill') is-invalid @enderror ">
                                                <option value="0-50000" @selected('0-50000' == old('electricity_bill'))>0–50,000</option>
                                                <option value="5000-2lacs" @selected('5000-2lacs' == old('electricity_bill'))>5,000–2 Lacs</option>
                                                <option value="> 2lacs" @selected('> 2lacs' == old('electricity_bill')) > > 2lacs</option>
                                            </select>
                                            @error('electricity_bill')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <label for="pincode" class="mb-2">Pin Code <code>*</code></label>
                                            <input type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" placeholder="e.g. 274802" value="{{old('pincode')}}">
                                            @error('pincode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="country" class="form-label">country <span class="text-danger">*</span></label>
                                            <select name="country" class="form-select single-select @error('country') is-invalid @enderror" id="country1" onchange="getStates(this.value)">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach ($countrie as $country)
                                                <option value="{{ $country->id }}" @selected($country->id == old('country', $country_id))>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <select name="state" class="form-select single-select @error('state') is-invalid @enderror" id="state1">
                                                <option selected disabled value="">Choose...</option>                    
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}" @selected($state->id == old('state'))>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="mb-2">AGM approval status <code>*</code></label>
                                            <select name="approval_status" class="form-select @error('approval_status') is-invalid @enderror">
                                                    <option selected disabled value="">Select Approval Status</option>
                                                    <option value="We already have AGM approval">We already have AGM approval</option>
                                                    <option value="We don't have an AGM approval yet">We don't have an AGM approval yet</option>
                                                    <option value="We want help in preparing for our AGM">We want help in preparing for our AGM</option>
                                            </select>
                                            @error('approval_status')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 mb-2">
                                            <label class="mb-2">Name of Housing Society <code>*</code></label>
                                            <div class="d-flex flex-wrap gap-2">
                                              <input type="radio" class="btn-check" name="house_name" value="Management committee member " autocomplete="off" @error('house_name') is-invalid @enderror id="house_name1">
                                                <label class=" btn role-btn" for="house_name1">
                                                   Management committee member
                                                </label>
                                                <input type="radio" class="btn-check @error('house_name') is-invalid @enderror" name="house_name" id="house_name2" value="Resident" autocomplete="off">
                                                <label class="btn role-btn" for="house_name2">Resident</label>
                                                <input type="radio" class="btn-check @error('house_name') is-invalid @enderror" name="house_name" id="house_name3" value="Builder" autocomplete="off" >
                                                <label class="btn role-btn" for="house_name3">Builder</label>

                                                <input type="radio" class="btn-check @error('house_name') is-invalid @enderror" name="house_name" value="Facility Manager" id="house_name4" autocomplete="off">
                                                <label class="btn role-btn" for="house_name4">Facility Manager</label>

                                                @error('house_name')
                                                  <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>    
                                    <div class="form-check my-check mt-3">
                                        <input class="form-check-input check-bg" type="checkbox" id="agree1" checked mb->
                                        <label class="form-check-label" for="agree">
                                            I agree to kundan solar's the <a href="#" class="black-link">terms of Service</a>& <a href="#" class="black-link">privacy policy</a>
                                        </label>
                                    </div>
                                    <button type="button" class="btn-default mt-4"  onclick="calculate('commercial')">Submit details</button>
                                </form>
                                <div id="commercialResults" class="results"></div>
                            </div>
                            <!-- INDUSTRIAL TAB -->
                            <div id="industrial" class="tab-content">
                                <form id="industrialForm" action="{{route('request-store')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                    <input type="hidden" name="type" id="" value="industrial" >
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                            <label for="name" class="mb-2">Full Name <code>*</code></label>
                                            <input type="name" class="form-control @error('name') is-invalid @enderror"  name="name"  placeholder="Full name" value="{{old('name')}}">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-12 mb-2">
                                            <label for="company_name" class="mb-2">Company Name <code>*</code></label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" placeholder="company name" value="{{old('company_name')}}">
                                            @error('company_name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="whatsapp_number" class="mb-2">WhatsApp number <code>*</code></label>
                                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" name="whatsapp_number" placeholder="e.g.6780985412" value="{{old('whatsapp_number')}}">
                                            @error('whatsapp_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="avg_bill" class="mb-2">Average Monthly Bill <code>*</code></label>
                                            <input type="text" class="form-control  @error('avg_bill') is-invalid @enderror" id="avg_bill" name="avg_bill" placeholder="" value="{{old('avg_bill')}}">
                                             @error('avg_bill')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="city" class="mb-2">City <code>*</code></label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="e.g. Lucknow" value="{{old('city')}}">
                                            @error('city')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="pincode" class="mb-2">Pin Code <code>*</code></label>
                                            <input type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" placeholder="e.g. 274802" value="{{old('pincode')}}">
                                               @error('pincode')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror 
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="country" class="form-label">country <span class="text-danger">*</span></label>
                                            <select name="country" class=" form-select single-select @error('country') is-invalid @enderror" id="country2"onchange="getStates(this.value)">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach ($countrie as $country)
                                                <option value="{{ $country->id }}" @selected($country->id == old('country', $country_id))>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <select name="state" class="form-select single-select @error('state') is-invalid @enderror" id="state2">
                                                <option selected disabled value="">Choose...</option>                    
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}" @selected($state->id == old('state'))>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                
                                    <div class="form-check my-check mt-3">
                                        <input class="form-check-input check-bg" type="checkbox" id="agree1" checked mb->
                                        <label class="form-check-label" for="agree">
                                            I agree to kundan solar's the <a href="#" class="black-link">terms of Service</a>& <a href="#" class="black-link">privacy policy</a>
                                        </label>
                                    </div>
                                   <button type="button" class="btn-default mt-4" onclick="calculate('industrial')">Submit Details</button>
                   
                                </form>
                                <div id="industrialResults" class="results"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	</div>
</div>
<!-- Solar Calculator Section End -->

@endsection

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tab).classList.add('active');
    event.target.classList.add('active');
}
  function calculate(type) {
    if (type === 'residential') {
        document.getElementById('residentialForm').submit();
    }
    else if (type === 'commercial') {
        document.getElementById('commercialForm').submit();
    }
    else if (type === 'industrial') {
        document.getElementById('industrialForm').submit();
    }
}

  $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });

    function getStates(countryId, selectedStateId = null, stateSelectId = '#state,#state1,#state2') {
            const $stateSelect = $(stateSelectId);

            $stateSelect.empty();
            $stateSelect.html('<option disabled selected>Loading...</option>');
            $stateSelect.trigger('change');
            const isSelectedValid = selectedStateId !== null && selectedStateId !== undefined && selectedStateId !== '';

            $.ajax({
                url: "{{ route('get-states', ':id') }}".replace(':id', countryId),
                method: 'GET',
                success: function(data) {

                    $stateSelect.empty();

                    if (!isSelectedValid) {
                        $stateSelect.append('<option disabled selected>Select State</option>');
                    }

                    data.forEach(function(state) {
                        const isSelected = isSelectedValid && state.id == selectedStateId;
                        const option = new Option(state.name, state.id, isSelected, isSelected);
                        $stateSelect.append(option);
                    });

                    $stateSelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    $stateSelect.empty();
                    $stateSelect.trigger('change');
                }
            });
        }

</script>
@endpush
