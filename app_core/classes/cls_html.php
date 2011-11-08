<?php
      
    class cls_HTML {

        function __construct(){}

        public function html_label_tag($text){
           return "<label>" . $text . "</label>" . "\n";
        }

        public function html_input_text($name, $id, $class, $maxlength, $size, $value, $title, $tabindex, $disabled, $event, $required){
           return "<input type='text' name='" . $name . "' id='" . $id . "' size= '" . $size . "' class='" . $class . "' value='" . $value . "' title='" . $title . "' tabindex='" . $tabindex . "' maxlength='"  . $maxlength . "' " . $disabled . " " . $event . " " . $required . " />" . "\n";
        }

        public function html_input_hidden($name, $value){
           return "<input type='hidden' name='" . $name . "' id='" . $name . "' value='" . $value . "' />" . "\n";
        }

        public function html_textarea($rows, $cols, $name, $id, $class, $value, $tabindex, $disabled, $event, $required){
           return "<textarea rows=" . $rows . " cols=" . $cols . " name='" . $name . "' id='" . $id . "' class='" . $class . "' value='" . $value . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " " . $required . "></textarea>" . "\n";
        }

        public function html_input_password($name, $id, $class, $maxlength, $value, $title, $tabindex, $disabled, $event, $required){
           return "<input type='password' name='" . $name . "' id='" . $id . "' class='" . $class . "' value='" . $value . "' title='" . $title . "' tabindex='" . $tabindex . "' maxlength='"  . $maxlength . "' " . $disabled . " " . $event . " " . $required . " />" . "\n";
        }

        public function html_input_button($type, $name, $id, $class, $value, $tabindex, $disabled, $event){
           return "<input type='" . $type . "' name='" . $name . "' id='" . $id . "' class='" . $class . "' value='" . $value . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " />" . "\n";
        }

        public function html_form_tag($name, $action, $target, $method){
           return "<form id='" . $name . "' name='" . $name . "' action='" . $action . "' target='" . $target . "'  method='" . $method . "' >" . "\n";
        }

        public function html_form_end(){
           return "</form>" . "\n";
        }

        public function html_link_tag($text, $id, $class, $href, $target, $title, $event){
           return "<a id='" . $id . "' class='" . $class . "' href='" . $href . "' target='" . $target . "' title='" . $title . "' ". $event . " >" . $text . " </a>" . "\n";
        }
        
        public function html_img_tag($src, $id, $class, $alt, $size){
           return "<img src='" . $src . "' id='" . $id . "' class='" . $class . "' alt='" . $alt . "' " . $size . " />" . "\n";
        }

        public function html_img_link($src, $href, $target, $title, $id, $class, $alt, $size, $event){
           return "<a href='" . $href . "' target='" . $target . "' title='" . $title . "'><img src='" . $src . "' id='" . $id . "' class='" . $class . "' alt='" . $alt . "' " . $size . " " . $event . " /></a>" . "\n";
        }
        
        public function html_check($name, $class, $checked, $tabindex, $disabled, $event){
           return "<input type='checkbox' name='" . $name . "' id='" . $name . "' class='" . $class . "' tabindex='". $tabindex ."' " . $checked . " " . $disabled . " " . $event . " >" . "\n";          
        }

        public function html_input_email($name, $id, $class, $title, $maxlength, $value, $tabindex, $disabled, $event, $required){
           return "<input type='email' name='" . $name . "' id='" . $id . "' class='" . $class . "' title='".$title."' value='" . $value . "' tabindex='" . $tabindex . "' maxlength='"  . $maxlength . "' " . $disabled . " " . $event . " " . $required . " />" . "\n";
        }  
        
        public function html_input_number($name, $id, $class, $maxlength, $value, $tabindex, $disabled, $event){
           return "<input type='number' name='" . $name . "' id='" . $id . "' class='" . $class . "' value='" . $value . "' tabindex='" . $tabindex . "' maxlength='"  . $maxlength . "' " . $disabled . " " . $event . " />" . "\n";
        } 
        
        public function html_input_file($name,$accept, $id, $class, $maxlength, $value, $tabindex, $disabled, $event){
           return "<input type='file' accept='" . $accept . "' name='" . $name . "' id='" . $id . "' class='" . $class . "' value='" . $value . "' tabindex='" . $tabindex . "' maxlength='"  . $maxlength . "' " . $disabled . " " . $event . " />" . "\n";
        }  
        
        function html_select_db($name, $options = array(), $id, $class, $tabindex, $disabled, $event) {
				$html_select = "<select name='" . $name . "' id='" . $id . "' class='" . $class . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " >";
							
				foreach ($options as $option) {
					$html_select.= '<option value='.$option[0].'>'.$option[1].'</option>';
				}
				$html_select.= '</select>';
				return $html_select;
		  } 
			
		  function html_select($name, $options = array(), $id, $class, $tabindex, $disabled, $event) {
				$html_select = "<select name='" . $name . "' id='" . $id . "' class='" . $class . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " >";
							
				foreach ($options as $value => $text) {
					$html_select.= '<option value='.$value.'>'.$text.'</option>';
				}
				$html_select.= '</select>';
				return $html_select;
		  }
		  
		  function html_select_date($class, $tabindex, $disabled, $event) {
				$html_select_day = "<select name='cmb_day' id='cmb_day' class='" . $class . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " >";		
				for($i=1; $i<=31; $i++) {
					$html_select_day.= '<option value='.$i.'>'.$i.'</option>';
				}
				$html_select_day.= '</select>';
				
				$html_select_month = "<select name='cmb_month' id='cmb_month' class='" . $class . "' tabindex='" . ($tabindex + 1) . "' " . $disabled . " " . $event . " >";
				$month=array(1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Setiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre');		
				for($i=1; $i<=12; $i++) {
					$html_select_month.= '<option label='.$month[$i].' value='.$i.'>'.$month[$i].'</option>';
				}
				$html_select_month.= '</select>';
				
				$html_select_year = "<select name='cmb_year' id='cmb_year' class='" . $class . "' tabindex='" . ($tabindex + 2) . "' " . $disabled . " " . $event . " >";	
				for($i=date('Y'); $i>=(date('Y')-100); $i--) {
					$html_select_year.= '<option label='.$i.' value='.$i.'>'.$i.'</option>';
				}
				$html_select_year.= '</select>';
				
				return $html_select_year . $html_select_month . $html_select_day;
		  }  
			
		  function html_multiselect($name, $options = array(), $id, $class, $tabindex, $disabled, $event) {
				$html_select = "<select multiple name='" . $name . "' id='" . $id . "' class='" . $class . "' tabindex='" . $tabindex . "' " . $disabled . " " . $event . " >";
							
				foreach ($options as $value => $text) {
					$html_select.= '<option value='.$value.'>'.$text.'</option>';
				}
				$html_select.= '</select>';
				return $html_select;
		  }
        
        function html_js_header($file){
           return "<script src='" . $file . "' type='text/javascript'></script>" . "\n";
        }

        function html_css_header($file,$media){
           return "<link type='text/css' href='" . $file . "' rel='stylesheet' media='" . $media . "' />" . "\n";
        }
    }

?>
