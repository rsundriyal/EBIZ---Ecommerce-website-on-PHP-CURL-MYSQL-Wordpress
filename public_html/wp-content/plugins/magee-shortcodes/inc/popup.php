<?php
global $magee_shortcodes;

?>
<div class="white-popup magee_shortcodes_container" id="magee_shortcodes_container">
  <form>
   
    <div class="magee_shortcodes_container">
    <ul class="magee_shortcodes_list">
      <?php if(is_array($magee_shortcodes )):foreach($magee_shortcodes as $key => $val){ 	
         if( is_array( $val ) && isset($val['popup_title']) && $val['popup_title']!='' ):
  ?>
      <li class="col-md-2">
       <a class='magee_shortcode_item <?php //echo $key;?>' title='<?php echo $val['popup_title'];?>' data-shortcode="<?php echo $key;?>" href="javascript:;"> <?php if( isset($val['icon']) ){?><i class="fa <?php echo $val['icon'];?>"></i> <?php }?> <?php echo str_replace(' Shortcode','',$val['popup_title']);?></a> </li>
      <?php endif;?>
      <?php } ?>
      <?php endif;?>
    </ul>
    <div class="clear"></div>
    </div>
    
    <div id="magee-shortcodes-settings">
      
      <div id="magee-shortcodes-settings-inner"></div>
      <input name="magee-shortcode" type="hidden" id="magee-shortcode" value="" />
      <input name="magee-shortcode-textarea" type="hidden" id="magee-shortcode-textarea" value="" /> 
      <div id="preview" style="display:none">
                  <div class="label preview-title">
                  <span class="magee-form-label-title">Preview</span>
                  <span class="magee-form-desc">Due to some external reasons, the preview is not shown exactly the same as reality.</span>
                  <span class="magee-preview-delete tb-close-icon"></span>
                  </div>
                  
      </div>
					
                    
      <div class="clear"></div>
    </div>
  </form>
  <div class="clear"></div>
  <div class="column-shortcode-inner hidden">
   <div id="_magee_cshortcode" class="hidden">[ms_column style="{{style}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_column]</div>
   <div class="param-item">
     <div class="form-row row">
       <div class="label"><span class="magee-form-label-title">Column Style</span>
                          <span class="magee-form-desc">Select the size of column.</span>
       </div>
       <div class="field">
          <div class="magee-form-select-field"><select name="magee_style" id="magee_style" class="magee-form-select magee-input">
                                                    <option value="1/1">1/1</option>
                                                    <option value="1/2">1/2</option>
                                                    <option value="1/3">1/3</option>
                                                    <option value="1/4">1/4</option>
                                                    <option value="1/5">1/5</option>
                                                    <option value="1/6">1/6</option>
                                                    <option value="2/3">2/3</option>
                                                    <option value="2/5">2/5</option>
                                                    <option value="3/4">3/4</option>
                                                    <option value="3/5">3/5</option>
                                                    <option value="4/5">4/5</option>
                                                    <option value="5/6">5/6</option>
                                                    </select>
          </div>
       </div>
    </div>
  </div>
  <div class="param-item">
    <div class="form-row row">
       <div class="label"><span class="magee-form-label-title"> Column Content</span>
                          <span class="magee-form-desc">Insert the column's content</span>
       </div>
       <div class="field">
                          <textarea rows="10" cols="30" name="magee_content" id="magee_content" class="magee-form-textarea magee-cinput">Column Content</textarea>
       </div>
    </div>
  </div>
  <div class="param-item">
    <div class="form-row row">
        <div class="label"><span class="magee-form-label-title">CSS Class</span>
                           <span class="magee-form-desc">Add a class to the wrapping HTML element.</span>
        </div>
        <div class="field">
                          <input type="text" class="magee-form-text magee-cinput" name="magee_class" id="magee_class" value="">
        </div>
    </div>
  </div>
  <div class="param-item">
    <div class="form-row row">
        <div class="label"><span class="magee-form-label-title">CSS ID</span>
                           <span class="magee-form-desc">Add an ID to the wrapping HTML element.</span>
        </div>
        <div class="field">
                          <input type="text" class="magee-form-text magee-cinput" name="magee_id" id="magee_id" value="">
        </div>
    </div>
  </div>
  </div> 
</div>
