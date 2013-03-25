<?php
if(isset($_POST['dim']))
{
	$func_name=$_POST['func_name'];
	$class_name=$_POST['class_name'];
	$no_args=$_POST['no_args'];
	$dim=$_POST['dim'];
	$var_name=$_POST['var_name'];
	$data_type=$_POST['data_type'];
	$list_optionsC[]=array();
	$list_optionsJ[]=array();
	$list_returnC=array();
	$list_returnJ=array();
	function make_options_C($var_name,$data_type,$dim,$no_args,$func_name,&$list_options){ //agruments for C returned in list_options
		$config = parse_ini_file('configc.ini', true);
		for($i=0;$i<$no_args;++$i){
			$option=$config[$data_type[$i].$dim[$i]]['choice'];
			for($j=0;$j<$option;++$j){
				$list_options[$i][]=$config[$data_type[$i].$dim[$i]]["ahead".$j].$var_name[$i].$config[$data_type[$i].$dim[$i]]["after".$j];
			}
		}				
	}
	function return_C(){ //return type for c
		$config = parse_ini_file('configc.ini', true);
		echo '<select name="returnc">';
		$option=$config['return']['choice'];
		for($j=0;$j<$option;++$j){
			 echo '<option value="'.$config["return"]["op".$j].'">'.$config["return"]["op".$j].'</option>';
		}
		echo '</select>';
	}				
	
	function return_J(){//return type for java
		$config = parse_ini_file('configj.ini', true);
		echo '<select name="returnj">';
		$option=$config['return']['choice'];
		for($j=0;$j<$option;++$j){
			 echo '<option value="'.$config["return"]["op".$j].'">'.$config["return"]["op".$j].'</option>';
		}
		echo '</select>';
	}	
	
	function printdata_c($list_option,$no_args){
		for($i=0;$i<$no_args;++$i){
			echo '<select name="varc'.$i.'">';
			for($j=0;$j<count($list_option[$i]);++$j){
			    echo '<option value="'.$list_option[$i][$j].'">'.$list_option[$i][$j].'</option>';
			}
			echo '</select>';
		}
	} 
	
	function make_options_java($var_name,$data_type,$dim,$no_args,$func_name,&$list_options){ 
		$config = parse_ini_file('configj.ini', true);
		for($i=0;$i<$no_args;++$i){
			$option=$config[$data_type[$i].$dim[$i]]['choice'];
			for($j=0;$j<$option;++$j){
				$list_options[$i][]=$config[$data_type[$i].$dim[$i]]["ahead".$j].$var_name[$i].$config[$data_type[$i].$dim[$i]]["after".$j];
			}
		}				
	}
	
	function printdata_java($list_option,$no_args){
		for($i=0;$i<$no_args;++$i){
			echo '<select name="varj'.$i.'">';
			for($j=0;$j<count($list_option[$i]);++$j){
			    echo '<option value="'.$list_option[$i][$j].'">'.$list_option[$i][$j].'</option>';
			}
			echo '</select>';
		}
	} 

	echo '<html><body><form id="form" action="backend.php" method="post">
		<input type="hidden" name="no_args" value="'.$no_args.'"> <input type="hidden" name="func_name" value="'.$func_name.'"> 
		<input type="hidden" name="class_name" value="'.$class_name.'">
		<hr/><hr/>';
	echo'<h5>C function return type';
	return_C();
	echo'</h5><h5>java function return type</h5>';
	return_J();
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
		$no_args=$_POST['no_args'];
		echo '<html><body><h1>C code</h1><textarea name="comments" cols="95" rows="4">'.$_POST["returnc"].' '.$_POST["func_name"].'( ';
		for($j=0;$j<$no_args-1;++$j){
				echo $_POST['varc'.$j].',';
		}
		echo $_POST['varc'.$j].'){
		//write code here
		}</textarea><br/>';
		
		echo'<h1>Java code</h1>';
		echo '<textarea name="comments" cols="95" rows="6"> public class '.$_POST["class_name"].'{
		public '.$_POST["returnj"].' '.$_POST["func_name"].'( ';
			
		for($j=0;$j<$no_args-1;++$j){
				echo $_POST['varj'.$j].',';
		}
		
		echo $_POST['varj'.$j].'){
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
