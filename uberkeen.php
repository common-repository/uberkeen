<?php
/*
Plugin Name: uberkeen
Plugin URI: https://uberkeen.com
Description: Un plugin de communication live
Version: 2
Author: Jean Duez
Author URI: https://uberkeen.com
*/
define( 'UBERKEEN_URL', plugin_dir_url ( __FILE__ ) ); 
define( 'UBERKEEN_DIR', plugin_dir_path( __FILE__ ) ); //definir le dossier principal du plugin
define( 'UBERKEEN_VERSION', '0.1' ); //definir la version du plugin




// Ajout du shortcode [uberkeen]
add_shortcode('uberkeen','uberkeen_ub');
function uberkeen_ub() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'uberkeen';
	$clef = $wpdb->get_results("SELECT * FROM ".$table_name.";");

		foreach ( $clef as $print ) {
		$maclef = $print->clef;
		$button = $print->button;
		$mes_above = $print->mes_above;
		$mes_open = $print->mes_open;
		$button_style = $print->button_style;
		}

		echo $mes_above;
		echo " <br><button style='". $button_style ."' onclick='uberkeen_myFunction()'>". $mes_open ."</button>";
		?>


       

		<script>
		var myWindow;
		function uberkeen_myFunction() {
			var myWindow = window.open('https://www.uberkeen.com/rtc2/inter.php?client=<?php echo $maclef ?>','myWindow', 'width=800, height=400');
		}
		</script>

		<?php

}
	














// Génére le code HTML de la page des options et inscription
function uberkeen_options_page_html() {

	global $wpdb;
	$table_name = $wpdb->prefix . 'uberkeen';
	$res = $wpdb->get_results("SELECT * FROM ".$table_name.";");
	foreach ( $res as $print ) {
	$maclef = $print->clef;
	$mes_above = $print->mes_above;
	$mes_open = $print->mes_open;
	$button_style = $print->button_style;
	}




			if (isset($_POST['clef']) && $_POST['clef'] != '' ){
			$clef = $_POST['clef'];
			$clef = stripslashes($clef);
	
	
						// inscription sur le client
						 global $wpdb;
						 $table_name = $wpdb->prefix . 'uberkeen';
						 $sql = "CREATE TABLE $table_name (
						 id mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
						 clef varchar(250) NOT NULL,
						 button varchar(250) NOT NULL,
						 mes_above varchar(250) NOT NULL,
						 mes_open varchar(250) NOT NULL,
						 button_style varchar(250) NOT NULL,
						 PRIMARY KEY  (id)
						 );";
						 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
						 dbDelta( $sql );
							
							
						$wpdb->insert( 
						$table_name, 
							array( 
	'clef' => $clef, 
	'button' => 'close', 
	'mes_above' => 'Click on this button to speak to us directly over the Internet. Make sure that your microphone is activated.',
	'mes_open' => 'Talk to us',
	'button_style' => 'background:white; cursor:hand; border:solid 1px black; font-class:verdana; font-weight:700; color: teal;', 
							) 
						);
} 







	//affiche form key
	if($maclef == '' && $clef == '' ){
		?>  


		<p>&nbsp;</p>
         <form method='post' action=''> <input type='text' name='clef' value='' placeholder="Your key"/>
		 <span class="submit"><input type="submit" class="button-primary" name="submit" value="register" />
		 </span> <a href="https://www.uberkeen.com/plugin.php" target="_blank"><br />
		 Get your key </a>(it's free)  
         </form>      
		<?php
	}















		if (isset($_POST['open'])){
		global $wpdb;
		$table_name = $wpdb->prefix . 'uberkeen';
		$query="UPDATE $table_name SET button = 'open' " ;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );
		}



		if (isset($_POST['mes'])){
		global $wpdb;
		$mes_above = $_POST['mes_above'];
		$mes_open = $_POST['mes_open'];
		$button_style = $_POST['button_style'];

				$wpdb->update(
					$table_name = $wpdb->prefix . 'uberkeen',
					//$wpdb->prefix .'uberkeen', 
						array( 
						'mes_above' => $mes_above,
						'mes_open' => $mes_open,
						'button_style' => $button_style 
						), 
						array(
						"clef" => $maclef
						) 
				);


		}
?>
	












		<h2>UBERKEEN OPTIONS</h2>
		<p>&nbsp;</p>

		<p><strong>Install your phone anywhere in your site by paste this tag: &nbsp;&nbsp; [uberkeen] &nbsp;&nbsp; and then you can open the line to listen your calls</strong>. <span class="submit"><br />
	    Work with Chrome, Firefox, Opera. </span>		<br />
	    <strong>Important: </strong>This app does not phone on fixed or cellular devices. 
	    It allows you to communicate on the web site.  You have to be online (open application in Uberkeen options) when someone call.</p>
		<p>&nbsp;</p>






	<form method='post' action=''>
	<p class="submit"> <input type="submit" class="button-primary" name="open" id='open' value="open line"  onclick='uberkeen_myFunction()'/> 
	</p>	
	</form>

	    <script>
		var myWindow;
		function uberkeen_myFunction() {
<?php if (isset($maclef)) {echo "var myWindow = window.open('https://www.uberkeen.com/rtc2/inter.php?master=".$maclef."','myWindow', 'width=750, height=450');";} ?>			
		}

		</script>
		
		
		


	<form method='post' action=''>
    <table width="400" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td>Text above button</td>
        <td>Text for button</td>
        <td>Style for button</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><textarea name="mes_above" rows="5"><?php echo $mes_above ?></textarea></td>
        <td><textarea name="mes_open" rows="5" id="mes_open"><?php echo $mes_open ?></textarea></td>
        <td><textarea name="button_style" rows="5" id="button_style"><?php echo $button_style ?></textarea></td>
        <td valign="bottom"><span class="submit">
          <input type="submit" class="button-primary" name="mes" id='mes' value="ok" />
        </span></td>
      </tr>
    </table>
	</form>
	


      You can use html directly in the text above button and in the dedicaced field for the button itself.
    <p>Example for text above button: &lt;h1&gt;This is a Blue Heading&lt;/h1&gt;      &lt;font color='FF00CC'&gt;here&lt;/font&gt;&lt;br&gt;
    <p>Example for button: background:white; cursor:hand; border:solid 1px black; font-class:verdana; font-weight:700; color: teal;
  <?php
}
// fin de page options


















// Menu Admin Activation
function uberkeen_options_init() {
    // page_title,  menu_title, capability, menu_slug, function
    add_options_page('Uberkeen Options', 'Uberkeen Options', 'administrator', __FILE__, 'uberkeen_options_page_html');
}
add_action('admin_menu', 'uberkeen_options_init');
?> 
      
    