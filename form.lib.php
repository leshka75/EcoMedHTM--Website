<?php
###################################
# WORKING WITH FORM
#/* parses form fields */
###################################
function	parseFormFields($arr,$i=0,$r){
		$html = "";
		$script = "";

		foreach($arr as $field){
				$type = isset($field['type'])?$field['type']:'input';
				$id = isset($field['id'])?$field['id']:'f'.$i;
				$def = isset($r[$id])?$r[$id]:'';
				$scr = isset($field['script'])?$field['script']:'';

				switch($type)	{
						case 'input' : $script .= parseInput($field,$id,$def); break;
						case 'date' : $script .= parseDate($field,$id,$def); break;
						case 'select': $script .= parseSelect($field,$id,$r); break;
						case 'checkbox': $script .= parseCheckBox($field,$id,$def); break;
						case 'textarea': $script .= parseTextArea($field,$id,$def); break;
						case 'empty': $script .= genScript($field,$id);break;
					}

				$script .= $scr;
				$i++;
			}
		return $script;
	}

function	parseSmallFormFields($arr,$i=0,$r){
		$html = "";
		$script = "";

		foreach($arr as $field){
				$type = isset($field['type'])?$field['type']:'input';
				$id = isset($field['id'])?$field['id']:'f'.$i;
				$def = isset($r[$id])?$r[$id]:'';
				$scr = isset($field['script'])?$field['script']:'';

				switch($type)	{
						case 'input' : $script .= parseSmallInput($field,$id,$def); break;
						case 'date' : $script .= parseDate($field,$id,$def); break;
						case 'select': $script .= parseSelect($field,$id,$r); break;
						case 'checkbox': $script .= parseCheckBox($field,$id,$def); break;
						case 'textarea': $script .= parseSmallTextArea($field,$id,$def); break;
						case 'empty': $script .= genScript($field,$id);break;
					}

				$script .= $scr;
				$i++;
			}
		return $script;
	}

function	parseTextArea($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];

		$test = isset($f['test'])?$f['test']:'';
		$h = isset($f['height'])?$f['height']:'100';

		$m = $req==1?'*':'';

		echo '<tr>
		          <td><strong>'.$fn.' '.$m.'</strong></td>
				 </tr><tr>
        		  <td>
                      <textarea name="'.$id.'" rows="2" cols="2" class="inp_area"  onfocus="javascript: if(this.value==\'' . $fn . '\') this.value = \'\'" onblur="javascript: if(this.value == \'\') { this.value = \'' . $fn . '\';}">'.$fn.'</textarea>
        		  </td>
		     </tr>';

		return genScript($f,$id);
	}

function	parseSmallTextArea($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];

		$test = isset($f['test'])?$f['test']:'';
		$h = isset($f['height'])?$f['height']:'50';

		$m = $req==1?'*':'';

		echo '
		    <tr>
                <td>
                    <textarea name="'.$id.'" rows="2" cols="2" class="inp_area"  onfocus="javascript: if(this.value==\'' . $fn . '\') this.value = \'\'" onblur="javascript: if(this.value == \'\') { this.value = \'' . $fn . '\';}">'.$fn.'</textarea>
                </td>
            </tr>
        ';
		return genScript($f,$id);
	}

function	parseInput($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];
		$test = $f['test'];

		$m = $req==1?'*':'';

		echo '<tr>
		          <td><strong>'.$fn.' '.$m.'</strong></td>
				 </tr><tr>
                    <td><input name="' . $id . '" value="' . $fn . '" type="text" class="inp_txt" onfocus="javascript: if(this.value==\'' . $fn . '\') this.value = \'\'" onblur="javascript: if(this.value == \'\') { this.value = \'' . $fn . '\';}"></td>
		     </tr>';

		return genScript($f,$id);

	}
function	parseSmallInput($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];
		$test = $f['test'];

		$m = $req==1?'*':'';
        echo '
            <tr>
                <td><input name="' . $id . '" value="' . $fn . '" type="text" class="inp_txt" onfocus="javascript: if(this.value==\'' . $fn . '\') this.value = \'\'" onblur="javascript: if(this.value == \'\') { this.value = \'' . $fn . '\';}"></td>
            </tr>
        ';

		return genScript($f,$id);

	}

function	parseDate($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];
		$test = $f['test'];

		$m = $req==1?'*':'';

		echo '<tr>
		          <td><strong>'.$fn.' '.$m.'</strong></td>
				 </tr><tr>
        		  <td>
        		  	<script language="JavaScript">FSfncWriteFieldHTML("contactform","'.$id.'","'.date('m/d/Y').'",115,"/images/FSdateSelector/","US",false,true)</script>
        		  </td>
		     </tr>';

		return genScript($f,$id);

	}

function	parseSelect($f,$id,$r){
    	$script = "";
		$fn = $f['alias'];
		$req = $f['req'];
		$test = $f['test'];

		$keys = array_keys($f['values']);
		if (count($keys)==0)	return;
		$key = $keys[0];

		$data = is_array($f['values'][$key])?$f['values']:array($f['values']);

		$i = 0;
		echo '<strong>'.$fn.'</strong> ';
		foreach($data as $d)	{
				$id1 = $id.'_'.$i;
				$def = isset($r[$id1])?$r[$id1]:'';


				echo '<SELECT name="'.$id1.'">';
				foreach($d as $key=>$val){
						if ($key==$def)	{
								$sel  = 'selected';
							}else{
								$sel = '';
								}
						echo '<OPTION value="'.$key.'" '.$sel.'>'.$val;
					}
				echo '</SELECT>';
				$i++;
			}

		return genScript($f,$id);
	}

function	parseCheckBox($f,$id,$def){
		$script = "";
		$fn = $f['alias'];
		$req = $f['req'];
		$test = $f['test'];
		$val = $f['values'];

		$ch = $def==''?'':'checked';

		echo '<input name="'.$id.'" type="checkbox" value="'.$val.'" '.$ch.'> <strong>'.$val.'</strong><br>';
		return genScript($f,$id);

	}

function	genScript($f,$id){
		$script = "";
		$req = $f['req'];
		$test = isset($f['test'])?$f['test']:'';
		$msg = isset($f['test_msg'])?$f['test_msg']:"Fill correctly field";

		if ($req && !empty($test)){
			$script = 'var re=/'.$test.'/i;
						if (!re.test(it["'.$id.'"].value)){
							 alert("'.$msg.'");
							 it["'.$id.'"].focus();
							 return false;
							}';
			}

		return $script;
	}

/* generates letter to send */
function	genLetter($arr,$i=0,$r){
		$text = '';
		$i = 0;

		foreach($arr as $field){
				$type = isset($field['type'])?$field['type']:'input';
				$id = isset($field['id'])?$field['id']:'f'.$i;

				if ($type=='empty')	{
					$i++;
					continue;
					}

				if ($type=='multiselect'){
						$vals = is_array($r[$id])?$r[$id]:array($r[$id]);
						$text .= $field['alias'].implode(',',$vals)."\r\n";

						continue;
					}

				if ($type=='select'){
					$i++;

					$keys = array_keys($field['values']);
					if (count($keys)==0)	continue;
					$key = $keys[0];

					$data = is_array($field['values'][$key])?$field['values']:array($field['values']);

					$j = 0;

					$text .= $field['alias'];
					foreach($data as $d)	{
							$id1 = $id.'_'.$j;
							$text .= $r[$id1];
							$j++;
							if ($j!=count($data)){
									$text .= "/";
								}
						}
					$text .= "\r\n";

					continue;
					}

				if (isset($r[$id])){
					$text .= $field['alias'].$r[$id]."\r\n";
				}

                $i++;
			}
		return	$text;
	}

/*validates image number*/
function captureData($rq){
	if (isset($rq['captcha'])) {
		$s = $rq['captcha'];
		if (strlen($s) == 4 && preg_match('/\d{4}/',$s)) {
			$d4 = (abs(($s[0]+$s[1]-$s[2]+10)*($s[0]/$s[1]+$s[2]))*date('j')*date('n'))%10;
			if ($d4 == $s[3]) $capOk = 1;
			else $capOk = 0;
		} else $capOk = 0;
	} else $capOk = 0;
	return	$capOk;
}

/* send mail */
function	send_mail($name,$send_mail,$reply,$subj,$msg)	{
		$s = $_SERVER['SERVER_ADDR'];

		if (preg_match("/127\.0\./",$s) || preg_match("/192\.168\./",$s) || preg_match("/10\.1\./",$s)){
				define('LOCAL',1);
			}else{
				define('LOCAL',0);
				}

		if (!preg_match('[\r\n]',$reply) && !preg_match('[\r\n]',$subj)) { //### mail injection check
			$hdr = 'From: "'.$name.'" <'.$reply.">\r\n"
			.'Reply-To: "'.$name.'" <'.$reply.">\r\n";

			if (!LOCAL) {
					$ok = @mail($send_mail, $subj, $msg ,$hdr);
				}else {
				$ok = 1;
				echo $msg;
			}

			if ($ok) {
				return	"";
			} else {
				return 'Error sending e-mail!';
			}
			}
}

?>