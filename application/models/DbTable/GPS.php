<?php

class Application_Model_DbTable_GPS extends Zend_Db_Table_Abstract
{

    protected $_name = 'userdata';

    public function getUser($id)
    {    
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
    
    public function fetchSome($k)
    {    
    	$list = array();
    	while ($k > 0) {
    		$row = $this->fetchRow('id = ' . rand(0,100));
    		if ($row) 
    		{
	    		$k--;
	    		$list[] = $row;
    		}
    	}
    	
    	return $list;
    }
    
    public function CalDistance($x, $y, $x1, $y1)
    {
    	//return ($x - $y) * ($x - $y)  + ($x1 - $y1)*($x1 - $y1);	
    	return 6371000 * acos(sin($x) * sin($x1) + cos($x) * cos($x1) * cos($y1 - $y));
    }
    
    public function getUserNearby($max,$latitude,$longtitude)
    {
    	$testcase = array (10,20,50,100,500,1000,5000,10000,100001);
    	$distance = array();
    	$distance = array_fill(0,500001,0);   
    	$count = 0;
    	$list = array();
    	$rows = $this->fetchAll();
    	$N = sizeof($rows);
    	
    	foreach ($testcase as $i => $value)
    	{
    		foreach ($rows as $row)
    		{    	
    			$dis =  $this->CalDistance($latitude,$longtitude,$row->latitude,$row->longtitude);  			
    			if (($distance[$row->id] != 1) && ($row) && ($dis <= $testcase[$i]))
    			{
    				$count++;
    				$distance[$row->id] = 1;
    				$row->longtitude = $dis;
    				$list[] = $row;
    				if ($count == $max) break;
    			}
    		}	
    		if ($count == $max) break;    	}
    	
    	return $list;
    }
    
    public function clearalltable()
    {
    	$where = '1';    	
    	$this->delete($where);     
    }

    public function addUser($id, $nickname, $age, $latitude, $longtitude)
    {
        $data = array(
            'id' => $id,
            'nickname' => $nickname,
        	'age' => $age,
        	'latitude' => $latitude,
        	'longtitude' => $longtitude,
        );
        $this->insert($data);
    }

    public function updateUser($id, $nickname, $age, $latitude, $longtitude)
    {
        $data = array(
        		'id' => $id,
        		'nickname' => $nickname,
        		'age' => $age,        		
            	'latitude' => $latitude,
        		'longtitude' => $longtitude,
        );
        $this->update($data, 'id = '. (int)$id);
    }

    public function deleteUser($id)
    {
        $this->delete('id =' . (int)$id);
    }

}

