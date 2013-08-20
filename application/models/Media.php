<?php

class Application_Model_Media  implements Application_Model_ModelInterface
{

    private $id;
    private $thumb;
    private $web;
    private $original;
    private $name;
    private $media_type;

    const MEDIA_TYPE_PAGE = 'page';
    const MEDIA_TYPE_WORKSHOP = 'workshop';

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        return $this;
    }

    public function getThumb()
    {
        return $this->thumb;
    }

    public function setWeb($web)
    {
        $this->web = $web;
        return $this;
    }

    public function getWeb()
    {
        return $this->web;
    }

    public function setOriginal($original)
    {
        $this->original = $original;
        return $this;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $media_type
     * @return Media
     */
    public function setMediaType($media_type)
    {
        $this->media_type = $media_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMediaType()
    {
        return $this->media_type;
    }







    /**
     * @param array $values
     */
    function populate($values)
    {
        $class_variables = get_class_vars(__CLASS__);
        foreach ($class_variables as $variable => $val) {
            if (isset($values[$variable])) {
                $this->$variable = $values[$variable];
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }


}

