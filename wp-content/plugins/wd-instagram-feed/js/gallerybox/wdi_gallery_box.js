
var isPopUpOpened = false;

function wdi_spider_createpopup(url, current_view, width, height, duration, description, lifetime, currentFeed) {

  url = url.replace(/&#038;/g, '&');
  if (isPopUpOpened) { return };
  isPopUpOpened = true;
  if (wdi_spider_hasalreadyreceivedpopup(description) || wdi_spider_isunsupporteduseragent()) {
    return;
  }

  jQuery("html").attr("style", "overflow:hidden !important;");
  jQuery("#wdi_spider_popup_loading_" + current_view).css({display: "block"});
  jQuery("#wdi_spider_popup_overlay_" + current_view).css({display: "block"});

 //  jQuery.get(url, function(data) {
 //    ;
  //  var popup = jQuery(
 //    '<div id="wdi_spider_popup_wrap" class="wdi_spider_popup_wrap" style="' + 
 //          ' width:' + width + 'px;' +
 //          ' height:' + height + 'px;' + 
 //          ' margin-top:-' + height / 2 + 'px;' + 
 //          ' margin-left: -' + width / 2 + 'px; ">' +    
 //    data + 
 //    '</div>')
  //    .hide()
  //    .appendTo("body");
      
  //  wdi_spider_showpopup(description, lifetime, popup, duration);
  // }).success(function(jqXHR, textStatus, errorThrown) {
 //    jQuery("#wdi_spider_popup_loading_" + current_view).css({display: "none !important;"});
 //  });
  ///////////////////////////////////////

  jQuery.ajax({
    type: 'POST',
    url: url,
    dataType: 'text',
    data:{
    action:'WDIGalleryBox',
    image_rows: JSON.stringify(currentFeed.parsedData),
    feed_id: currentFeed.feed_row['id'],
    feed_counter: currentFeed.feed_row['wdi_feed_counter'],
    },
    success:function(response){
      
  
    var popup = jQuery(
    '<div id="wdi_spider_popup_wrap" class="wdi_spider_popup_wrap" style="' + 
          ' width:' + width + 'px;' +
          ' height:' + height + 'px;' + 
          ' margin-top:-' + height / 2 + 'px;' + 
          ' margin-left: -' + width / 2 + 'px; ">' +    
    response + 
    '</div>')
     .hide()
     .appendTo("body");
     wdi_spider_showpopup(description, lifetime, popup, duration);
     jQuery("#wdi_spider_popup_loading_" + current_view).css({display: "none !important;"});
    }
    });
  /////////////////////////////////////////
}

function wdi_spider_showpopup(description, lifetime, popup, duration) {
  isPopUpOpened = true;
  popup.show();

  wdi_spider_receivedpopup(description, lifetime);
}

function wdi_spider_hasalreadyreceivedpopup(description) {
  if (document.cookie.indexOf(description) > -1) {
    delete document.cookie[document.cookie.indexOf(description)];
  }
  return false; 
}

function wdi_spider_receivedpopup(description, lifetime) { 
  var date = new Date(); 
  date.setDate(date.getDate() + lifetime);
  document.cookie = description + "=true;expires=" + date.toUTCString() + ";path=/"; 
}

function wdi_spider_isunsupporteduseragent() {
  return (!window.XMLHttpRequest); 
}

function wdi_spider_destroypopup(duration) {
  
  
  if (document.getElementById("wdi_spider_popup_wrap") != null) {
    wdi_comments_manager.popup_destroyed();

    if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen)) {
      if (jQuery.fullscreen.isFullScreen()) {
        jQuery.fullscreen.exit();
      }
    }
    if (typeof enable_addthis != "undefined" && enable_addthis) {
      jQuery(".at4-share-outer").hide();
    }
    setTimeout(function () {
      jQuery(".wdi_spider_popup_wrap").remove();
      jQuery(".wdi_spider_popup_loading").css({display: "none"});
      jQuery(".wdi_spider_popup_overlay").css({display: "none"});
      jQuery(document).off("keydown");
      jQuery("html").attr("style", "");
    }, 20);
  }
  isPopUpOpened = false;
  var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
  var viewportmeta = document.querySelector('meta[name="viewport"]');
  if (isMobile && viewportmeta) {
    viewportmeta.content = 'width=device-width, initial-scale=1';
  }
  var scrrr = jQuery(document).scrollTop();
  window.location.hash = "";
  jQuery(document).scrollTop(scrrr);
  clearInterval(wdi_playInterval);
}


Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
function wdi_spider_ajax_save(form_id,image_id) {

  
  wdi_comments_manager.init(image_id);
  
  
  // var post_data = {};
  // post_wdi_data["wdi_name"] = jQuery("#wdi_name").val();
  // post_wdi_data["wdi_comment"] = jQuery("#wdi_comment").val();
  // post_wdi_data["wdi_email"] = jQuery("#wdi_email").val();
  // post_wdi_data["wdi_captcha_input"] = jQuery("#wdi_captcha_input").val();
  // post_wdi_data["ajax_task"] = jQuery("#ajax_task").val();
  // post_wdi_data["image_id"] = jQuery("#image_id").val();
  // post_wdi_data["comment_id"] = jQuery("#comment_id").val();
  // // Loading.
  // jQuery("#ajax_loading").css('height', jQuery(".wdi_comments").css('height'));
  // jQuery("#opacity_div").css('width', jQuery(".wdi_comments").css('width'));
  // jQuery("#opacity_div").css('height', jQuery(".wdi_comments").css('height'));
  // jQuery("#loading_div").css('width', jQuery(".wdi_comments").css('width'));
  // jQuery("#loading_div").css('height', jQuery(".wdi_comments").css('height'));
  // document.getElementById("opacity_div").style.display = '';
  // document.getElementById("loading_div").style.display = 'table-cell';
  // jQuery.post(
  //   jQuery('#' + form_id).attr('action'),
  //   post_data,

  //   function (data) {
  //     var str = jQuery(data).find('.wdi_comments').html();
  //     jQuery('.wdi_comments').html(str);
  //   }
  // ).success(function(jqXHR, textStatus, errorThrown) {
  //   document.getElementById("opacity_div").style.display = 'none';
  //   document.getElementById("loading_div").style.display = 'none';
  //   // Update scrollbar.
  //   jQuery(".wdi_comments").mCustomScrollbar({scrollInertia: 150});
  //   // Bind comment container close function to close button.
  //   jQuery(".wdi_comments_close_btn").click(wdi_comment);
  // });

  // if (event.preventDefault) {
    // event.preventDefault();
  // }
  // else {
    // event.returnValue = false;
  // }
  return false;
}


wdi_comments_manager = {
  media_id : '',
  mediaComments :[], /*all comments*/
  load_more_count : 10, 
  commentCounter : 0,/* current comments counter*/
  currentKey : -1, /*iamge id*/
  init : function(image_id){

    if(this.currentKey != image_id){
      this.currentKey = image_id;

      this.reset_comments();
    }
    else{
      /*open close*/
      /*do nothing*/
    }
  },
  reset_comments : function(){
    jQuery('#wdi_load_more_comments').remove();
    jQuery('#wdi_added_comments').html('');
    //currentImage = wdi_data[this.currentKey];
    this.commentCounter = 0;
    this.media_id = wdi_data[this.currentKey]['id'];
    this.getAjaxComments(this.currentKey);


    //this.showComments(currentImage['comments_data']);

        
  },
  popup_destroyed : function(){
    this.media_id = '';
    this.mediaComments =[]; /*all comments*/
    this.commentCounter = 0;/* current comments counter**/
    this.currentKey = -1;

  },

  //function for dispaying comments
  showComments: function (comments,count){
    
    if(Object.size(comments)-this.commentCounter-count<0 || count===undefined){
      count = Object.size(comments)-this.commentCounter;
    }
    var counter = this.commentCounter;
    for(i=Object.size(comments)-counter-1;i>=Object.size(comments)-counter-count;i--){
      this.commentCounter++;
      var commentText = (comments[i]['text']);
      commentText = this.filterCommentText(commentText);
      var username = (comments[i]['from']['username']);
      var profile_picture = (comments[i]['from']['profile_picture']);
      var singleComment = jQuery('<div class="wdi_single_comment"></div>');
      singleComment.append(jQuery('<p class="wdi_comment_header_p"><span class="wdi_comment_header"><a target="_blank" href="//instagram.com/'+username+'"><img style="height:25px;width:25px;border-radius:25px" src="'+profile_picture+'">   '+username+'</a></span><span class="wdi_comment_date">'+wdi_front.convertUnixDate(comments[i]['created_time'])+'</span></p>'));
      singleComment.append(jQuery('<div class="wdi_comment_body_p"><span class="wdi_comment_body"><p>'+commentText+'</p></span></div>'));
      jQuery('#wdi_added_comments').prepend(singleComment);
    }
    this.updateScrollbar();
  
  },

  //function for updating scrollbar
  updateScrollbar : function (){
    var wdi_comments = jQuery('#wdi_comments');
    var wdi_added_comments = jQuery('#wdi_added_comments');
    //jQuery('#wdi_load_more_comments').remove();
    jQuery('.wdi_comments').attr('class','wdi_comments');
    jQuery('.wdi_comments').html('');
    
    /*restore load more button*/

    // if(jQuery('#wdi_load_more_comments').length===0){
    //    wdi_added_comments.prepend(jQuery('<p id="wdi_load_more_comments" class="wdi_load_more_comments">Load more</p>'));
    //   jQuery('#wdi_load_more_comments').on('click',function(){
    //     wdi_comments_manager.showComments(wdi_comments_manager.mediaComments, wdi_comments_manager.load_more_count);
    //   });
    // }

    jQuery('.wdi_comments').append(wdi_comments);
    jQuery('.wdi_comments').append(wdi_added_comments);

    if (typeof jQuery().mCustomScrollbar !== 'undefined') {
          if (jQuery.isFunction(jQuery().mCustomScrollbar)) {
            jQuery(".wdi_comments").mCustomScrollbar({scrollInertia: 250});
          }
        }
   
    ////
    jQuery('.wdi_comments_close_btn').on('click',wdi_comment);
    //binding click event for loading more commetn by ajax
    

  },
  //get recent media comments
  getAjaxComments: function (){
      var access_token = wdi_front.access_token;
      jQuery.ajax({
      type: "POST",
      url: 'https://api.instagram.com/v1/media/'+this.media_id+'/comments?access_token='+access_token,
      dataType: 'jsonp',
      success: function(response){
        if(response == '' || response == undefined || response == null){
          errorMessage = 'Network Error, please try again later :(';
          alert(errorMessage);
          return;
        }
        if(response['meta']['code']!=200){
          errorMessage = response['meta']['error_message'];
          alert(errorMessage);
          return;
        }
        
        wdi_comments_manager.mediaComments = response['data'];
        //ttt
        var currentImage = wdi_data[wdi_comments_manager.currentKey];
        currentImage['comments_data'] = response['data'];
        
        wdi_comments_manager.showComments(currentImage['comments_data'], wdi_comments_manager.load_more_count);
        wdi_comments_manager.ajax_comments_ready(response['data']);
        
      }
    });
  },
  ajax_comments_ready:function (response){
     this.createLoadMoreAndBindEvent();
  },
  createLoadMoreAndBindEvent:function(){
     jQuery('#wdi_added_comments').prepend(jQuery('<p id="wdi_load_more_comments" class="wdi_load_more_comments">load more comments</p>'));
      jQuery('.wdi_comment_container #wdi_load_more_comments').on('click',function(){
      jQuery(this).remove();
      wdi_comments_manager.showComments(wdi_comments_manager.mediaComments, wdi_comments_manager.load_more_count);
      wdi_comments_manager.createLoadMoreAndBindEvent();
    });
  },
  /*
   * Filtesrs comment text and makes it instagram like comments
   */
  filterCommentText: function(comment){
    var commentArray = comment.split(' ');
    var commStr = '';
    for(var i=0;i<commentArray.length;i++){
      switch(commentArray[i][0]){
        case '@':{
          commStr+= '<a target="blank" class="wdi_comm_text_link" href="//instagram.com/'+commentArray[i].substring(1,commentArray[i].length)+'">'+commentArray[i]+'</a> ';
          break;
        }
        case '#':{
          commStr+= '<a target="blank" class="wdi_comm_text_link" href="//instagram.com/explore/tags/'+commentArray[i].substring(1,commentArray[i].length)+'">'+commentArray[i]+'</a> ';
          break;
        }
        default:{
          commStr+=commentArray[i]+' ';
        }
      } 
    }
    commStr = commStr.substring(0,commStr.length-1);
    return commStr;
  }


}


// Submit rating.
// function wdi_spider_rate_ajax_save(form_id) {
//   var post_data = {};
//   post_wdi_data["image_id"] = jQuery("#" + form_id + " input[name='image_id']").val();
//   post_wdi_data["rate"] = jQuery("#" + form_id + " input[name='score']").val();
//   post_wdi_data["ajax_task"] = jQuery("#rate_ajax_task").val();
//   jQuery.post(
//     jQuery('#' + form_id).attr('action'),
//     post_data,

//     function (data) {
//       var str = jQuery(data).find('#' + form_id).html();
//       jQuery('#' + form_id).html(str);
//     }
//   ).success(function(jqXHR, textStatus, errorThrown) {
//   });
//   // if (event.preventDefault) {
//     // event.preventDefault();
//   // }
//   // else {
//     // event.returnValue = false;
//   // }
//   return false;
// }

// Set value by ID.
function wdi_spider_set_input_value(input_id, input_value) {
  if (document.getElementById(input_id)) {
    document.getElementById(input_id).value = input_value;
  }
}

// Submit form by ID.
function wdi_spider_form_submit(event, form_id) {
  if (document.getElementById(form_id)) {
    document.getElementById(form_id).submit();
  }
  if (event.preventDefault) {
    event.preventDefault();
  }
  else {
    event.returnValue = false;
  }
}

// Check if required field is empty.
function wdi_spider_check_required(id, name) {
  if (jQuery('#' + id).val() == '') {
    alert(name + '* ' + wdi_objectL10n.wdi_field_required);
    jQuery('#' + id).attr('style', 'border-color: #FF0000;');
    jQuery('#' + id).focus();
    return true;
  }
  else {
    return false;
  }
}

// Check Email.
function wdi_spider_check_email(id) {
  if (jQuery('#' + id).val() != '') {
    var email = jQuery('#' + id).val().replace(/^\s+|\s+$/g, '');
    if (email.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1) {
      alert(wdi_objectL10n.wdi_mail_validation);
      return true;
    }
    return false;
  }
}

// Refresh captcha.
function wdi_captcha_refresh(id) {
  if (document.getElementById(id + "_img") && document.getElementById(id + "_input")) {
    srcArr = document.getElementById(id + "_img").src.split("&r=");
    document.getElementById(id + "_img").src = srcArr[0] + '&r=' + Math.floor(Math.random() * 100);
    document.getElementById(id + "_img").style.display = "inline-block";
    document.getElementById(id + "_input").value = "";
  }
}

function wdi_play_pause($this){
  var video = $this.get(0);
  var regex = /firefox/i;
  var firefox = false;
  if(navigator.userAgent.match(regex)){
    firefox = true;
  }
  if(!firefox){
    if (!video.paused) {
     video.pause();
    }else{
       video.play();
    }
  }
  

}