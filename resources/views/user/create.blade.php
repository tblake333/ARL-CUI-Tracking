@extends('app')

@section('title', 'Create User')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')


<form action="/users" method="POST" class="create-user-form">
    <div class="input-item @error('badge_number') invalid @enderror @if( old('badge_number') ) filled  @endif">
        <div class="i">
            <i class="fas fa-id-badge"></i>
        </div>
        <div>
            <h5>Badge #</h5>
            <input name="badge_number" value="{{ old('badge_number') }}" type="text" pattern="\d+"
                required>
            @error('badge_number')
               <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="input-item @error('first_name') invalid @enderror @if( old('first_name') ) filled  @endif">
        <div class="i">
            <i class="fas fa-id-card"></i>
        </div>
        <div>
            <h5>First Name</h5>
            <input name="first_name" value="{{ old('first_name') }}" type="text" required>
            @error('first_name')
               <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="input-item @error('last_name') invalid @enderror @if( old('last_name') ) filled  @endif">
        <div class="i">
            <i class="fas fa-id-card"></i>
        </div>
        <div>
            <h5>Last Name</h5>
            <input name="last_name" value="{{ old('last_name') }}" type="text" required>
            @error('last_name')
               <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    @csrf

    <div class="button">
        <button>Create User</button>
    </div>
</form>

<div class="person">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 440.4754 348.53936">
        <metadata id="metadata65">
            <rdf:RDF>
                <cc:Work rdf:about="">
                    <dc:format>image/svg+xml</dc:format>
                    <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                    <dc:title></dc:title>
                </cc:Work>
            </rdf:RDF>
        </metadata>
        <defs id="defs63" />
        <sodipodi:namedview lock-margins="true" fit-margin-bottom="5" fit-margin-right="5" fit-margin-left="5"
            fit-margin-top="5" inkscape:current-layer="b7e1fa79-b025-4aca-abaf-9f282d3c3989"
            inkscape:window-maximized="1" inkscape:window-y="-9" inkscape:window-x="-9" inkscape:cy="242.90566"
            inkscape:cx="319.01839" inkscape:zoom="1.2865441" showgrid="false" id="namedview61"
            inkscape:window-height="1001" inkscape:window-width="1920" inkscape:pageshadow="2" inkscape:pageopacity="0"
            guidetolerance="10" gridtolerance="10" objecttolerance="10" borderopacity="1" bordercolor="#666666"
            pagecolor="#ffffff" />
        <polygon style="fill:#7efddf;fill-opacity:1"
            transform="matrix(-0.82694723,0.56227747,0.56227814,0.82694818,642.04792,-490.9727)" id="polygon36"
            fill="#a0616a" points="727.598,497.265 727.598,345.449 692.127,344.739 711.991,497.265 " />
        <polygon style="fill:#7efddf;fill-opacity:1"
            transform="matrix(-0.50607231,0.86248971,0.86249071,0.50607289,304.50186,-592.28068)" id="polygon38"
            fill="#a0616a" points="622.603,344.739 642.467,497.265 658.074,497.265 658.074,345.449 " />
        <path style="fill:#535353;fill-opacity:1;stroke-width:0.999999" id="path40" fill="#2f2e41"
            d="m 246.74178,220.30673 16.79288,-37.03072 -34.23963,-29.96066 47.05815,9.51611 20.13018,-44.1203 -74.91077,-20.923671 C 181.91676,116.61803 164.9296,146.63508 169.15578,187.12049 Z" />
        <path style="fill:#535353;fill-opacity:1;stroke-width:0.999999" id="path42" fill="#2f2e41"
            d="m 404.18778,233.19901 a 12.67411,12.674096 30.402599 0 0 19.41447,-5.16457 l 11.1874,-26.7718 a 9.82627,9.8262587 30.402599 0 0 -5.51425,-12.73911 v 0 a 9.82627,9.8262587 30.402599 0 0 -12.10134,4.15985 l -2.39907,4.08869 -20.14959,6.26061 c 8.27048,5.03109 2.80925,10.09144 -3.96738,19.77421 z" />
        <path style="fill:#535353;fill-opacity:1;stroke-width:0.999999" id="path44" fill="#2f2e41"
            d="m 320.74977,336.63661 a 12.67411,12.674096 55.786507 0 0 19.75408,3.65667 l 21.5839,-19.39134 a 9.82627,9.8262587 55.786507 0 0 0.47915,-13.87308 v 0 a 9.82627,9.8262587 55.786507 0 0 -12.71627,-1.42939 l -3.92022,2.66553 -20.88806,-2.98157 c 5.31529,8.09075 -1.78798,10.32143 -12.06118,16.16436 z" />
        <path style="stroke-width:0.999999" id="path50" fill="#6c63ff"
            d="m 176.53871,195.56512 c -3.94082,-38.72168 17.1568,-70.06104 53.55954,-96.887821 C 174.59343,87.941339 127.6863,69.717739 98.923793,35.692659 a 33.436,33.435962 30.402599 0 0 -40.66605,5.29798 l -3.89205,3.9259 -12.05997,23.35721 -0.0117,28.57109 a 33.555,33.554961 30.402599 0 0 16.4423,28.877141 z" />
        <path style="fill:#7efddf;fill-opacity:1;stroke-width:0.999999" id="path52" fill="#a0616a"
            d="m 210.83233,47.347539 31.32846,-3.16158 a 10.34738,10.347368 13.959627 0 1 10.92053,7.22527 v 0 a 10.34738,10.347368 13.959627 0 1 -11.24153,13.32744 l -29.95713,-3.97184 -88.08902,4.4193 -5.02175,-23.90967 z" />
        <path style="stroke-width:0.999999" id="path58" fill="#6c63ff"
            d="m 135.37007,79.286069 7.00295,-42.77502 -51.969907,-9.20205 a 31.94213,31.942093 30.402599 0 0 -31.94152,13.43062 v 0 z" />
        <path style="fill:#7efddf;fill-opacity:1;stroke-width:0.999999" id="path34" fill="#a0616a"
            d="m 149.74261,188.56918 28.0938,14.21994 a 10.34739,10.347378 46.568965 0 1 5.3053,11.97147 v 0 a 10.34739,10.347378 46.568965 0 1 -16.65173,5.16841 l -23.09437,-19.48987 -76.584667,-43.74928 8.65497,-22.84689 z" />
        <path inkscape:transform-center-y="21.445563" inkscape:transform-center-x="10.335942"
            style="stroke-width:0.999999" id="path54" fill="#6c63ff"
            d="M 71.059783,168.90649 98.808393,147.9687 47.532163,80.012899 v 0 a 47.95711,47.957054 52.963516 0 0 0.45009,39.857561 z" />
        <circle r="25.007" cy="27.338829" cx="28.116112" id="path898"
            style="fill:#7efddf;fill-opacity:1;stroke-width:0.521737" />
    </svg>
</div>

<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#0062A3" fill-opacity="1"
        d="M0,128L40,106.7C80,85,160,43,240,53.3C320,64,400,128,480,160C560,192,640,192,720,208C800,224,880,256,960,272C1040,288,1120,288,1200,240C1280,192,1360,96,1400,48L1440,0L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
    </path>
</svg>


@endsection
