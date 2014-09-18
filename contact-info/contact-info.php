<?php
/*
Plugin Name: Contact Info Widget
Plugin URI: http://www.yakimawa.gov
Description: A contact information widget that will let you put in the contact information 
Version: 1.1
Author: Randy Bonds Jr.
Author URI: http://www.rbjdesigns.com
License: GPL2
*/
class ContactInfoWidget extends WP_Widget {
    
    /** constructor */
    function ContactInfoWidget() {
        parent::WP_Widget(false, $name = 'Contact Information');	
    }

    /** @see WP_Widget::widget this function is where the widget is rendered*/
    function widget($args, $instance) {		
        extract( $args );
        //get the variables, cleaning where needed
        $title    = apply_filters('widget_title', $instance['title']);
        $fullname = $instance['fullname'];
        $email    = $instance['contact-email'];
        $phone    = nl2br($instance['phone']);
        $hours    = nl2br($instance['office-hours']);
        $location = nl2br($instance['office-location']);
        //start actual rendering of widget data
        echo $before_widget; 
 		
 		// if they specify a title, give a title, if not we set it for them
 		if ( $title ) {
    	echo $before_title . $title . $after_title;
    }else {
    	echo $before_title . "Contact Information" . $after_title;
    }
    
    //name of the person
    if ($fullname != ""){
    	echo "<p><strong>$fullname</strong></p>";
    }
    
    //email address, making sure that it's obfuscated    
    if ($email != ""){  
    	$email = antispambot($email);          
			echo "<p><strong>Email:</strong><br/>";
			echo "<a href=\"mailto:$email\">$email</a></p>";
		}
		
		//phone number
		if ($phone != ""){ 
			echo "<p><strong>Phone:</strong><br/>$phone</p>";
		}
				
		//Office Location
		if ($location != ""){
			echo "<p><strong>Address:</strong><br/>$location</p>";
		}
		
		//Office Hours
		if ($hours != ""){
			echo "<p><strong>Office Hours:</strong><br/>$hours</p>";
		}
		
		//WP after widget cleanup
		echo $after_widget; 
    }

    /** @see WP_Widget::update  this function is where the widget is saved to the WP database*/
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['title']            = strip_tags($new_instance['title']           );
		$instance['fullname']         = strip_tags($new_instance['fullname']        );
		$instance['contact-email']    = strip_tags($new_instance['contact-email']   );
		$instance['phone']            = strip_tags($new_instance['phone']           );
		$instance['office-hours']     = strip_tags($new_instance['office-hours']    );
		$instance['office-location']  = strip_tags($new_instance['office-location'] );
   	    return $instance;
    }

    /** @see WP_Widget::form   this function renders the form that users see in Appearence -> Widgets*/
    function form($instance) {				
        //clean up those variables
        $title    = esc_attr($instance['title']           );
        $fullname = esc_attr($instance['fullname']        );
        $email    = esc_attr($instance['contact-email']   );
        $phone    = esc_attr($instance['phone']           );
        $hours    = esc_attr($instance['office-hours']    );
        $location = esc_attr($instance['office-location'] );
        ?>
        <p>
          <small><em>All fields are optional, if left blank, they will not display anything</em></small></p>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p><p>  
          <label for="<?php echo $this->get_field_id('fullname'); ?>"><?php _e('Name:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('fullname'); ?>" name="<?php echo $this->get_field_name('fullname'); ?>" type="text" value="<?php echo $fullname; ?>" />
        </p><p>
          <label for="<?php echo $this->get_field_id('contact-email'); ?>"><?php _e('Email:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('contact-email'); ?>" name="<?php echo $this->get_field_name('contact-email'); ?>" type="text" value="<?php echo $email; ?>" />
        </p><p>  
          <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:'); ?></label> 
          <textarea id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" ><?php echo $phone; ?></textarea>
        </p><p>  
          <label for="<?php echo $this->get_field_id('office-location'); ?>"><?php _e('Office Location:'); ?></label> 
          <textarea id="<?php echo $this->get_field_id('office-location'); ?>" name="<?php echo $this->get_field_name('office-location'); ?>" ><?php echo $location; ?></textarea>
        </p><p>  
          <label for="<?php echo $this->get_field_id('office-hours'); ?>"><?php _e('Office Hours: <small><em>(line breaks are preserved)</em></small>'); ?></label> 
          <textarea id="<?php echo $this->get_field_id('office-hours'); ?>" name="<?php echo $this->get_field_name('office-hours'); ?>" ><?php echo $hours; ?></textarea>
        </p>
        <?php 
    }

} // end class ContactInfoWidget

// register ContactInfoWidget widget
add_action('widgets_init', create_function('', 'return register_widget("ContactInfoWidget");'));
?>