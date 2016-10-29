<?php

class Node
{
	/** @var mixed */
    private $value;

    /** @var Node|null */
    private $prev;

    /** @var Node|null */
    private $next;

    /**
     * Constructor.
     * 
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of the node.
     * 
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the prev of the node.
     * 
     * @param Node|null $prev
     * @return Node
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;

        return $this;
    }

    /**
     * Get the prev of the node.
     * 
     * @return Node|null
     */
    public function prev()
    {
        return $this->prev;
    }

    /**
     * Set the next of the node.
     * 
     * @param Node|null $next
     * @return Node
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get the next node.
     * 
     * @return Node|null
     */
    public function next()
    {
        return $this->next;
    }

    /**
     * Set the both references (prev, next) simultaneously.
     * 
     * @param Node|null $prev
     * @param Node|null $next
     * @return Node
     */
    public function setReferences($prev, $next)
    {
        $this->setPrev($prev);
        $this->setNext($next);

        return $this;
    }
}
