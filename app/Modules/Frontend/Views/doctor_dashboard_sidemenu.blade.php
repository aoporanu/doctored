<div class="cont_box3">

<label>
    <h3 class="text-white">Search</h>
</label>
<div class="input-group mb-3">
    <input type="text" id="search" class="form-control searchInput bg-grey1 p-3" name="" placeholder="Patient name/ Mobile number/ Report ID">
    <div class="input-group-append"><button
            class="fa fa-search bg-grey1 search-button"></button></div>
</div>

<div>
    <ul class="list-unstyled side-menu">
        <li class="font-custom-bold h5"><a href="/doctor-calender" class="text-white">Calender</a></li>
        <hr>
        <li class="font-custom-bold h5"><a href="{{ route('doctor.consultation') }}" class="text-white">Manage Consultations</a></li>
        <hr>
        <li class="font-custom-bold h5"><a href="{{ route('doctor.manage-prescription') }}" class="text-white">Manage Prescriptions</a></li>
        <hr>
        <li class="font-custom-bold h5"><a href="{{ route('doctor.manage-reports') }}" class="text-white ">Manage Reports</a></li>
        <hr>
        <li class="font-custom-bold h5"><a href="{{ route('slot.manage') }}" class="text-white active">Manage Slots</a></li>

        @if(isset($doctorInfo['opt_clinic']) && $doctorInfo['opt_clinic']=='yes')
                  <hr>
                  <li class="font-custom-bold h5"><a href="{{ route('clinic.info') }}" class="text-green">Clinic Information</a></li>
                  @endif

    </ul>
</div>



</div>

<?php
function generateRandomString($length = 15) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
?>
