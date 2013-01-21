<?php
class Item_Command_Pet_Feed extends Item_Command_Pet {
	protected function _build($name){
		return array(
			'title' => 'Pet hunger', 
			'fields' => array(
				array(
					'input' => array(
						'name' => $name, 'class' => 'input-mini'
					)
				)
			)	
		);
	}
	
	public function validate($param) {
		return (Valid::digit($param) && $param > 0);
	}
	
	public function perform($item, $param, $pet=null) {
	
		
		if($pet->hunger == 100)
			return $pet->name.' is already full';
		else
		{
			$level = $pet->hunger +  $param;
			
			if($level > 100)
				$pet->hunger = 100;
			else 
				$pet->hunger = $level;
			
			$pet->save();
			
			return $pet->name.' has been fed '. $item->name;
		}
	}
}