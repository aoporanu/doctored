@extends('Frontend::layouts.frontend')
@section('content')
<section class="fullcont_sec">
<div class="container bg_grey">
<?php 
if(!isset($pagedata)){
echo "<h1>PAGE NOT FOUND</h1>";

}else{

    //print_r($pagedata);
   // print_r($page_elements);

?>
 
                  <div class="row">
                    <div class="col-12 text-center">
                      <h2><?php echo $pagedata->title;?></h2>
                      <hr />
                    </div>
            
                    
            
                    <div class="col-md-12">
                     <div class="row">
                     <div class="col-md-8">
                      <p>
                      <?php echo ucfirst($pagedata->description);?> 
                    
                      </p>
                        </div>
                        <div class="col-md-4">
                        <?php if(isset($pagedata->banner)){
                          echo "<img src='uploads/".$pagedata->banner."' width='250px'> ";
                      }
                      
                      ?>
                        </div>
                     </div> 
            
                    </div>
                  </div>
<?php } ?>
</div>
              </section>   
@endsection
