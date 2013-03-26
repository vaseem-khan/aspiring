<?php
if(isset($_POST['dim']))
{
	$func_name=$_POST['func_name'];
	$class_name=$_POST['class_name'];
	$no_args=$_POST['no_args'];
	$dim=$_POST['dim'];
	$var_name=$_POST['var_name'];
	$data_type=$_POST['data_type'];
	
	function make_options_C($var_name,$data_type,$dim,$no_args,$func_name,&$list_options){ //agruments for C returned in list_options
		$config = parse_ini_file('configc.ini', true);
		for($i=1;$i<=$no_args;++$i){
			$option=$config[$data_type[$i].$dim[$i]]['choice'];
			for($j=0;$j<$option;++$j){
				$list_options[$i][]=$config[$data_type[$i].$dim[$i]]["ahead".$j].$var_name[$i-1].$config[$data_type[$i].$dim[$i]]["after".$j];
			}
		}
		$option=$config[$data_type[0].$dim[0]]['choice'];
		for($j=0;$j<$option;++$j){
				$list_options[0][]=$config[$data_type[0].$dim[0]]["ahead".$j].$func_name.$config[$data_type[0].$dim[0]]["after".$j];
			}
		
	}
	
	
	function printdata_c($list_option,$no_args){
		echo '<input type="text" name="returnc0"/> <select name="returnc"><option value="">----</option>';
			for($j=0;$j<count($list_option[0]);++$j){
			    echo '<option value="'.$list_option[0][$j].'">'.$list_option[0][$j].'</option>';
			}
		echo '</select><br/>';
		for($i=1;$i<=$no_args;++$i){
			echo '<input type="text" name="varc0'.$i.'"/> <select name="varc'.$i.'"><option value="">--</option>';
			for($j=0;$j<count($list_option[$i]);++$j){
			    echo '<option value="'.$list_option[$i][$j].'">'.$list_option[$i][$j].'</option>';
			}
			echo '</select><br/>';
		}
	} 
	
	function make_options_java($var_name,$data_type,$dim,$no_args,$func_name,&$list_options){ 
		$config = parse_ini_file('configj.ini', true);
		for($i=1;$i<=$no_args;++$i){
			$option=$config[$data_type[$i].$dim[$i]]['choice'];
			for($j=0;$j<$option;++$j){
				$list_options[$i][]=$config[$data_type[$i].$dim[$i]]["ahead".$j].$var_name[$i-1].$config[$data_type[$i].$dim[$i]]["after".$j];
			}
		}
		$option=$config[$data_type[0].$dim[0]]['choice'];
		for($j=0;$j<$option;++$j){
				$list_options[0][]=$config[$data_type[0].$dim[0]]["ahead".$j].$func_name.$config[$data_type[0].$dim[0]]["after".$j];
			}
	}
	
	function printdata_java($list_option,$no_args){
		echo '<input type="text" name="returnj0"/> <select name="returnj"><option value="">----</option>';
			for($j=0;$j<count($list_option[0]);++$j){
			    echo '<option value="'.$list_option[0][$j].'">'.$list_option[0][$j].'</option>';
			}
		echo '</select><br/>';
		for($i=1;$i<=$no_args;++$i){
			echo '<input type="text" name="varj0'.$i.'"/> <select name="varj'.$i.'"><option value="">--</option>';
			for($j=0;$j<count($list_option[$i]);++$j){
			    echo '<option value="'.$list_option[$i][$j].'">'.$list_option[$i][$j].'</option>';
			}
			echo '</select><br/>';
		}
	}

	echo '<html><body><form id="form" action="backend.php" method="post">
		<input type="hidden" name="no_args" value="'.$no_args.'"> <input type="hidden" name="func_name" value="'.$func_name.'"> 
		<input type="hidden" name="class_name" value="'.$class_name.'">
		
		<hr/><hr/>';

	echo'<br/><h1>C function prototype</h1>';
	make_options_C($var_name,$data_type,$dim,$no_args,$func_name,$list_optionsC);
	
	printdata_C($list_optionsC,$no_args);

	make_options_java($var_name,$data_type,$dim,$no_args,$func_name,$list_optionsJ); 
	
	echo '<hr/><h1>java function prototype</h1>';
	printdata_java($list_optionsJ,$no_args);
	
	echo '<br/><input id="Submit2" type="submit" value="submit" /><input id="Reset2"  type="reset" value="reset" />';
	echo "</form></body></html>";
}
else{
	if(isset($_POST['no_args']))
	{
		//print_r($_POST);
		$no_args=$_POST['no_args'];
		
		echo '<html><body><h1>C code</h1><textarea name="comments" cols="95" rows="4">';
		
		if(isset($_POST['returnc0'])&&$_POST['returnc0']!='')
			echo $_POST["returnc0"].'( ';
		else if(isset($_POST['returnc'])&&$_POST['returnc']!='')
			echo $_POST["returnc"].'( ';
			
		if(isset($_POST['varc01'])&&$_POST['varc01']!="")
			echo $_POST['varc01'];
		else if(isset($_POST['varc1'])&&$_POST['varc1']!="")
			echo $_POST['varc1'];
		
		for($j=2;$j<$no_args+1;++$j){
				if(isset($_POST['varc0'.$j])&&$_POST['varc0'.$j]!="")
					echo ','.$_POST['varc0'.$j];
				else if(isset($_POST['varc'.$j])&&$_POST['varc'.$j]!="")
					echo ','.$_POST['varc'.$j];
		}
		echo '){
		//write code here
	 }</textarea><br/>';
		
		echo'<h1>Java code</h1>';
		echo '<textarea name="comments" cols="95" rows="6"> public class '.$_POST["class_name"].'{
		';
		
		if(isset($_POST['returnj0'])&&$_POST['returnj0']!='')
			echo $_POST["returnj0"].'( ';
		else if(isset($_POST['returnj'])&&$_POST['returnj']!='')
			echo $_POST["returnj"].'( ';
		if(isset($_POST['varj01'])&&$_POST['varj01']!="")
			echo $_POST['varj01'];
		else if(isset($_POST['varj1'])&&$_POST['varj1']!="")
			echo $_POST['varj1'];
		for($j=2;$j<$no_args+1;++$j){
				if(isset($_POST['varj0'.$j])&&$_POST['varj0'.$j]!="")
					echo ','.$_POST['varj0'.$j];
				else if(isset($_POST['varj'.$j])&&$_POST['varj'.$j]!="")
					echo ','.$_POST['varj'.$j];
		}
		echo '){
			//write code here
		}
	}	</textarea><br/>	
		<a href="input.html"> back to input.html</a>
		</body></html>
		';
	 
	}
	else 
		header( 'Location: input.html' ) ;
}
?>
