@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
  <header class="panel-heading">
    <h3 class="panel-title">Slots</h3>
  </header>
  <div class="panel-body">
                  
    <div class="col-sm-12 cont_box">
      <div class="row" >
        <h5>Slots Configuration  : </h5>
      </div> 
      <div class="row">
        <table>
          <tr><td>Hospital Name</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td>{{ucfirst($hospital)}}</td></tr>
          <tr><td>Duration</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td> <td>{{$slots_length[0]['startdate']}}  To {{$slots_length[0]['enddate']}} </td></tr>
        </table>
       </div>  
    </div>    
                  
    <div class="col-sm-12 cont_box">
      <div class="row" >
        <h5>Slots Information </h5>
      </div>
      <div class="row" >
        @foreach($restructure as $rskey=>$rsval)
        <div class='card' id='dayitem_' style='width:50%;border-color:#214214'>
        <div class='card-header' style='background:#e2e8df;padding:.15rem .25rem;font-weight:bold;text-align:center' >{{$rskey}} &nbsp; {{ $day = date('l ', strtotime($rskey))}}</div>
        <div class='card-body' id='dayitem_content_'  style='font-size:10px;font-weight:bold;padding:.25rem'>
        @foreach($rsval as $tkey=>$tval)
        <button id='dayitem_buton_'  style='font-size:10px;margin-left:1px;border-color:#000;width:100px;float:left' class='btn btn-default'>
       <?php  $bookingtime = explode('-',$tval['booking_time_long']); ?> 
        {{$bookingtime[0]}}<br>{{$bookingtime[1]}}
        
        </button>
        @endforeach
        </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection