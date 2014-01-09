<div class="gmpMarkerListTable markerListConOpts tab-pane active">
    <div class='gmpMarkerListsOPerations'>
        <a class='btn btn-success' onclick="gmpRefreshMarkerList()">
            <span class='gmpIcon gmpIconRefresh'></span>
            <?php langGmp::_e("Refresh")?>
        </a>
     </div>
    <div class='gmpMTablecon'>    
        <?php
            echo @$this->tableContent;
        ?>
    </div> 
 </div>
<div class='gmpMarkerEditForm tab-pane markerListConOpts'>

        <div class='markerOptsCon'>
            <?php
            echo htmlGmp::formStart("addMarkerForm",array('attrs'=>"id='gmpEditMarkerForm'"));

            ?>
          
                <legend class='gmpFormTitle'></legend>
           <div class='gmpFormRow'>
              <?php
              $groupArr=array();
               foreach($this->marker_opts['groups'] as $item){
                   $groupArr[$item['id']]=$item['title'];
               }
                 echo htmlGmp::selectbox('marker_opts[group]',array('options'=>$groupArr,'value'=>'1' ,'attrs'=>' id="gmp_marker_group" class="gmpInputLarge gmpMarkerGroupSelect" '));
              ?>
              <label for="gmpNewMap_marker_group" class="gmpFormLabel">
                    <?php langGmp::_e('Group')?>
              </label>
           </div>  
           <div class='gmpFormRow'>
              <?php
                 echo htmlGmp::input('marker_opts[title]',array('attrs'=>" class='gmpInputLarge'  id='gmp_marker_title' required='required' "));
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
                the_editor("", $id = 'gmp_marker_desc',
                           $prev_id = 'title',
                           $media_buttons = true, $tab_index = 1);
              ?>

           </div>
            <div class="gmpMarkericonOptions">
                <h3><?php langGmp::_e('Marker Icon')?></h3>
                <div class="gmpFormRow">
                    <label for="newMarkerIcon">select icon</label>
                    <div class='right'>
                    <select id="gmpDropDownIconsSelect_MarkerEdit"  class="gmpDropDownIconsSelect_edit" name="marker_opts[icon]">
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
                        <a id="gmpUploadIcon" class="gmpUploadIcon btn btn-info" type="button" >  
                            <span class='gmpIcon gmpIconUpload'></span>
                            <?php
                                  langGmp::_e("Upload Image")
                            ?>
                        </a>
                       
                    </label>
                    
                    <label for=''><?php langGmp::_e('Upload your icon');?></label>
                     <div class='gmpUplRes'>
                    </div>  
                    <div class='gmpFileUpRes'>
                        <img src=''>
                    </div>     
                </div>
                   
             </div> 
                <div class='gmpFormRow'>
                    <label for='marker_opts[animation]'><?php langGmp::_e("Marker Animation")?></label> 
                    <?php echo htmlGmp::checkboxHiddenVal("marker_opts[edit_animation]", 
                        array('attrs'=>'  class="marker_opts_animation" '));?>
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
            
         
           <div class="gmpAddMarkerOpts gmpMarkerEditformBtns">
                  <a class='btn btn-primary' id='gmpUpdateEditedMarker'>
                      <?php echo "<span  class='gmpIcon gmpIconRefresh'></span>".
                              langGmp::_("Update Marker")."<small>(".
                              langGmp::_("Preview changes").")</small>";
                      ?>
                  </a>    
               <?php

                echo htmlGmp::button( array(
                    "attrs"=>'id="gmpSaveEditedMarkerItem" type="submit" class="btn btn-success"',
                    'value'=>langGmp::_("<span class='gmpIcon gmpIconSuccess'></span>".langGmp::_("Save Changes"))));
                echo htmlGmp::button(array(
                        'attrs'=>" type='' class='btn btn-danger' onclick='return cancelEditMarkerItem()'",
                        'value'=>"<span class='gmpIcon  gmpIconReset'></span>".langGmp::_("Cancel"))) 
               ?>
                  <div id="gmpUpdateMarkerItemMsg"></div>
               </div>
          
         <?php
         echo htmlGmp::formEnd();
         ?>
         </div> 
        <div class='gmpMapForMarkerEdit' id='gmpMapForMarkerEdit'>
            
        </div>
</div>
     