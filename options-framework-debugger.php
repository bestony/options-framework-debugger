<?php
/*
Plugin Name: Options Framework Debugger
Plugin URI: https://wpstore.app/archives/options-framework-debugger/
Description: Options Framework Debugger Plugin for people who use Options Framework.
Version: 1.0.0
Author: Bestony
Author URI: https://wpstore.app/
*/
add_action( 'admin_menu', 'ofd_add_admin_menu' );
add_action( 'admin_init', 'ofd_settings_init' );


function ofd_add_admin_menu(  ) { 

	add_menu_page( 'Options Framework Debugger', 'OF Debugger', 'manage_options', 'options_framework_debugger', 'ofd_options_page' );

}


function ofd_settings_init(  ) { 

	register_setting( 'pluginPage', 'ofd_settings' );

	add_settings_section(
		'ofd_pluginPage_section', 
		__( 'Debugger Settings', 'of-debugger' ), 
		'ofd_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'ofd_options_name', 
		__( 'Option name', 'of-debugger' ), 
		'ofd_options_name_render', 
		'pluginPage', 
		'ofd_pluginPage_section' 
	);


}


function ofd_options_name_render(  ) { 
  
  $options = get_option( 'ofd_settings' );
  if(function_exists('optionsframework_option_name') &&  !$options['ofd_options_name']){
      $options['ofd_options_name'] = optionsframework_option_name();
  }
	?>
	<input type='text' name='ofd_settings[ofd_options_name]' value='<?php echo $options['ofd_options_name']; ?>'>
  <p>Save Option name to load Debugger</p>
	<?php

}


function ofd_settings_section_callback(  ) { 

	echo __( 'Set Your Theme Option name (normally it will be autoload).', 'of-debugger' );

}


function ofd_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>Options Framework Debugger</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php
  $options = get_option( 'ofd_settings' );
  if($options['ofd_options_name']){
    $config = get_option( $options['ofd_options_name'] );
    ?>
    <style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
    <h2>Debug Info</h2>
  
    <table class="gridtable">
    <tr>
      <th>Option Key</th><th>Value</th>
    </tr>
    <?php
    foreach ($config as $key => $value) {
      echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
    }
    ?>  
   </table>

    <?php
  }

}

