<?php
if(isset($_POST['func_name'])/*&&isset($_POST['class_name'])&&isset($_POST['no_args'])*/)
{
		
	$func_name=$_POST['func_name'];
	$class_name=$_POST['class_name'];
	$no_args=$_POST['no_args'];
	$dim=$_POST['dim'];
	$var_name=$_POST['var_name'];
	$data_type=$_POST['data_type'];

	function make_options_C($var_name,$data_type,$dim,$no_args,$func_name){ //agruments for c returned in list_options
		$k=1;
		$list_options[0]="";
		$list_options[0].=$func_name.'(';
		for($i=0;$i<$no_args;++$i){

				if ($dim[$i]==1){
				for($j=0;$j<$k;++$j){
					$list_options[ ]=($list_options[$j].' '.$data_type[$i].' '.$var_name[$i].'[] ,');
				}
				for($j=0;$j<$k;++$j){
						$list_options[$j].=' '.$data_type[$i].' *'.$var_name[$i].',' ;	
				}
				$k*=2;
			
			}
			else if($dim[$i]==0){
				for($j=0;$j<$k;++$j){
					$list_options[$j].=' '.$data_type[$i].' '.$var_name[$i].',' ;	
				}
			}
			else if($dim[$i]==2){
				for($j=0;$j<$k;++$j){
					$list_options[$j].=' '.$data_type[$i].' **'.$var_name[$i].',' ;	
				}
				
			}
		}
		for($j=0;$j<$k;++$j){
			$list_options[$j]= substr($list_options[$j], 0, -1);
			$list_options[$j].='){  
			//write code here
		}';
			echo ' 
			<input type="radio" name="select" value="'.$list_options[$j].'"/>'.'<textarea name="comments" cols="95" rows="3">'.$list_options[$j].'
			</textarea><br>
			';
		}
	}

	function make_options_java($var_name,$data_type,$dim,$no_args,$func_name,$class_name){//agruments for JAVA returned in list_options
		$k=1;
		$list_options[0]="public ".$class_name."{
		public ";
		$list_options[0].=$func_name.'(';
		for($i=0;$i<$no_args;++$i){

				if ($dim[$i]==1){
				for($j=0;$j<$k;++$j){
					$list_options[ ]=($list_options[$j].' '.$data_type[$i].'[] '.$var_name[$i]. ',');
				}
				for($j=0;$j<$k;++$j){
						$list_options[]=$list_options[$j].' ArrayList '.$var_name[$i].',' ;	
				}
				for($j=0;$j<$k;++$j){
						$list_options[$j].=' Set<Integer> '.$var_name[$i].',' ;	
				}
				$k*=3;
			
			}
			else if($dim[$i]==0){
				for($j=0;$j<$k;++$j){
					$list_options[$j].=' '.$data_type[$i].' '.$var_name[$i].',' ;	
				}
			}
			else if($dim[$i]==2){
				for($j=0;$j<$k;++$j){
					$list_options[$j].=' '.$data_type[$i].' **'.$var_name[$i].',' ;	
				}
				
			}
		}

		for($j=0;$j<$k;++$j){
			$list_options[$j]= substr($list_options[$j], 0, -1);
			$list_options[$j].='){  
			//write code here
			}
		}';
			echo '
			<input type="radio" name="select1" value="'.$list_options[$j].'"/>'.'<textarea name="comments" cols="95" rows="5">'.$list_options[$j].'
			</textarea><br>
			';
		}
	}

	echo '<html><body><form id="form" action="backend.php" method="post">';
	echo '<hr/><hr/><h1>C function prototype</h1>';
	make_options_C($var_name,$data_type,$dim,$no_args,$func_name);
	echo '<hr/><h1>java function prototype</h1>';
	make_options_java($var_name,$data_type,$dim,$no_args,$func_name,$class_name);
	echo '<br/><input id="Submit2" type="submit" value="submit" /><input id="Reset2"  type="reset" value="reset" />';
	echo "</form></body></html>";
}
else{
if(isset($_POST['select'])&&isset($_POST['select1']))
{
	echo '<html>
		<body>
		<h1>C code</h1>
		<textarea name="comments" cols="95" rows="4">'.$_POST['select'].' </textarea><br/><br/>
		<h1>Java code</h1>
		<textarea name="comments" cols="95" rows="5">'.$_POST['select1'].' </textarea><br/><br/><br/>
		<a href="input.html"> back to input.html</a>
		</body></html>
		';
 
}
else 
header( 'Location: input.html' ) ;
}
?>
