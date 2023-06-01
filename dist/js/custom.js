jQuery(document).ready(function(){

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

   

	jQuery('.pair-head').on('click', function (e) 
	 	{   
        console.log('olll');
        var obj = jQuery(this);
        if(obj.parent('.pair-box').children('.pair-body').hasClass("show-pair"))
          {
            obj.parent('.pair-box').children('.pair-body').removeClass('show-pair');
            obj.parent('.pair-box').children('.pair-body').addClass('hide-pair');
          }
          else
          {
            obj.parent('.pair-box').children('.pair-body').addClass('show-pair');
            obj.parent('.pair-box').children('.pair-body').removeClass('hide-pair');
          }
      
    });

       jQuery('.view_text').on('click', function (e) 
          {       var obj = jQuery(this);
                  obj.html('loading...');
                  var project_id = obj.attr('data-project_id');
                  jQuery.ajax({
                    url: baseurl+'/getTaskDetailField',
                    type: 'post',
                    data:{project_id:project_id},
                    success: function(response)
                    {   
                        obj.html('view text');
                        jQuery(".credentialsModalBody").html(response);
                        // jQuery("#taskproject").html(response);
                         cash("#credentialsModal").modal("show");
                    },
                });
                  //obj.parent('td').children('.text_detail').toggle();

            });

            

       

    jQuery('.get_task_detail').on('click', function (e) 
       { 

        // cash("#header-footer-slide-over-preview").modal("show");
        
         var obj = jQuery(this);
         obj.html('Loading..');
         var mode = obj.data('mode');
         var project_id = obj.data('project_id');
          jQuery.ajax({
              url: baseurl+'/getTaskDetail',
              type: 'post',
              data:{mode:mode, project_id:project_id},
              success: function(response)
              {  
                 cash("#header-footer-slide-over-preview").modal("show");
                 obj.html('Credentials');
                 jQuery(".sidebar_content").html(response);
              },
          });

     }); 

     jQuery('.update_task_status').on('click', function (e) 
       { 

        // cash("#header-footer-slide-over-preview").modal("show");
        
         var obj = jQuery(this);
         obj.html('wait..');
         var status = obj.data('status');
         var task_id = obj.data('task_id');
          jQuery.ajax({
              url: baseurl+'/developer/UpdateTaskStatus',
              type: 'post',
              data:{status:status, task_id:task_id},
              success: function(response)
              {  
                //window.location.href = baseurl+"/";
                location.reload(true);

              },
          });

     });

     jQuery('.updatePaymentStatus').on('click', function (e) 
       { 

         var obj = jQuery(this);
         //var status = obj.html();
         obj.html('wait..');
         var status = obj.data('status');
         var month = obj.data('month'); 
         var user_id = obj.data('user_id');
          jQuery.ajax({ 
              url: baseurl+'/admin/UpdatePaymentStatus',
              type: 'post',
              data:{status:status, month:month, user_id:user_id},
              success: function(response)
              {  
                 if(jQuery.trim(status) == 'Paid')
                 { 
                   console.log('if');
                   obj.html('Unpaid');
                   obj.removeClass('bg-theme-9');
                   obj.addClass('bg-theme-6');
                 }
                 else
                 { 
                   console.log('else');
                   obj.html('Paid');
                   obj.removeClass('bg-theme-6');
                   obj.addClass('bg-theme-9');
                 }
              },
          });

     });

     updateOrder = function (data)
     {

            jQuery.ajax({ 
              url: baseurl+'/admin/UpdateToDosOrder',
              type: 'post',
              data:{position:data},
              success: function(response)
              {  
                console.log(response);
              },
          });

    }

     

     jQuery('#sendchat').on('click', function (e) 
       { 

          var obj = jQuery(this);
          var task_id = obj.data('task_id');
          var chatext = jQuery("#chat_text").val();
          jQuery("#chat_text").val('');
          if(chatext == '')
          { 
            alert("Please enter some text");
            return false;
          }
          jQuery("#chatdiv").append(`<div>
                                        <div class="chat__box__text-box flex items-end float-right mb-4">
                                            <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                            ${chatext}
                                                <div class="mt-1 text-xs text-theme-22">now</div>
                                            </div>
                                            <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="${baseurl}/dist/images/profile-1.jpg">
                                            </div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>`);
          jQuery.ajax({
              url: baseurl+'/UpdateTaskDiscussion',
              type: 'post',
              data:{task_id:task_id, chatext:chatext},
              success: function(response)
              {  
                console.log(response);
                //window.location.href = baseurl+"/";
              },
          });

     });


     jQuery('.close_notification').on('click', function (e) 
       { 

          var obj = jQuery(this);
          var notification_id = obj.data('notification_id');
          jQuery.ajax({
              url: baseurl+'/UpdateNotification',
              type: 'post',
              data:{notification_id:notification_id},
              success: function(response)
              {  
                console.log(response);
                //window.location.href = baseurl+"/";
              },
          });

     });

     jQuery('.close_payment_notification').on('click', function (e) 
       { 

          var obj = jQuery(this);
          var notification_id = obj.data('notification_id');
          jQuery.ajax({
              url: baseurl+'/UpdatePaymentNotification',
              type: 'post',
              data:{notification_id:notification_id},
              success: function(response)
              {  
                console.log(response);
                //window.location.href = baseurl+"/";
              },
          });

     });

     
     /////////////////////////////////////////
     jQuery('.close_notice').on('click', function (e) 
       { 

          var obj = jQuery(this);
          var notice_id = obj.data('notice_id');
          jQuery.ajax({
              url: baseurl+'/UpdateNotice',
              type: 'post',
              data:{notice_id:notice_id},
              success: function(response)
              {  
                console.log(response);
                //window.location.href = baseurl+"/";
              },
          });

     });
     /////////////////////////////////////////

     jQuery('.delete_attachment').on('click', function (e) 
       { 

        var obj = jQuery(this);
         var attachment_id = obj.data('attachment_id');
         obj.parent('div').remove();
          jQuery.ajax({
              url: baseurl+'/admin/RemoveTaskAttachment',
              type: 'post',
              data:{attachment_id:attachment_id},
              success: function(response)
              {  
              },
          });

     });

     jQuery('.developer_filter').on('change', function (e) 
       { 
        
        window.location = baseurl+'/?developer='+jQuery(this).val();
        
       });

       jQuery('.projects_filter').on('change', function (e) 
       { 
        var obj = jQuery(this);
        var view = obj.data('view');
        var area = obj.data('area');
        if(view == 'tasks')
        {
          window.location = baseurl+'/'+area+'/completedTask/?project='+jQuery(this).val();
        }
        else
        {
          window.location = baseurl+'/admin/project/?project='+jQuery(this).val();
        }
          
        
       });
     /////////////////////////////////////////
     /////////////////////////////////////////
     jQuery('.todos_content').on('click', function (e) 
       { 
           jQuery("#todos_content").toggle();
       });
     jQuery('.task_done_content').on('click', function (e) 
       { 
           jQuery("#task_done_content").toggle();
       });
     jQuery('.task_completed_content').on('click', function (e) 
       { 
           jQuery("#task_completed_content").toggle();
       });
       jQuery('.task_onhold_content').on('click', function (e) 
       { 
           jQuery("#task_onhold_content").toggle();
       });
       


     
     $('#datatable').DataTable();

     
///////////////////////////////////////////////////////////////////
     
});


 

