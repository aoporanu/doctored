
  function setSlugValue(){
    var title = $('#title').val();
    title = title.replace(/\s+/g, '-').toLowerCase();
    $('#slug').val(title);
  }

 
  function setElementValue(){
    var element_type = $('#element_type').val();
    if(element_type=="image"){
      $('#element_image').css("display","block");
      $('#element_text').css("display","none");
    }else if(element_type=="text"){
      $('#element_text').css("display","block");
      $('#element_image').css("display","none");
    }
  }

 

  function submitpageelements(){
  
   var id = $("#element_id").val();
   var page_id = $("#page_id").val();
   var element_key = $("#element_key").val();
   var element_type = $("#element_type").val();
   var element_name = $("#element_name").val();
   var element_value = $("#element_value").val();
   var elementimage = $("#elementimage").prop('files')[0];

  var fd = new FormData();

  fd.append('id',id);
  fd.append('page_id',page_id);
  fd.append('element_key',element_key);
  fd.append('element_type',element_type);
  fd.append('element_name',element_name);
  fd.append('element_value',element_value);
  fd.append('elementimage',elementimage);
        
       
    $.ajax({
      url:"create_pageelement",
      type:"post",
      data:fd,
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success:function(data){
        if(data){
          // console.log(data);
          location.reload();
        }
      },
      error:function(error){
        console.log(error);
      }
    });
  }

  function editPageElement(id){
    $.ajax({
      url:"edit_pageelement",
      data:{"id":id},
      dataType:"json",
      success:function(data){
        if(data){
         $("#element_id").val(data.id);
         $("#page_id").val(data.page_id);
         $("#element_key").val(data.element_key);
         $("#element_type").val(data.element_type);
         $("#element_name").val(data.element_name);
         if(data.element_type=="text"){
          $("#element_value").val(data.element_value);
          $('#element_text').css("display","block");
          $('#element_image').css("display","none");
         }else if(data.element_type=="image"){
          // $("#elementimage").val(data.element_value);
          $("#image").html('<img height="100%" width="100%" src="../answers/'+data.element_value+'"></img>');
          $('#element_image').css("display","block");
          $('#element_text').css("display","none");
         }
         
         
        }
      },
      error:function(error){
        console.log(error);
      }
    });
  }

  function deletePageElement(id){
    $.ajax({
      url:"delete_pageelement",
      data:{"id":id},
      success:function(data){
        location.reload();
      },
      error:function(error){
        console.log(error);
      }
    });
  }