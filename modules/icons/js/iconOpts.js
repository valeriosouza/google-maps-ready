function gmpUploadNewIconStart(param){
    jQuery('.gmpFileUpRes img').attr('src',GMP_DATA.loader);
}
var seletcObj;
function drawNewIcon(id,path){

        var newItem = "<option value='"+id+"' data-image='"+path+"' selected='selected'></option>"
        var gmpDropDownObjItem='<li class="enabled _msddli_"><img src="'+path+'" class="fnone"><span class="ddlabel"></span><div class="clear"></div></li>';
        
        jQuery("select#gmpSelectedIcon").append(newItem);    
        jQuery("select#gmpSelectedIcon_edit").append(newItem);    
        jQuery("select#gmpDropDownIconsSelect_MarkerEdit").append(newItem);    
      
        seletcObj = {
                image:path,
                value:id, 
                disabled:false
        }

        //gmpDropDownObj.mapForm.data('dd').add(seletcObj);
        gmpDropDownObj.mapForm.data('dd').destroy();
        gmpDropDownObj.mapEditForm.data('dd').destroy();   
        gmpDropDownObj.markerEditForm.data('dd').destroy();   

        gmpDropDownObj["mapForm"]= jQuery("#gmpSelectedIcon").msDropDown({visibleRows:4,width:100});        
        gmpDropDownObj["mapEditForm"]= jQuery("#gmpSelectedIcon_edit").msDropDown({visibleRows:4});
        gmpDropDownObj["markerEditForm"]= jQuery("#gmpDropDownIconsSelect_MarkerEdit").msDropDown({visibleRows:4});
            

        gmpDropDownObj.mapEditForm.data('dd').refresh();
        gmpDropDownObj.mapForm.data('dd').refresh();
        if(gmpExistsIcons==undefined){
             gmpExistsIcons=[];
        }
        gmpExistsIcons[id] = path;
        gmpCurrentIcon=id;
}
function gmpUploadNewIconEnd(params,response){

        if(response!=undefined && !response.error){
          jQuery('.gmpFileUpRes img').attr('src',response.data.path);
              drawNewIcon(response.data.id,response.data.path);
        }

}
  var custom_uploader;
  
jQuery(document).ready(function(){
   
    
     gmpCurrentIcon = jQuery("#gmpAddMarkerToNewForm").find("#gmpSelectedIcon").val()

    jQuery("body").on("change","#gmpSelectedIcon",function(){
        gmpCurrentIcon=jQuery(this).val();
    })
    jQuery("body").on("change","#gmpSelectedIcon_edit",function(){
        gmpCurrentIcon=jQuery(this).val();
    })
  /* 
   * wp media upload
   * 
   */
  

 
 
    jQuery('.gmpUploadIcon').click(function(e) {
         e.preventDefault();
         //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
         //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
            //When a file is selected, grab the URL and set it as the text field's value
            var currentForm = jQuery(this).parents("form");

           
             
            custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            var respElem = jQuery('.gmpUplRes');
             var sendData={
                     page    :'icons',
                     action  :"saveNewIcon",
                     reqType :"ajax",
                     icon_url:attachment.url
                }
                jQuery.sendFormGmp({
                    msgElID:respElem,
                    data:sendData,
                   onSuccess:function(res){
                       if(!res.error){
                           var newItem =drawNewIcon(res.data.id,res.data.path);
                            currentForm.find(".gmpFileUpRes img").attr("src",res.data.path);
                       }else{
                           respElem.html(data.error.join(','));
                       }
                    }
                })
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 

})
