<?php
/********************************************************************************************
*                                                                                           *
*	SHIFT CIPHER                                                                              *
*		# ASCII CHARS HEX                                                                       *
*	                                                                                          *
*   ENSI SECURITY CLUB  12 juin 2014 - 02:41                                                *
*                                                                                           *
*	@author Med Amine Ben Asker [YuriLz]- mail : ben[dot]asker[dot]amine[at]gmail[dot]com     *
*	                                                                                          *
********************************************************************************************/

function shift_ascii( $char, $arg_shift )
{
  return $char + $arg_shift;
}

function buffer_hexToAscii( $buffer )
{
  foreach( $buffer as $key => $value )
    $buffer[ $key ] = hexdec( $value );  
  
  return $buffer;
}
function buffer_charsToAscii( $string )
{
  $buffer = array( );

    for ( $i = 0; $i<strlen( $string ); $i++ )
        $buffer[ $i ] = ord( $string[ $i ] ); 
	
  return $buffer;
}

function shift_buffer( $buffer, $arg_shift )
{
  foreach( $buffer as $key => $value )
      $buffer[ $key ] = chr ( shift_ascii($value,$arg_shift) );  
	
  return $buffer;
}

function bruteForce_shift_buffer( $buffer )
{
  $result = array( );

  for( $arg_shift=0; $arg_shift<256; $arg_shift++ )
    $result[ ] = implode( shift_buffer( $buffer, $arg_shift ) );
  
  return $result;
}

function display( $buffer )
{
  echo "[shift] : ----[text]----" . "<br>" . PHP_EOL;

  foreach( $buffer as $key => $value )
      echo "[".$key."] : [".$value."]"  . "<br>" . PHP_EOL;
}

 
$input       = ( isset($_POST['plain_text']) ) ? $_POST['plain_text'] : NULL;
$arg_shift   = ( isset($_POST['arg_shift']) ) ? (int) $_POST['arg_shift'] : NULL ;
$type_input  = ( isset($_POST['tinput']) ) ? $_POST['tinput'] : NULL ;
$type_action = ( Isset($_POST['taction']) ) ? $_POST['taction'] : NULL ;

if ( $input  && $type_input && $type_action )
  {
      // type input
      if ( $type_input == "hex" )
        {
            $buffer = explode( " ",$input );
            $buffer = buffer_hexToAscii( $buffer );
        }
      else if ( $type_input == "chars" )
        {
            $buffer = buffer_charsToAscii( $input );
        }
      else
            $buffer = explode( " ",$input );

		// action
      $array = array( );

        if ( $type_action == "shift" )
        {
            $array[ $arg_shift ] = implode( shift_buffer( $buffer, $arg_shift ) );
        }
        else 
        {
            $array = bruteForce_shift_buffer( $buffer );
        }
  }

?>
<html>
	<title>:: Decalage :: </title>
<body>

<?php if ( isset( $array ) ): ?>

    <pre> <?php display( $array ); ?></pre><br>

<?php endif; ?>

<form method="POST" >
	<table>
		<tr>
		<td>Action : </td>
		<td>
			<input type="radio" name="taction" value="shift" checked="checked"> Shift 
			<input type="radio" name="taction" value="shiftAll"> Brute-force
		</td>
		</tr>
		<tr>
		<td>Type input : </td>
		<td>
			<input type="radio" name="tinput" value="chars" checked="checked"> CHARS 
			<input type="radio" name="tinput" value="ascii"> ASCII 
			<input type="radio" name="tinput" value="hex"> HEX
		</td>
		</tr>
		<tr>
		<td>Decalage : </td>
		<td>
			<input type="text" name="arg_shift" value="0"> 
		</td>
		</tr>
		<tr>
		<td>Plain Text :</td>
		<td><textarea name="plain_text" cols="100" rows="8" ></textarea></td>
		</tr>
		<tr>
		<td><input type="submit" value="GO!"></td>
		<td><input type="reset" value="Reset!"></td>
		</tr>
	</table>
</form>

</body>
</html>
