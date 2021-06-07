$(document).ready(function(){
  $(".pageId a").click(function(){
    var page = $(this).attr('id');
    $("#pageNumber").val(page);
      loadServices();
      $('.service_pageno').css('opacity','1');
      if($(this).attr('id')==page){
        $('#'+page+'').css('opacity','0.3');
      } 
  });
});




$(document).ready(function(){
  $(".filters_open").click(function(){
    $(".sort_box").slideToggle();
  });

  $(".sort a").click(function(){
    $('#get_all_services').css('opacity','0.3');
    var sortService = $(this).attr('id');

    $('.preload').fadeOut(1000);
    $('#get_all_services').css('opacity','1');
    $("#dataSortName").val(sortService);
    loadServices(sortService);
  });
});



$(document).ready(function(){
  var save_title_service = $("#save_title_service");
  var save_description_service = $("#save_description_service");
  var save_text_service = $("#save_text_service");
  var service_id = $("#service_id");
  $("#saveService").click(function(){
  var formData = new FormData();
  formData.append("save_title_service", save_title_service.val());
  formData.append("save_description_service", save_description_service.val());
  formData.append("save_text_service", save_text_service.val());
  formData.append("service_id", service_id.val());
    if( ($("#file")[0].files).length!=0 ){
      $.each($("#file")[0].files, function(i, file){
        formData.append("file["+i+"]",file);
      });
    }
    $.ajax({
      method: "POST",
      url: "tosaveservice",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var service = JSON.parse(data);
        console.log(service);
        if(service.error){
          $("#save_form_error").html(service.message);
        }else{
          $("#save_form_error").html(service.error);
          $("#h1_title").html('<h1 class="page_title display-4" id="page_title">'+service['title']+'</h1>');
          $("#reviews").html('<p>'+service['long_text']+'</p>');
          $("#save_data_id").html('<h5 class="modal-title" id="exampleModalLabel">Успешно! <br>Фото будет доступно после обновления страницы.</h5>');
          
        }
      }
    });
  });
});


$(document).ready(function(){
  var title_service = $("#title_service");
  var description_service = $("#description_service");
  var text_service = $("#text_service");
  loadServices();
  $("#addService").click(function(){
  var formData = new FormData();
  formData.append("title_service", title_service.val());
  formData.append("description_service", description_service.val());
  formData.append("text_service", text_service.val());
    if( ($("#file")[0].files).length!=0 ){
      $.each($("#file")[0].files, function(i, file){
        formData.append("file["+i+"]",file);
      });
    }
    $.ajax({
      method: "POST",
      url: "toaddservice",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var services = JSON.parse(data);
        if(services.error){
          $("#img_error").html(services.message);
        }else if(services.suc){
          $('#buttonAddCar').trigger('click');
          loadServices();
        }
      }
    });
  });
});


function loadServices(){  
  var sortService = $("#dataSortName").val();
  var page = $("#pageNumber").val();
  var key = $("#keySearch").val();
  $.ajax({
    url: "getallservices",
    method: "GET",
    data: {key: key, page:page, sortService:sortService},
    success:function(data){
      var services = JSON.parse(data);
      if(services!=null){
        htmlServices = '';
        numService = "";
        for (i=0;i<services.length;i++){
          if(services[i]['reviews_num']==0){
            numService = "Отзывов пока нет";
          }else if(services[i]['reviews_num']==1){
           numService = services[i]['reviews_num']+' Отзыв'; 
         }else{ 
          numService = services[i]['reviews_num']+' Отзывов'; }
          htmlServices +=
          '<div class="row">'+
          '<div class="col-sm-4 mr-auto detail_title">'+
            '<a href="detailcar?id='+services[i]['id']+'"><h6 class="display-4">'+services[i]['title']+'</h6></a>'+
            '<p class="p_index">'+services[i]['description']+'</p>'+
          '</div>'+
          '<div class="col-sm-8">'+
            '<div class="icon_nav">'+
              '<div class="icon_box ml-auto">'+
                '<div class="icon_img" >'+
                  '<a><img src="img/icons/comments.png"></a>'+
                '</div>'+
                '<div class="icon_title">'+numService+'</div>'+
              '</div>'+
              // '<div class="icon_box ml-auto">'+
              //   '<div class="icon_img mail" >'+
              //     '<a href=""><img src="img/icons/mail.png"></a>'+
              //   '</div>'+
              //   '<div class="icon_title">Оставить заявку</div>'+
              // '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
         '<div class="row">'+
          '<div class="col-sm-12 p-0">'+
            '<div id="reviews" class="box_reviews p-3" style="display: none;"><h3>Отзывы</h3>'+
              '<p>'+services[i]['long_text']+'</p>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '<div class="row mt-5">'+
          '<div class="col-sm-7 p-0">'+
            '<a class="banner-border cars_img_left"><img src="uploads/service/'+services[i]['img_one']+'" alt=""></a>'+
            '<a class="banner-border cars_img_left"><img src="uploads/service/'+services[i]['img_two']+'" alt=""></a>'+
          '</div>'+
          '<div class="col-sm-5 p-0">'+
            '<a class="banner-border cars_img_right"><img src="uploads/service/'+services[i]['img_three']+'" alt=""></a>'+
          '</div>'+
        '</div>'+
        '<div class="hr_bottom"></div>';
        }
      }
      $("#get_all_services").html(htmlServices);
      $('html, body').animate({scrollTop : 0});
    }
  });
}


$(document).ready(function(){
var id = $("#service_reviews_id").val();
  loadReviews(id);
  $("#addreviews").click(function(){
    var reviews_id = $("#service_reviews_id");
    var review = $("#reviews_text");
    $.post("toaddreviews",{
       service_reviews_id: reviews_id.val(),
       reviews_text: review.val(),
    },function(result){
      var resulRev = JSON.parse(result);
      if(resulRev.error==2){
        $('.form_reviews').css('color','red');
         review.val("");
      }else if(resulRev.error==1){
        $('.form-control').css('border-bottom','1px solid #ff7b6a');
            setTimeout(function() {
        }, 2000);
      }else{
          $('.form_reviews').css('color','#555555');
          $('.form-control').css('border-bottom','1px solid #ced4da');
        if(resulRev.service==1){ 
         resulRev.service = resulRev.service+" Отзыв";
        $("#reviews_num").html(resulRev.service);
        }else{ 
          resulRev.service = resulRev.service+" Отзывов";
          $("#reviews_num").html(resulRev.service);
        }
        loadReviews(id);
        review.val("");
      }
    });
  });
});

function loadReviews(id){
  $.ajax({
    url: "getallreviews",
    method: "GET",
    data: {id:id},
    success:function(data){
      htmlReviews = "";
        var reviews = JSON.parse(data);
        for (i=0;i<reviews.length;i++) {
          if(reviews[i]['avatar_small']!=""){
            avatar_small = reviews[i]['avatar_small'];
          }else{
            avatar_small = "default_small.jpg";
          }
          htmlReviews+=
          '<div class="mb_review">'+
            '<div class="reviews_author">'+                                           
              '<img alt="" src="uploads/'+avatar_small+'">'+
            '</div>'+
            '<div class="reviews_body">'+
                '<h5 class="author">'+reviews[i]['name']+'</h5>'+
                '<div class="reviews_content">'+
                     '<p>'+reviews[i]['review']+'</p>'+
                '</div>'+
                '<span class="date_reviews">'+reviews[i]['data_review']+'</span>'+
            '</div>'+
          '</div>';
        }
        $("#box_reviews_result").html(htmlReviews);
      }
    });
}

function register(){
  var emailreg = $("#email_reg");
    var passwordreg = $("#password_reg");
    var repasswordreg = $("#re_password_reg");
    var namereg = $("#name_reg");
    var phonereg = $("#phone_reg");

    $.post("toregister", {
      email: emailreg.val(),
      password: passwordreg.val(),
      repassword: repasswordreg.val(),
      name: namereg.val(),
      phone: phonereg.val()
      
  }, 

  function(result){
      var resultObj = JSON.parse(result);
      if(resultObj.error=="email" || resultObj.error=="emailFalse" || resultObj.error=="emailerrore"){
        $("#reg_email_id").html(resultObj.message);
        $("#reg_email_id").fadeIn();
        setTimeout(function() {
            $('#reg_email_id').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="password"){
        $("#reg_password_id").html(resultObj.message);
        $("#reg_password_id").fadeIn();
        setTimeout(function() {
            $('#reg_password_id').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="repassword"){
        $("#reg_repassword_id").html(resultObj.message);
        $("#reg_repassword_id").fadeIn();
        setTimeout(function() {
            $('#reg_repassword_id').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="name"){
        $("#reg_name_id").html(resultObj.message);
        $("#reg_name_id").fadeIn();
        setTimeout(function() {
            $('#reg_name_id').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error==0){
        var id = resultObj.id;
        var userData = '<a type="submit" class="btn" href="logout">выход</a>'+
                       '<a type="button" class="btn reg" href="profile?id='+id+'">личный кабинет</a>';
        $("#user_box").html(userData);
        $("#success_reg").html(resultObj.message);
        $("#success_reg").fadeIn();
        $('.menu-close').trigger('click');
        $("#buttonAddCar").fadeIn();
        $(".buttonSaveCar").fadeIn();
        $('.close').trigger('click');
      }

    });
}


function login() {
  var email = $("#email_id");
  var password = $("#password_id");
  $.post("ajaxAuth.php", {
      user_email: email.val(),
      user_password: password.val()
  }, 
    function(result){
      var resultObj = JSON.parse(result);
      if(resultObj.error=="emailNull"){
        $("#error_email_id").html(resultObj.message);
        $("#error_email_id").fadeIn();
        setTimeout(function() {
            $('#error_email_id').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="passwordNull" || resultObj.error=="passwordIncorrect"){
        $("#error_password_id").html(resultObj.message);
        $("#error_password_id").fadeIn();
        setTimeout(function() {
            $('#error_password_id').fadeOut('fast');
        }, 2000);
      }else{
        var id = resultObj.id;
        var userData = '<a type="submit" class="btn" href="logout">выход</a>'+
                       '<a type="button" class="btn reg" href="profile?id='+id+'">личный кабинет</a>';
        $("#user_box").html(userData);
        $('.form_reviews').css('color','#555555');
        $("#success_alert_id").html(resultObj.message);
        $("#success_alert_id").fadeIn();
        $("#buttonAddCar").fadeIn();
        $('.menu-close').trigger('click');
        $("#buttonSaveCar").fadeIn();
        $('.close').trigger('click');
      }
    });
}




function saveUser() {
  var id = $("#user_id");
  var old_user_email = $("#old_email");
  var email = $("#email_save");
  var name = $("#name_save");
  var number = $("#number_phone");
  $.post("saveuser", {
      user_id: id.val(),
      old_email: old_user_email.val(),
      user_email: email.val(),
      user_name: name.val(),
      user_number: number.val(),
  }, 
    function(result){
      var resultObj = JSON.parse(result);
      if(resultObj.error=="emailNull" || resultObj.error=="emailerrore"){
        $("#error_email_save").html(resultObj.message);
        $("#error_email_save").fadeIn();
        setTimeout(function() {
            $('#error_email_save').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="nameFalse"){
        $("#error_name_save").html(resultObj.message);
        $("#error_name_save").fadeIn();
        setTimeout(function() {
            $('#error_name_save').fadeOut('fast');
        }, 2000);
      }else{
        $("#user_id").val(resultObj['id']);
        $("#old_email").val(resultObj['email']);
        $("#email_save").val(resultObj['email']);
        $("#name_save").val(resultObj['name']);
        $("#number_phone").val(resultObj['number_phone']);
        $("#dataUpdate").fadeIn();
        setTimeout(function() {
            $('#dataUpdate').fadeOut('fast');
        }, 2000);
      }

    });

}


function savepassword() {
  var email = $("#user_password_email");
  var oldPassword = $("#oldPassword");
  var newPassword = $("#newPassword");
  var reNewPassword = $("#reNewPassword");
  $.post("savepassword", {
      user_email: email.val(),
      old_password: oldPassword.val(),
      new_password: newPassword.val(),
      re_new_password: reNewPassword.val(),
  }, 

    function(result){
      var resultObj = JSON.parse(result);
      if(resultObj.error=="passwordNull" || resultObj.error=="passwordIncorrect"){
        $("#error_password_save").html(resultObj.message);1
        $("#error_password_save").fadeIn();
        setTimeout(function() {
            $('#error_password_save').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="newPasswordIncorrect"){
        $("#error_new_password_save").html(resultObj.message);
        $("#error_new_password_save").fadeIn();
        setTimeout(function() {
            $('#error_new_password_save').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error=="rePasswordIncorrect"){
        $("#error_re_password_save").html(resultObj.message);
        $("#error_re_password_save").fadeIn();
        setTimeout(function() {
            $('#error_re_password_save').fadeOut('fast');
        }, 2000);
      }else if(resultObj.error==0){
        $("#oldPassword").val("");
        $("#newPassword").val("");
        $("#reNewPassword").val("");
        $("#passwordUpdate").fadeIn();
        setTimeout(function() {
            $('#passwordUpdate').fadeOut('fast');
        }, 2000);
      }
    });

}



var slide_wrp = ".side-menu-wrapper"; 
var open_button = ".menu-open"; 
var close_button = ".menu-close"; 
var overlay = ".menu-overlay"; 
  $(slide_wrp).hide().css( {"right": -$(slide_wrp).outerWidth()+'px'}).delay(50).queue(function(){$(slide_wrp).show()}); 

  $(open_button).click(function(e){ 
    e.preventDefault();
    $(slide_wrp).css( {"left": "0px"}); 
    setTimeout(function(){
      $(slide_wrp).addClass('active'); 
    },50);
    $(overlay).css({"opacity":"1", "width":"100%"});
  });


  $(close_button).click(function(e){
    e.preventDefault();
    $(slide_wrp).css( {"left": -$(slide_wrp).outerWidth()+'px'});
    setTimeout(function(){
      $(slide_wrp).removeClass('active');
    },50);
    $(overlay).css({"opacity":"0", "width":"0"});
  })


