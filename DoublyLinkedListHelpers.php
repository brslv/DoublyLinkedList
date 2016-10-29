<?php

trait DoublyLinkedListHelpers
{
    /**
     * Get the head of the list.
     * 
     * @return Node
     */
    public function head()
    {
        return $this->head;
    }

    /**
     * Check if the head has a next node.
     * 
     * @return boolean
     */
    private function headHasNextItem()
    {
        return $this->count > 1;
    }

    /**
     * Change the head of the list.
     * 
     * @param Node $newNode
     * @throws ArgumentException
     * @return DoublyLinkedList
     */
    private function changeHead($newNode)
    {
        if ( ! $newNode) {
            throw new ArgumentException('Either Node or null should be passed as an argument.');
        }

        if ($this->head()) {
            $this->head()->setPrev($newNode);
        }

        $this->setHead($newNode);

        return $this;
    }

    /**
     * Set the head of the list.
     * 
     * @param Node|null $head
     * @return DoublyLinkedList
     */
    public function setHead($head)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get the tail of the list.
     * 
     * @return Node
     */
    public function tail()
    {
        return $this->tail;
    }

    /**
     * Check if the tail has a prev node.
     * 
     * @return boolean
     */
    private function tailHasPrevItem()
    {
        return $this->count > 0 && $this->tail()->prev();
    }

    /**
     * Set the head and the tail of the list in one shot.
     * 
     * @param Node|null $head
     * @param Node|null $tail
     * @return DoublyLinkedList
     */
    private function setHeadAndTail($head, $tail)
    {
        $this->sethead($head);
        $this->setTail($tail);

        return $this;
    }

    /**
     * Set the tail of the list.
     * 
     * @param Node|null $tail
     * @return DoublyLinkedList
     */
    public function setTail($tail)
    {
        $this->tail = $tail;

        return $this;
    }

    /**
     * Get the count of the nodes in the list.
     * 
     * @return number
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Set the count of the nodes in the list.
     * 
     * @param number $count
     * @return DoublyLinkedList
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Change the tail of the list.
     * 
     * @param Node $newNode
     * @return DoublyLinkedList
     */
    private function changeTailIfNeeded($newNode)
    {
        $this->setTail(! $this->tail() ? $newNode : $this->tail());

        return $this;
    }

    /**
     * Increment the counter.
     * 
     * @return $this
     */
    private function incrementCount()
    {
        $this->setCount($this->count() + 1);

        return $this;
    }

    /**
     * Decrement the counter.
     * 
     * @return DoublyLinkedList
     */
    private function decrementCount()
    {
        $this->setCount($this->count() - 1);

        return $this;
    }
}
