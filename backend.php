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
		echo '<select name="returnc">';
			for($j=0;$j<count($list_option[0]);++$j){
			    echo '<option value="'.$list_option[0][$j].'">'.$list_option[0][$j].'</option>';
			}
		echo '</select>';
		for($i=1;$i<=$no_args;++$i){
			echo '<select name="varc'.$i.'">';
			for($j=0;$j<count($list_option[$i]);++$j){
			    echo '<option value="'.$list_option[$i][$j].'">'.$list_option[$i][$j].'</option>';
			}
			echo '</select>';
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
		echo '<select name="returnj">';
			for($j=0;$j<count($list_option[0]);++$j){
			    echo '<option value="'.$list_option[0][$j].'">'.$list_option[0][$j].'</option>';
			}
			echo '</select>';
		for($i=1;$i<=$no_args;++$i){
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
		echo '<html><body><h1>C code</h1><textarea name="comments" cols="95" rows="4">'.$_POST["returnc"].' ( ';
		for($j=1;$j<$no_args;++$j){
				echo $_POST['varc'.$j].',';
		}
		echo $_POST['varc'.$j].'){
		//write code here
		}</textarea><br/>';
		
		echo'<h1>Java code</h1>';
		echo '<textarea name="comments" cols="95" rows="6"> public class '.$_POST["class_name"].'{
		public '.$_POST["returnj"].' ( ';
			
		for($j=1;$j<$no_args;++$j){
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
