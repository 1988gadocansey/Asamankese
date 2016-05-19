  
 function getSizes(im,obj)
  {
    var x_axis = obj.x1;
    var x2_axis = obj.x2;
    var y_axis = obj.y1;
    var y2_axis = obj.y2;
    var thumb_width = obj.width;
    var thumb_height = obj.height;
    if(thumb_width > 0)
      {
        if(confirm("Do you want to save image..!"))
          {
       // console.log($("#mirror").attr('src'));

            $.ajax({
              type:"GET",
              url:"ajax_image.php?t=ajax&img="+$("#mirror").attr('src')+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
              cache:false,
              success:function(rsponse)
                {

          var  rsponse = $.parseJSON(rsponse);
                          if(rsponse.error){
                              alert(rsponse.message);
                              }
                              else {
                       //var bck='background url(min_pictures/'+msg.filename+')';
                         var croppedImage=rsponse.filename;
                         $('#mirror').attr('src','');
               //$('#mirror').css('background',bck);
                         $('#mirror').attr('src',croppedImage);
              //location.reload();

                              }
                }
            });
          }
      }
    else{
      alert("Please select portion..!");
    }
  }



      $(document).ready(function() {


          $('img#mirror').imgAreaSelect({

        onSelectEnd: getSizes

    });







            $('#Upload').on('click', function(e)      {
              e.preventDefault();
              var chosenFile=$('#pic_upload_file').val() ;

    if( chosenFile != '' ||  chosenFile != undefined || chosenFile !=null || chosenFile != "undefined" || chosenFile !="null"){

      $("#file_picture_upload").ajaxForm({

        url: 'new_member_ajax_file_picture_upload.php',
        success:function(msg){
          console.log(msg);
          var  msg = $.parseJSON(msg);
          
                          if(msg.status=="error"){
                              alert(msg.message);
                              }
                              else if(msg.status=="success"){
                       //var bck='background url(min_pictures/'+msg.filename+')';
                         var bck=msg.filename;
                         //$('#mirror').css('background',bck);
                      $('#last_filename').val(msg.filename);

                         $('#mirror').attr('src',bck+"?+"+(new Date()).getTime());
                           $('#camera').hide();
     $('#picFrame').show();
     $('#save_pic_button').removeClass('disabled');


                              }
        }
      }).submit();



                }
      });





    $('#save_pic_button').on('click',function(e){
      //var confirm_pic_change=confirm("Do you want to update members picture?");
      var confirm_pic_change=true;
      if(confirm_pic_change){
        e.stopImmediatePropagation();
        e.preventDefault();

        var last_filename=$('#last_filename').val();
        $('#pic_id').val(last_filename);

          $('.close').trigger('click');
             $('#form_pic').prop('src',"");
             $('#form_pic').prop('src',last_filename+"?+"+(new Date()).getTime());
return false;
      }
    });

          $('#myModalLabel').click(function(e){
      e.preventDefault();
      $('#picFrame').hide();
      $('#camera').show();
    });

        //var currentDate=new Date();
 //        $('#date_of_birth').datepicker({
 //          viewMode : 'years'
 //        });
 //        $('#fathers_dob').datepicker({
 //          viewMode : 'years'
 //        });
 //        $('.childs_db').datepicker({
 //          viewMode : 'years'
 //        });
 //         $('#mothers_dob').datepicker({
 //          viewMode : 'years'
 //        });
 //            $('#date_of_joining_gbc').datepicker({
 //          viewMode : 'years'
 //        });

 // $('#mothers_dob').datepicker({
 //          viewMode : 'years'
 //        });

 //     $("#childs_dob0").datepicker({
 //          viewMode : 'years'
 //        });

        $('#other_value_span').css('display', 'none');

        $('#title').on('change', function(e) {
          if ($(this).val() == "Other") {
            $('#other_value_span').css('display', 'block');

          } else {
            $('#other_value_span').css('display', 'none');
          }
          if ($(this).prop('selectedIndex') <= 0) {

            $('#proceed').prop('disabled', 'disabled');
          }
        });

        //    $('#region_of_birth').on('change', function(e) {
        //   if ($(this).val() == "Other") {
        //     $('#other_value_birthregion_span').css('display', 'block');

        //   } else {
        //     $('#other_value_birthregion_span').css('display', 'none');
        //   }
        //   if ($(this).prop('selectedIndex') <= 0) {

        //     $('#proceed').prop('disabled', 'disabled');
        //   }
        // });

       // $('#hometown_region').on('change', function(e) {

       //    if ($(this).val() == "Other") {
       //      $('#other_value_hometown_region_span').css('display', 'block');

       //    } else {
       //      $('#other_value_hometown_region_span').css('display', 'none');
       //    }
       //    if ($(this).prop('selectedIndex') <= 0) {

       //      $('#proceed').prop('disabled', 'disabled');
       //    }
       //  });
        //    $('#mothers_hometown_region').on('change', function(e) {
        //   if ($(this).val() == "Other") {
        //     $('#other_value_hometown_region_m_span').css('display', 'block');

        //   } else {
        //     $('#other_value_hometown_region_m_span').css('display', 'none');
        //   }
        //   if ($(this).prop('selectedIndex') <= 0) {

        //     $('#proceed').prop('disabled', 'disabled');
        //   }
        // });
        //    $('#fathers_hometown_region').on('change', function(e) {
        //   if ($(this).val() == "Other") {
        //     $('#other_value_hometown_region_f_span').css('display', 'block');

        //   } else {
        //     $('#other_value_hometown_region_f_span').css('display', 'none');
        //   }
        //   if ($(this).prop('selectedIndex') <= 0) {

        //     $('#proceed').prop('disabled', 'disabled');
        //   }
        // });

        // $('#customary_marriage_check').on('click', function(e) {
        //   if ($(this).prop('checked')) {
        //     $("#customary_marriage_date").prop('disabled', '');
        //     $('#customary_marriage_date').datepicker({
        //       viewMode : 'years'
        //     });
        //   } else {
        //     $("#customary_marriage_date").prop('disabled', 'disabled');
        //     $('#customary_marriage_date').datepicker('remove');
        //   }
        // });

        // $('#divorce_date_check').on('click', function(e) {
        //   if ($(this).prop('checked')) {
        //     $("#divorce_date").prop('disabled', '');
        //     $("#divorce_date").prop('readonly', 'readonly')
        //     $("#divorce_date").datepicker();
        //     $('#divorce_date').datepicker({
        //       viewMode : 'years'
        //     });
        //   } else {
        //     $("#divorce_date").prop('disabled', 'disabled');
        //     $('#divorce_date').datepicker('remove');
        //   }
        // });

        // $('#separation_date_check').on('click', function(e) {
        //   if ($(this).prop('checked')) {
        //     $("#separation_date").prop('disabled', '');
        //     $('#separation_date').datepicker({
        //       viewMode : 'years'
        //     });
        //     $("#separation_date").prop('readonly', 'readonly')
        //     $("#separation_date").datepicker();
        //   } else {
        //     $("#separation_date").prop('disabled', 'disabled');
        //     $('#separation_date').datepicker('remove');
        //   }
        // });

        // $('#civil_marriage_check').on('click', function(e) {
        //   if ($(this).prop('checked')) {
        //     $("#civil_marriage_date").prop('disabled', '');
        //     $('#civil_marriage_date').datepicker({
        //       viewMode : 'years'
        //     });
        //   } else {
        //     $("#civil_marriage_date").prop('disabled', 'disabled');
        //     $('#civil_marriage_date').datepicker('remove');

        //   }
        // });

        $('#maritalas_status').on('change', function(e) {
          if ($(this).val().toLowerCase() == "married") {
            $('#customary_civil_panel').css('display', '');
            $('#if_married_panel').css('display', '');
            $('#if_married_panel input[type=checkbox]').prop('disabled', '');
          } else {
            $('#customary_civil_panel ').css('display', 'none');
            $('#if_married_panel').css('display', 'none');
            $('#if_married_panel input[type=checkbox]').prop('disabled', 'disabled');
          }

          if ($(this).val().toLowerCase() == "separated") {
            $('#separation_date_panel').css('display', '');

          } else {
            $('#separation_date_panel ').css('display', 'none');
          }

          if ($(this).val().toLowerCase() == "divorced") {
            $('#divorce_date_panel').css('display', '');
            $("#divorce_date").prop('disabled', '');
            $("#divorce_date").prop('readonly', 'readonly');
            $("#divorce_date").datepicker();

          } else {
            $('#divorce_date_panel').css('display', 'none');
          }
          if ($(this).prop('selectedIndex') <= 0) {

            $('#proceed').prop('disabled', 'disabled');
          }
        });

        $('#title').on('blur', function(e) {

          if ($(this).prop('selectedIndex') <= 0) {

            $('#proceed').prop('disabled', 'disabled');
          }

        });

        $('#other_value').on('focusout', function() {
          var otherValue = $('#other_value').val();
//          $('#title').children().last().prop('value', otherValue);
        });

        $("#add_new_member_form").validate({

          highlight : function(element, errorClass) {
            $(element).add($(element).parent()).addClass("alert alert-error");
          },

          rules : {
            title : "required",
            surname : "required",
            gender : "required",
          
            customary_marriage_date : {
              required : true,
              date : true
            },
            civil_marriage_date : {
              required : true,
              date : true
            },
            separation_date : {
              required : true,
              date : true
            },
            divorce_date : {
              required : true,
              date : true
            },
            phone_number1 : {
              digits : true,
              number : true
            },
            phone2 : {
              digits : true,
              number : true
            },

            phone3 : {
              digits : true,
              number : true
            },
            emergency_contact_number : {
              digits : true,
              number : true
            },
            business_phone : {              
              digits : true,
              number : true
            },
            email : {
              email : true
            }
          },
          messages : {

         
            surname : {
              required : "Surname is required."
            }
          }
        });

       
       

function checkFormElements(check_element){
      var checked=true;
      var elem='#'+check_element.toString();

      $(elem+' :selected').parent().each(function(){
        if($(this).prop('selectedIndex') <= 0){

          // $('#loan_taking_church_to_member_form :submit').prop('disabled','disabled');
          // $('#alertInfo').css('display','block').html("There are errors in the form! Please correct and submit again!");

         checked=false;
        }
        else {
          checked=true;
        }

      }) ;
      return checked;

      // $("table#paymentTable tr[payment_row] #amt_1").each(function(){
      //   var inputNumber=$(this).val();

      //   if(isNaN(inputNumber) || inputNumber==null || inputNumber==""  || inputNumber==0 ) {

      //     //$('#loan_taking_church_to_member_form :submit').prop('disabled','disabled');
      //     $('#alertInfo').css('display','block').html("There are errors in the form! Please correct and submit again!");
      //     checked=false;
      //   }
      // });
      // if(checked==false){
      //   alert("There are errors in the form! Please correct and submit again!");
      // }
      // return checked;


    }

        $(document).children().each(function() {

          $(this).on('blur', function() {

            if ($('#title').prop('selectedIndex') <= 0) {
              $('#proceed').prop('disabled', 'disabled ');
            } else {
              $('#proceed').prop('disabled', '');
            }
          });

        });

        $("#insertChild").on('click', function() {

          $("input[childs_name]").each(function() {
            //console.log($(this).val() + '-->23')
          });
          if ($("input[childs_name]").val() != "" && $("input[childs_dob]").val() != "") {

            var numOrgs = $("input[childs_name]").length + 1;
            var newOrg = $("#childs_panel").clone();
            newOrg.attr('id', 'childs_panel' + numOrgs);
            $(newOrg).find('input[type=text]').prop('value', '');
            $(newOrg).find('input[childs_dob]').prop('id','childs_dob'+numOrgs);

            dbb=$(newOrg).find('input[childs_dob]');
        dbb.datepicker({
              viewMode : 'years'
            });
           // console.log(dbb);
         
            var chn = newOrg.children();
            $(chn[1]).append('&nbsp;&nbsp;<button  type="button" id="removeChild' + numOrgs + '" class="btn btn-small" ><i class="icon-minus"></i>  Remove</button>');
            newOrg.insertAfter($('#childs_panel '));
            $('#removeChild' + numOrgs).live("click", function() {
              $('#childs_panel' + numOrgs).detach();
            });

          }
        });

        // $('#picArea2').on('click', function(event) {
        //   var windowSizeArray = ["width=200,height=200", "width=300,height=400,scrollbars=yes"];
        //   //var url = $(this).attr("href");
        //   var url = "reg_pic.php ";
        //   var windowName = "popUp";
        //   //$(this).attr("name");
        //   var windowSize = windowSizeArray[1];

        //   window.open(url, windowName, windowSize);

        //   event.preventDefault();

        // });
        //var formData=$("#payment_config_form").serialize();
        //var options=Array();
        //var openConfiguration=window.showModalDialog("reg_mem3.php?"+formData, formData, options);
        //var openConfiguration=window.showModalDialog("reg_pic.php?");
        // $("#payment_config_form").preventDefault();
        //var ps= $('#myModal').modal({remote:"check_dialog.php"});
        // alert(formData);
        //$("#myModal").toggle();

        $(document).on('mouseover', function() {

          if ($('#title').prop('selectedIndex') <= 0) {
            $('#proceed').prop('disabled', 'disabled ');
          } else {
            $('#proceed').prop('disabled', '');
          }

        });

        var options = {
          beforeSubmit : function() {
            var check=Array('gender','auxiliary','marital_status','mothers_state','fathers_state');
            var check_names=Array();
            check_names['gender']='Gender';
            check_names['auxiliary']='Auxiliary';
            check_names['marital_status']='Marital Status';
            check_names['mothers_state']='Mothers State';
            check_names['fathers_state']='Fathers State';
            for (var oo in check){
              var check_value=checkFormElements(check[oo]);
              console.log(checkFormElements(check[oo]));
              console.log(check[oo]);
              if(!check_value){
                
                
                $('#alertInfo').css('display','block').html('').html("Please  select "+check_names[check[oo]]);
                alert("Please  select "+check_names[check[oo]]);
                return false;

              }

            }
            if (confirm("Save New Member Record?")) {
              return true;
            } else {
              return false;
            }

          },
          url : 'add_new_member_form_action.php',
          data : {
            requestType : "ajax"
          },
          success : function(msg) {

            var msg = $.parseJSON(msg);
            if (msg.status == 'error') {
              alert("Error!!\n" + msg.message);
              $('#alertInfo').css('display', 'block');
              $('#alertInfo').html(msg.message);
              $('html, body').animate({
                scrollTop : $("#container").offset().top
              }, 2000);
            } else if (msg.status == 'success') {

          window.location.href='add_new_member_form.php';
              $(document).load('add_new_member_form.php');
//              $('#alertInfo').css('display', 'block');
              $('#alertInfo').html(msg.message);
//
             $('html, body').animate({
               scrollTop : $("#container").offset().top
             }, 2000);
             
              alert("Success!!\n" + msg.message);
                    }
          },
          failure : function() {
            alert('Sorry...failure occurred');
          }
        };

        $('#add_new_member_form').ajaxForm(options, function(event) {

        });


        });


 

   