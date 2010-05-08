<?php
class iterator_main implements Iterator
{
    protected $db;
    protected $cur = 0;
    protected $end = 0;
    protected $iter_info = array();

    public function  __construct($db)
    {
        $this->db = $db;
    }

    public function rewind()
    {
        $this->cur = 0;
    }

    public function valid()
    {
        return $this->cur <= $this->end;
    }

    public function current()
    {
        return $this->iter_info[$this->cur];
    }

    public function key()
    {
        return $this->cur;
    }

    public function next()
    {
        $this->cur++;
    }
}
?>
