<?php
    ob_start();
    /*
    Plugin Name: aanvraag
    Version: 1.0
    Author: Erwin van Tilburg
    Author URI: https://github.com/RWinning
    Description: Dit wordt een organisator aanvraag bekijk pagina
    Text Domain: Test.nl
    */

   function aanvraag_plugin_shortcode()
    {
 ?>
   
<?php
        date_default_timezone_set("Europe/Amsterdam");
        global $wpdb;  
        
        if(isset ($_GET["id"])&& isset($_GET["action"])){
                if($_GET["action"] == "delete")
                {
                    $wpdb-> query(
                    $wpdb->prepare(
                        "DELETE FROM `login` WHERE `id` = '%d'" ,$_GET["id"])
                );
                }
             elseif($_GET["action"] == "update")
                {
                    $wpdb-> query(
                    $wpdb->prepare(
                        "UPDATE slot SET Tag=3 WHERE id = '%d' ", $_GET["id"])
                       
                );
                 
                  $to  = "$_GET(email)"; 


// subject
$subject = 'Passe Partout';

// message
$message = '
<html>
<head>
  <title>Passe Partout</title>
</head>
<body>
 Hier is een Passe Partout   <br>
 Streepjescode: hsdjhfkhegtuwet75jtey309wrfdjkgi3e7th43w8trgy <br>
 </body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$_SESSION["email"].' <'.$_SESSION["email"].'>' . "\r\n";
$headers .= 'From: Conferentie <conferentie1234@gmail.com>' . "\r\n";

        mail($to, $subject, $message, $headers);
                 
                }
            
        }
       
         $result = $wpdb-> get_results(
                    "SELECT login.id, login.1e_slot, login.onderwerp, login.omschrijving FROM login INNER JOIN slot ON slot.id = login.1e_slot WHERE Tag = 2", ARRAY_A
                );

        
          echo "<table>
                <tr>
                    <th>ID</th>
                    <th>1e_slot</th>
                    <th>onderwerp</th>
                    <th>omschrijving</th>
                    <th>Accept Verander tag in 3</th>
                    <th>Delete</th>
                </tr>";
            
            for( $i = 0; $i < sizeof($result); $i++){
                echo"<tr>
                        <td>".$result[$i]["id"]."</td>
                        <td>".$result[$i]["1e_slot"]."</td>
                        <td>".$result[$i]["onderwerp"]."</td>
                        <td>".$result[$i]["omschrijving"]."</td>
                        <td><a href='http://localhost/conferentiesite/wordpress/aanvraag/?id=".$result[$i]["1e_slot"]."&action=update'>
                        <img src='http://localhost/conferentiesite/wordpress/wp-content/plugins/Organisator-aanmelden-plugin/images/vink.png' alt='vink'</a></td>
                        <td><a href='http://localhost/conferentiesite/wordpress/aanvraag/?id=".$result[$i]["id"]."&action=delete'>
                        <img src='http://localhost/conferentiesite/wordpress/wp-content/plugins/Organisator-aanmelden-plugin/images/drop.png' alt='cross'</a></td>
                    </tr>" ;  
            }
            echo "</table>";
            echo "</form>";
        


    }

    function aanvraag_shortcode()
    {
        add_shortcode('aanvraag','aanvraag_plugin_shortcode');
    }

    add_action('init', 'aanvraag_shortcode');

?>