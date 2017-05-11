<?php
    ob_start();
    /*
    Plugin Name: contact plugin
    Version: 1.0
    Author: Erwin van Tilburg
    Author URI: https://github.com/RWinning
    Description: Dit wordt een contact form
    Text Domain: Test.nl
    */

    function form_contact_shortcode()
    {
        global $wpdb; 
        
        
  
        if(isset($_POST["submit"]))
        { 
            $wpdb->query(
                        $wpdb -> prepare("INSERT INTO `contact`(       `rol`,
                                                                    `voornaam`,
                                                                    `tussenvoegsel`,
                                                                    `achternaam`,
                                                                    `email`,
                                                                    `vraag`)
                                         VALUES
                                                                    (1,
                                                                     '%s',
                                                                     '%s',
                                                                     '%s',
                                                                     '%s',
                                                                     '%s')", 
                                                                     $_POST["voornaam"],
                                                                     $_POST["tussenvoegsel"],
                                                                     $_POST["achternaam"],
                                                                     $_POST["email"],
                                                                     $_POST["vraag"]
                                                                    )
                
                
                );
            
               
            
    $user = $wpdb->get_var("SELECT MAX(id) FROM contact");
    $name = $wpdb->get_var("SELECT voornaam, tussenvoegsel, achternaam FROM contact where id = $user");
    $tussenvoegsel = $wpdb->get_var("SELECT tussenvoegsel, achternaam FROM contact where id = $user");
    $achternaam = $wpdb->get_var("SELECT achternaam FROM contact where id = $user");
    $vraag = $wpdb->get_var("SELECT vraag FROM contact where id = $user");
            
            
               header("location: contact");
            
$to  = "$_GET(email)"; 


// subject
$subject = 'Vraag';

// message
$message = '
<html>
<head>
  <title>Vraag aan een spreker stellen.</title>
</head>
<body>
 Vraag aan een spreker.   <br>
 UserID: '.$user.' <br>
 Name: '.$name.' '.$tussenvoegsel.' '.$achternaam.' <br>
 Vraag: '.$vraag.'<br>       
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

          
       $output = " 
                    <table>
                    <form action='http://localhost/conferentiesite/wordpress/contact' method='post'>
                    <tr>
                        <td>Voornaam:</td><td><input type='text' name='voornaam' required/></td>
                    </tr>
                    <tr>
                        <td>Tussenvoegsel:</td><td> <input type='text' name='tussenvoegsel'/></td>
                    </tr>
                    <tr>
                        <td>Achternaam:</td> <td><input type='text' name='achternaam' required/></td>
                    </tr>
                    <tr>
                        <td>Email:</td> <td><input type='email' name='email' required/></td>
                    </tr>
                     <tr>
                        <td>Vraag:</td> <td><input type='text' name='vraag' required/></td>
                    </tr>
                        <td><input type='submit' name='submit' value='Verzenden'/></td>
                    </form>
                    </table>";
        
        return $output;
    }

    function form_contact_register_shortcode()
    {
        add_shortcode('form-contact','form_contact_shortcode');
    }

    add_action('init', 'form_contact_register_shortcode');
?>
