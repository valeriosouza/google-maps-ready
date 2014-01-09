<!-- Map Editing -->
<script type='text/javascript'>
  
    var json_str = '<?php echo utilsGmp::jsonEncode($this->marker_opts['icons']);?>';
    var gmpExistsIcons=eval("("+json_str+")")  ;
</script>
<div class='gmpNewMapContent'>
    <div class='gmpMapOptionsTab'>
        <ul class='gmpNewMapOptsTab nav nav-tabs'>
            <li class="active" >
                <a class='' id='gmpTabForNewMapOpts' class='gmpTabForMapOpts editform-tab-opts'   href="#gmpEditMapProperties">
                <span class="gmpIcon gmpIconSettings"></span>
                    <?php langGmp::_e("Map Properties");?>
                </a>
            </li>
            <li>
                <a class='' id='gmpTabForNewMapMarkerOpts' class='gmpTabForMapMarkerOpts editforom-tab-opts'   href="#gmpEditMapMarkers">
                    <span class="gmpIcon gmpIconMarker"></span>                
                    <?php langGmp::_e("Markers");?>
                </a>
            </li>
        </ul>
    </div>
    <div class='gmpNewMapForms'>
        <div class="gmpNewMapTabs tab-content">
         <div class="" id='newMapSubmitBtn'>
             <div class='gmpExistsMapOperations'>
                <div class='gmpMapOperationsMessages'>
                    <p class="editMapNameShowing text-info">Editing map: <span class='gmpEditingMapName text-default'></span></p>
                    <a class='btn btn-success' id='gmpUpdateEditedMap' onclick="gmpSaveEditedMap()"><?php langGmp::_e("Save Changes")?></a>
                    <a class='btn btn-danger' id='gmpCancelMapEdit' onclick="gmpCancelMapEdit()"><?php langGmp::_e("Cancel")?></a>
                    <p id="gmpSaveEditedMapMsg"></p>
                </div>
                 
             </div>
            
              
           </div>
            <div class='tab-pane active' id="gmpEditMapProperties"><form></form>
              <?php
               echo htmlGmp::formStart('addNewMap',array('attrs'=>" id='gmpEditMapForm'"));
              ?>
     
            
                <div class='gmpFormRow'>
                   <?php
                      echo htmlGmp::input('map_opts[title]',array('attrs'=>"  required='required'  id='gmpNewMap_title' class='gmpNewMap_title gmpInputLarge gmpeditMap_title gmpInputLarge'"));
                   ?>
                   <label for="gmpNewMap_title" class="gmpFormLabel">
                         <?php langGmp::_e('Map Title')?>
                   </label>
                </div>  
               <div class='gmpFormRow'>
                   <label for="gmpNewMap_description" class="gmpFormLabel">
                         <?php langGmp::_e('Map Description')?>
                   </label>
                   <br/>
                   <br/>
                   <?php
                      echo htmlGmp::textarea('map_opts[title]',array('attrs'=>" class='' id='gmpNewMap_description' "));
                   ?>

                </div> 

                <div class='gmpFormRow'>
                 <?php
                  echo htmlGmp::input('map_opts[width]',array('value'=>'600','attrs'=>"class='gmpInputSmall'  required='required'   id='gmpNewMap_width' "));
                 ?>
                  <label for="gmpNewMap_width" class="gmpFormLabel">
                         <?php langGmp::_e('Map Width')?>
                  </label>
                </div> 
                <div class='gmpFormRow'>
                 <?php 
                  echo htmlGmp::input('map_opts[height]',array('value'=>'250','attrs'=>" class='gmpInputSmall'  required='required'  id='gmpNewMap_height' "));
                 ?>
                  <label for="gmpNewMap_height" class="gmpFormLabel">
                         <?php langGmp::_e('Map Height')?>
                  </label>
                </div> 

                <div class='gmpFormRow'>
                   <?php
                     echo htmlGmp::checkboxHiddenVal('map_opts[enable_zoom_em]', array('checked'=>'1',	
											'attrs'=>" class='enable_zoom' "));
                   ?>
                   <label for="map_optsenable_zoom_check" class="gmpFormLabel">
                         <?php langGmp::_e('Enable Zoom/Control  Panel')?>
                   </label>
                </div>
                <div class='gmpFormRow'>
                   <?php
                     echo htmlGmp::checkboxHiddenVal('map_opts[enable_mouse_zoom_em]', array('checked'=>'1',"attrs"=>"class='xxx'"));
                   ?>
                   <label for="map_optsenable_mouse_zoom_check" class="gmpFormLabel">
                         <?php langGmp::_e('Enable Mouse Zoom/Control  Panel')?>
                   </label>
                </div>

               <div class='gmpFormRow'>
                   <?php


                    echo htmlGmp::selectbox('map_opts[map_zoom]',array('attrs'=>" class=' gmpMap_zoom gmpInputSmall' id='gmpMap_zoom' ",'options'=>$this->map_opts['zoom'],'value'=>8))
                   ?>
                   <label for="gmpMap_zoom" class="gmpFormLabel">
                         <?php langGmp::_e('Map Zoom')?>
                   </label>
               </div>

               <div class='gmpFormRow'>
                   <?php

                    echo htmlGmp::selectbox('map_opts[map_type]',array('attrs'=>" class='gmpMap_type gmpInputSmall' id='gmpMap_type' ",'options'=>$this->map_opts['map_type']))
                   ?>
                   <label for="gmpMap_type" class="gmpFormLabel">
                         <?php langGmp::_e('Map Type')?>
                   </label>
               </div>
               <div class='gmpFormRow'>
                   <?php
                    echo htmlGmp::selectbox('map_opts[map_language]',array('attrs'=>" class='gmpMap_language gmpInputSmall' id='gmpMap_language' ",'options'=>$this->map_opts['map_language'],'value'=>'en'));
                   ?>
                   <label for="gmpMap_language" class="gmpFormLabel">
                         <?php langGmp::_e('Map Language')?>
                   </label>
               </div>
               <div class='gmpFormRow'>
                   <?php
                    echo htmlGmp::selectbox('map_opts[map_align]',array('attrs'=>" class='gmpInputSmall' id='gmpMap_align' ",'options'=>$this->map_opts['map_align']));
                   ?>
                   <label for="gmpMap_align" class="gmpFormLabel">
                         <?php langGmp::_e('Map Align')?>
                   </label>
               </div>

               <div class='gmpFormRow'>
                   <?php
                    echo htmlGmp::radiobuttons('map_opts[display_mode]',array('options'=> $this->map_opts['display_mode'],'labeled'=>true,'labelClass'=>'gmpFormLabel','mo_br'=>false,'value'=>'map'));
                   ?>

               </div>
               <div class='gmpFormRow'>
                   <?php
                      echo htmlGmp::input('map_opts[map_margin]',array('attrs'=>" class='gmpInputSmall'  id='gmpNewMap_margin' "));
                   ?>
                   <label for="gmpNewMap_margin" class="gmpFormLabel">
                         <?php langGmp::_e('Map Margin')?>
                   </label>
                </div>  
               <div class='gmpFormRow'>
                   <?php
                      //echo htmlGmp::input('map_opts[background_color]',);
                      //echo htmlGmp::colorpicker("background_color",array('attrs'=>" class='gmpInputSmall'  id='gmpNewMap_background_color' "));
                      echo htmlGmp::colorpicker("background_color",array(
                                    'attrs'=>" class='gmpInputSmall'  id='gmp_edit_map_color'",
                                    'id'    => 'gmp_edit_map_color',
                                    'value' =>' '
                          ));

                   ?>
                   <label for="gmpNewMap_background_color" class="gmpFormLabel">
                         <?php langGmp::_e('Backgroud Color')?>
                   </label>
                </div>  
               <div class='gmpFormRow'>
                   <?php
                      echo htmlGmp::input('map_opts[border_style]',array('attrs'=>" class='gmpInputSmall'  id='gmpNewMap_border_style' "));
                   ?>
                   <label for="gmpNewMap_border_style" class="gmpFormLabel">
                         <?php langGmp::_e('Border Style')?>
                   </label>
                </div>  
               <div class='gmpFormRow'>
                   <?php
                      echo htmlGmp::input('map_opts[border_width]',array('attrs'=>" class='gmpInputSmall'  id='gmpNewMap_border_width' "));
                   ?>
                   <label for="gmpNewMap_border_width" class="gmpFormLabel">
                         <?php langGmp::_e('Border Width')?>
                   </label>
                </div>  
              
              <?php
         
                    echo htmlGmp::formEnd();
              ?>
           
            </div>
           
            
            
            
            
            <div class='tab-pane' id="gmpEditMapMarkers">
                <div class='markerOptsCon'>
            <?php
            echo htmlGmp::formStart("addMarkerForm",array('attrs'=>"id='gmpAddMarkerToEditMap'"));
               
             
            ?>
           <div class='gmpFormRow'>
              <?php
              $groupArr=array();
               foreach($this->marker_opts['groups'] as $item){
                   $groupArr[$item['id']]=$item['title'];
               }
                 echo htmlGmp::selectbox('marker_opts[group]',array('options'=>$groupArr,'value'=>'1' ,'attrs'=>' id="gmpNewMap_marker_group" class="gmpInputLarge gmpMarkerGroupSelect" '));
              ?>
              <label for="gmpNewMap_marker_group" class="gmpFormLabel">
                    <?php langGmp::_e('Group')?>
              </label>
           </div>  
           <div class='gmpFormRow'>
              <?php
                 echo htmlGmp::input('marker_opts[title]',array('attrs'=>" class='gmpInputLarge'  id='gmpNewMap_marker_title' required='required' "));
              ?>
              <label for="gmpNewMap_marker_title" class="gmpFormLabel">
                    <?php langGmp::_e('Marker Title')?>
              </label>
           </div>  
             
           <div class='gmpFormRow'>
              <label for="gmpNewMap_marker_desc" class="gmpFormLabel">
                    <?php langGmp::_e('Marker Description')?>
              </label>
               <br/>
               <br/>
              <?php
          the_editor("", $id = 'gmpEditMap_marker_desc', 
                     $prev_id = 'title',
                     $media_buttons = true, $tab_index = 1);
           
              ?>

           </div>
           <div class="gmpMarkericonOptions">
                <h3><?php langGmp::_e('Marker Icon')?></h3>
                <div class="gmpFormRow">
                    <label for="newMarkerIcon">select icon</label>
                    <div class='right'>
                    <select id="gmpSelectedIcon_edit"  class="gmpDropDownIconsSelect_edit" name="marker_opts[icon]">
                        <?php
                       $s=" selected='selected' ";   
                       foreach($this->marker_opts['icons'] as $id=>$path){

                          echo "<option value='".$id."' data-image='".$path."' $s></option>";
                          $s="";
                        }
                          ?>
                     </select>    
                    </div>    
                </div>    
                
                <div class="gmpFormRow">
                    
                    <label for="upload_image" class='right'>
                        <input id="gmpUploadIcon" class="gmpUploadIcon button" type="button" value="Upload Image" />
                       
                    </label>
                    
                    <label for=''><?php langGmp::_e('Upload your icon');?></label>
                     <div class='gmpUplRes'>
                    </div>  
                    <div class='gmpFileUpRes'>
                        <img src=''>
                    </div>     
                </div>

                   
              
                <div class="gmpEditMarkerOpts">
                    <a class="btn btn-success gmpSaveEditedMarker" id="gmpSaveEditedMarker"><?php langGmp::_e("Save Marker")?></a>                       <input type='hidden' id='gmpEditedMarkerLocalId' value='' />
                    <a class="btn btn-danger gmpCancelMarkerEditing" id="gmpCancelMarkerEditing" ><?php langGmp::_e("Cancel")?></a>  
                </div>   
             </div>
        
            <div class='gmpFormRow'>
                <label for='marker_opts[animation]'><?php langGmp::_e("Marker Animation")?></label> 
                <?php echo htmlGmp::checkboxHiddenVal("marker_opts[animation]", array('ittrs'=>' id="marker_opts_animation"'));?>
            </div> 
              <div class='gmpFormRow gmpAddressField'>
                 <label for="gmp_marker_address" class="gmpFormLabel">
                      <?php langGmp::_e('Marker Address')?>
                 </label> <span id="gmpAddressLoader"></span> <br/> 
                <small><i><?php langGmp::_e("Type address")?></i></small>
              <?php
                 echo htmlGmp::input('marker_opts[address]',
                            array('attrs'=>" class='gmpInputLarge gmp_marker_address' style='float:left' id='gmp_marker_address' "));
              ?> <span class='gmpAutocompleteArrow button gmpUp'>
                 </span>
                <div class='gmpAddressAutocomplete'>
                    <ul>
                    </ul>
                </div>    
                <div class='gmpAddrErrors'></div>
            </div> 
           <div class='gmpFormRow'>
              <label for="gmpNewMap_marker_coords" class="gmpFormLabel">
                    <?php langGmp::_e('Marker Coordinates')?>
              </label>
               <br/>
               <small class="gmplft"><?php echo langGmp::_("if your don't know coordiates, leave this fields blank");?></small>
               <div class="clearfix"></div>
               <div style=''>
              <?php
                echo langGmp::_("Lat.");
                 echo htmlGmp::input('marker_opts[coord_x]',array('attrs'=>" class='gmpInputSmall'  id='gmp_marker_coord_x' "));
                 ?>
                     </div>
               <br>
                     <div>
                     <?PHP
                 echo langGmp::_("Lng.");
                 echo htmlGmp::input('marker_opts[coord_y]',array('attrs'=>" class='gmpInputSmall'  id='gmp_marker_coord_y' "));
              ?>
                  </div>

           </div>
      
         <div class='clearfix'></div>
             
         
                <div class="gmpAddMarkerOpts">
                    <?php
                     echo htmlGmp::submit('drawMarker', 
                             array("attrs"=>'id="AddMArkerToMap" class="btn btn-primary"',
                                   'value'=>langGmp::_("Add Marker")));
                    ?>

               </div>
         <?php
         echo htmlGmp::formEnd();
         ?>
         </div> 
            </div>
        </div>   
        
        
         <!-- Map Start -->
               <div class='gmpMapContainer'>

                <div class="clearfix"></div>
                  <div class='gmpDrawedNewMapOpts'>
                     
                  </div>
                  <div class='gmpNewMapPreview' id='gmpEditMapsContainer'></div>
                 
                  
                    <div class='gmpNewMapShortcodePreview'>
                        <pre class='gmpPre'>[ready_google_maps id=21]</pre>
                    </div>    
              </div>
        
            <!-- Map End-->
           
    
       
        
       
         
           

    </div>
</div>    
<script type='text/javascript'>
    function refreshMapsList(){
        console.log('active');
    }
    jQuery(document).ready(function(){
        jQuery(".ui-tabs-nav").click(function(){
            //if(!confirm("Leave Maps tab without save?"));
            if(this.id=="gmpAllMaps" && !jQuery(this).hasClass("ui-state-active")){
                refreshMapsList();
            }else{
                
            }
        })
        jQuery("li.ui-tabs-active").each(function(){
                if(jQuery(this).hasClass('ui-state-active')&& this.id=="gmpAllMaps"){
                    refreshMapsList();
                }
           })
    })
</script>    