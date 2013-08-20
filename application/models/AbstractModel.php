<?php
/**
 * Convenience functions for auto get/set operations
 */

class Application_Model_AbstractModel {

    /**
     * @param array $values
     */
    public function populate($values)
    {
        $class_variables = get_class_vars(get_class($this));
        foreach($class_variables as $variable => $val){
            if(isset($values[$variable])){
                $this->$variable = $values[$variable];
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

}