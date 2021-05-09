@extends('Frontend::layouts.frontend') @section('content')


<div class="row cont_sec2 mrg-bot-10">
    <div class="col-sm-4 col-12">

        <div class="cont_box3 h-100">
            <div class="doc_map_box">
                <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" allowfullscreen>
                </iframe>
            </div>
            <h3>Filter your results</h3>
            <div class="doc_fil_box">
                <label>Distance</label>
                <select class="custom-select">
                    <option selected>With in 50 km</option>
                    <option value="1">With in 40 km</option>
                    <option value="2">With in 30 km</option>
                    <option value="3">With in 20 km</option>
                </select>

            </div>
            <div class="doc_fil_box">
                <label>Appointment type</label>
                <select class="custom-select">
                    <option selected>All</option>
                    <option value="1">Within 40 km</option>
                    <option value="2">Within 30 km</option>
                    <option value="3">Within 20 km</option>
                </select>
            </div>
            <div class="doc_fil_box">
                <label>Language</label>
                <select class="custom-select">
                    <option selected>English</option>
                    <option value="1">Hindi</option>
                    <option value="2">Spanish</option>
                    <option value="3">Tamil</option>
                </select>
            </div>
            <div class="cta_sec">
                <a class="btn doc_stand_cta" href="#" role="button" style="margin-top: 15px;">Search</a>
            </div>
        </div>

    </div>
    <div class="col-sm-8 col-12">
        <h5 class="heading">{{ count($result) }} results found </h5>
        <div class="mrg-bot-10">
            <?php /* <p>Sort by : <span class="badge badge-pill badge-primary sort_bage bage_green">Relevance</span>
                <span class="badge badge-pill badge-secondary norm_bad">Language</span>
                <span class="badge badge-pill badge-primary sort_bage norm_bad">Nearest</span>
                <span class="badge badge-pill badge-secondary norm_bad">Rating</span>
            </p> */ ?>
        </div>
		
        @foreach($result as $rs)
        <div class="cont_box2">
            <div class="col-sm-12 cont_box">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-xl-3 col-lg-3 hospital_pic"><img src="frontend/images/hospital.jpg" class="img-responsive" style="max-width:100%"></div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-xl-9 col-lg-9 doc_sec">
                        <h1>{{ ucfirst($rs->name) }} ({{$rs->type}})</h1>
                        <p class="doc_qual_text"><i class="fa fa-map-marker"></i><span>4.5 km</span></p>
                        <p class="doc_qual_text"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><a href="#">19 reviews</a></p>
                        <p class="doc_qual_text" style="display:inline-block;">Expert in: <span class="badge badge-pill badge-primary sort_bage norm_bad responsive1">Multispeciality</span>
                        </p>
                        <p class="doc_qual_text">Languages: <span class="badge badge-pill badge-primary sort_bage norm_bad">French</span>
                            <span class="badge badge-pill badge-primary sort_bage norm_bad">English</span>
                        </p>
                    </div>
                    @if($rs->summary!="")
                    <p class="descript">
                        {{ $rs->summary }}
                    </p>
                    <p class="descript"><a href="#">Read More</a></p>
                    @endif


                </div>
                <div class="row">
                    <div class="cta_sec col-sm-5">
					@if($rs->type=="Hospital")
                        <a class="btn doc_stand_cta" href="/hospital/profile/{{$rs->id}}" role="button">Request an appointment</a>
					@else
						<a class="btn doc_stand_cta" href="#" role="button">Request an appointment</a>
					
					@endif
					
                    </div>
                    <div class="cta_sec col-sm-4 col-md-6">
                        <a class="btn doc_stand_cta_smal" href="#" role="button"><i class="fa fa-phone"></i></a>
                        <a class="btn doc_stand_cta_smal" href="#" role="button"><i class="fa fa-user"></i></a>
                        <a class="btn doc_stand_cta_smal" href="#" role="button"><i class="fa fa-tv"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        

      <?php /*  <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        */ ?>
    </div>

</div>

<div class="fullcont_sec">
    <div class="bg_grey">
        <div class="row">
            <div class="col-sm-8">
                <h3>Why use Doctored?</h3>
                <p>
                    Ut perum sequate stempori ut velique cor maiosti onsectati assinie nditem et omnient, tem quis autatem
                    sintin re veruptam, consedCiis eostrum que et hilignatior apiditatur, officatquam fugia qui con eium harciam
                    incideni aut repe pra voluptam, quundaerata invel ipsam aut poratiatiur mo bea doluptaturem eum dolupta
                    imendaeseque siti ut atquo omnima volorecus alita ex ex eum eos eario dolupici volor sequostrum essitat

                </p>
            </div>
            <div class="col-sm-4 my-auto">
                <div class="h-35"></div>
                <button type="button" class="btn btn-signup w-75 h-25">Sign up</button>
                <div class="h-35"></div>
            </div>
        </div>


    </div>
</div>

@endsection