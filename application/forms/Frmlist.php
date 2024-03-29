<?php
/*
 * Author: 	KRY CHANTO
 * Date	 : 	15-July-2011
 */
class Application_Form_Frmlist
{	        
    /*
     * Multi cells in one row list
     */    	
    public function getMultiCellList($type,$columns,$rows,$merge_column=NULL,$link=null,$link_difference=false,$icon=0)
    {        
    	/*------------------------Check param id----------------------------------*/
    	/*------------------------End check---------------------------------------*/
        $acl=new Application_Model_DbTable_Dbacl();
        //-------------------------Header----------------------
       	$form='';                 
        $counter='<strong>Number of record(s): '.count($rows).'</strong>';
        $head=$form.'<table class="collape tablesorter" id="table"  width="100%">';
        $col_str="";
        if($type!=null){
    		$col_str='<thead><tr><th class="tdheader">No</th>';
        }
            	
    	foreach($columns as $column){
    		$col_str=$col_str.'<th class="tdheader">'.$column.'</th>';
    	}    	    	
    	$col_str.='</tr></thead>';
		$head.=$col_str;
		//if row empty
		if($rows==NULL) return $head.'</table><center style="font-size:12pt;">No record</center></form>';
		//------------------------Body----------------------------
		$body='';
		$row_str='<tbody>'; 
    	//add element rows	
    	$tempvalue=0;    	
    	$class_item='items';
    	if($merge_column==NULL) return $this->getCheckList($type, $columns, $rows);     	
    	else $class_item="items-no-inline";
    	$rt=0;
    	$r=0;
    	foreach($rows as $row){		 	    		
    		if($r%2==0)$attb='normal';
    		else $attb='alternate';
    		$r++;
    		//-------------------check select-----------------		
    		//-------------------end check select-----------------
    		$row_str.='<tr class="'.$attb.'">';
    		$i=0;    		   	
    		$b=0;	    	
    		$temp='';    	
    		$row_temp=$row;	    	
    		//set link icon
    		if($icon==0)
				$img='<img src="/css/link.png"/>&nbsp;&nbsp;';
				else $img='<img src="/css/add.png" class="add"/>&nbsp;&nbsp;';			
    		foreach($row as $key=>$read){
    			if($read==null) $read='&nbsp';    			
    			if($i==0) {
    				$tempvalue=$read;		    				    						    				 			    				    				
    				if($type==null){ $row_str.=""; }
    				else{  					
		  				$row_str.='<td class="items-no" align="center">'.$r.'</td>';
    				}
		  		}   
		  		else{		  
		  			//link session to id
					if($link!=null){						
						if(!$link_difference){									     						
    							foreach($link as $column=>$url)
    								if($key==$column){    									
    									$array=array('tag'=>'a','attribute'=>array('href'=>Application_Form_FrmMessage::redirectorview($url).'/id/'.$row[$column]));
    									$read=$this->formSubElement($array,$img.$read);
    									
    								}
						}
						else{
							foreach($link as $column=>$url)
    								if($key==$column){    									
    									$array=array('tag'=>'a','attribute'=>array('href'=>Application_Model_Admin::redirector($url).'/id/'.$tempvalue));
    									$read=$this->formSubElement($array,$img.$read);
    								}
						}
													
    				} //$link==null    				
		  			//merge column
		  			foreach($merge_column as $column){		  						  					  						    					
    						if($column==$key){
    							$temp.=$read.'<br/>';
    							$b++;
    						}	    				  			 				    										    											    				
		  			}//close merge column
		  			if($b==0){				  						  				  					  				
		  				if('rate'===$key){
		  					if($read<0.7)
		  						$row_str.='<td class="rate-red">'.$read.'</td>';
		  					elseif($read>=0.7 && $read<0.9)
		  						$row_str.='<td class="rate-amber" >'.$read.'</td>';
		  					else
		  					   $row_str.='<td class="rate-green">'.$read.'</td>';
		  				}//key=rate
		  				else{		  				 
		  				  $text=$this->textAlign($read);
    					  $read=$this->checkValue($read);
    					  $row_str.='<td class="'.$class_item.'" '.$text.'>'.$read.'</td>';    	
		  				}
		  			}//b==0#FFBF00
		  			else{
		  				if($b==2){		  				 
		  				  $row_str.='<td class="'.$class_item.'">'.$temp.'</td>';
		  				  $b=0;
		  				}		  						  						  			
		  		 	}//close c==0
     			//end color
		  		}//close i==0		  					  			
		  		$i++;	
    		}//close for each row
    		$row_str.='</tr>';	
    	 }//close for each rows    				  					  		    			
       	    	
    	$body .=$row_str.'</tbody>';
    	//------------------------End Body---------------------------
    	//------------------------Footer-----------------------------  
    	$counter='<strong style="float:right;padding:5px">Number of record(s): '.count($rows).'</strong>';    	
		$footer='</table>'.$counter;
		//	----------------------End Footer------------------------- 
		return $head.$body.$footer;
    }   

    
    /*
     * Recomment usage
     */
    public function getCheckList($type,$columns,$rows,$link=null,$class='items', $textalign= "left", $report=false, $id = "table")
    {
    	$tr = Application_Form_FrmLanguages::getCurrentlanguage();
    	/*
     	* Define string of pagination Sophen 27 June 2012
     	*/
    	$stringPagination = '<script type="text/javascript">
				$(document).ready(function(){
					$("#'.$id.'").tablesorter();
					
					$("#'.$id.'").tablesorter().tablesorterPager({container: $("#pagination_'.$id.'")});
					$("input:.pagedisplay").focus(function(){ this.blur(); });
					
					function changeColor(){
						alert("change color on mouse over");
					}
				});
		</script>
		<div id="pagination_'.$id.'" class="pager" >
					<form >
						<table  style="width: 200px;border: 0px;background-color: #EDF7F8;margin: 0px"><tr>
						<td><img src="'.BASE_URL.'/images/first.gif" class="first"/></td>
						<td><img src="'.BASE_URL.'/images/previous.gif" class="prev"/></td>
						<td><input type="text" style="margin-bottom: 5px;" class="pagedisplay"/></td>
						<td><img src="'.BASE_URL.'/images/next.gif" class="next"/></td>
						<td><img src="'.BASE_URL.'/images/last.gif" class="last"/></td>
						<td><select class="pagesize" >
							<option selected="selected"  value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
							<option value="60">60</option>
							<option value="70">70</option>
							<option value="80">80</option>
							<option value="90">90</option>
							<option value="100">100</option>
							</select>
					    </td>
						</tr>
						</table>
					</form>
			</div>	';
    	/* end define string*/
    	
    	$head='<table class="collape tablesorter" id="'.$id.'" width="100%">';
    	$col_str='';
    	if($type!=null)
    		$col_str='<thead><tr><th class="tdheader">'.$tr->translate("NUM").'</th>';
    	//add columns
    	foreach($columns as $column){
    		if($column == "DELETE") $col_str=$col_str.'<th class="tdheader-delete">'.$tr->translate($column).'</th>';
    		else $col_str=$col_str.'<th class="tdheader">'.$tr->translate($column).'</th>';
    	
    	}
    	$col_str.='</tr></thead>';   
    	$row_str='<tbody>'; 
    	//add element rows	
    	if($rows==NULL) return $head.$col_str.'</table><center style="font-size:18pt;">No record</center></form>';
    	$temp=0;
    	/*------------------------Check param id----------------------------------*/

    	/*------------------------End check---------------------------------------*/
    	$r=0;
    	foreach($rows as $row){
    		if($r%2==0)$attb='normal';
    		else $attb='alternate';
    		$r++;
	    		//-------------------check select-----------------

    		//-------------------end check select-----------------
    		$row_str.='<tr class="'.$attb.'"> ';
    				$i=0;    				
		  			foreach($row as $key=>$read) {
		  				if($read==null) $read='&nbsp';
		  				if($i==0) {
		  					$temp=$read;
		  					if($type!=null){		  							
		  						$row_str.='<td class="items-no" style="padding:7px" align="center">'.$r.'</td>';
		  					}		  					
		  				}   		
    					else {
    						if($link!=null){    			
    							foreach($link as $column=>$url)
    								if($key==$column){
    									//$img='<img src="'.BASE_URL.'/css/link.png"/>&nbsp;&nbsp;';
    									$img='';
    									$array=array('tag'=>'a','attribute'=>array('href'=>Application_Form_FrmMessage::redirectorview($url).'/id/'.$temp));
    									$read=$this->formSubElement($array,$img.$read);
    								}
    						} //$link==null
    						$text='';
    						if($i!=0){
	    						$text=$this->textAlign($read);
	    						$read=$this->checkValue($read);
	    						    						
	    						if($textalign !== 'left'){
	    							$text  = " align=". $textalign;
	    						}
    						}
    						
    						if($i === 1){
    							$text  = " align=". $textalign;
    						}
    						
    						$row_str.='<td class="'.$class.'" '.$text.'>'.$read.'</td>';    								
    					}//$i==0
    					$i++;
		  			}    				
 					$row_str.='</tr>';   
 								
    	}    	    	
    	$counter='<strong style="float:right;padding-right:5px">'.$tr->translate('NUM-RECORD').count($rows).'</strong>';
    	$row_str.='</tbody>';
    	$footer='</table>'.$counter.'<br/>';
    	if(!$report){
    		$footer .= $stringPagination;
    	}
    	return $head.$col_str.$row_str.$footer;    	
    }
    
    
    public function formElement($array)
    {
    	$stat='';		
		foreach($array as $tag=>$name){
			if($tag=='tag'){
				$stat.='<'.$name.' ';
				$closetag='</'.$name.'>';
			}
			else 
				foreach($name as $att=>$value)
					$stat.=$att.'="'.$value.'" ';
		}
		$stat.=">".$closetag;
		return $stat;
    }        
    public function formSubElement($array,$element='')
    {
    	$stat='';		
		foreach($array as $tag=>$name){
			if($tag=='tag'){
				$stat.='<'.$name.' ';
				$closetag='</'.$name.'>';
			}
			else 
				foreach($name as $att=>$value)
					$stat.=$att.'="'.$value.'" ';
		}
		$stat.=">".$element.$closetag;
		return $stat;
    }
    public function checkValue($value){
    	//Sophen comment for number format
    	//no need format for phone number
    	//if(is_numeric($value) && $value>100) return number_format($value);
    	//elseif($this->is_date($value)) return date_format(date_create($value), 'd-M-Y');  
    	
    	if($this->is_date($value)) return date_format(date_create($value), 'd-M-Y');  	
    	return $value;
    }
	private function textAlign($value){		
		$temp=str_replace(',','', $value);
		//Sophen comment for number
    	//if(is_numeric($temp) || $temp=='-') return 'style="text-align:right"';
    	//elseif($this->is_date($temp) || strtolower($temp) == "yes" || strtolower($temp) == "no" ) return  'style="text-align:center"';
    	if($this->is_date($temp) || strtolower($temp) == "yes" || strtolower($temp) == "no" ) return  'style="text-align:center"';
		else{
    		$temp=explode('-', $value);
    		if(count($temp)>2){
    			if(is_numeric($temp[0]) && is_numeric($temp[2])){
    				if(!is_numeric($temp[1]) && strlen($temp[1])==3) return 'style="text-align:center"'; 
    			}
    		}
    		
    		$pos = strpos($value, "class=\"colorcase");
    		if($pos){
    			return 'style="text-align:center"';
    		}
    	}   	
		
    	return '';    	    	
    }
    public function is_date($str)
    {
    	try{
	       $temp=explode('-', $str);
	       if(is_array($temp) && count($temp)>=3){
				if(is_numeric($temp[0]) && is_numeric($temp[1]) && is_numeric(substr($temp[2],0,2))){
						 				      	
		       		$d=substr($temp[2],0,2);
		       		
		       		$m=$temp[1];
		       		$y=$temp[0];		       		
		       		if(checkdate($m, $d, $y)) return true;
				}
	       }       
	       return false;
    	}catch(Zend_Exception $e){
    		return false;	
    	}    	
    } 
}

