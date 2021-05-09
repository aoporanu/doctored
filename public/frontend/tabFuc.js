$('.breadcrumb li').on('click', function(){
    $('.breadcrumb .active').removeClass('active');
    $(this).addClass('active');
});
  
function activaTab(tab){
    console.log(tab)
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
activaTab('home');    



