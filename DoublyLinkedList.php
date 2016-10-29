<?php

/**
 * Class DoublyLinkedList.
 * 
 * @author Borislav Grigorov <borislav.b.grigorov@gmail.com>
 */
class DoublyLinkedList
{
    use DoublyLinkedListHelpers;

    /** @var int */
    private $count;

    /** @var Node */
    private $head;

    /** @var Node */
    private $tail;

    /**
     * Constructor.
     */
    public function __constructor()
    {
        $this->count = 0;    
    }

    /**
     * Add an item to the beginning of the list.
     * 
     * @param mixed $value
     * @return Node
     */
    public function addFirst($value)
    {
        $newNode = new Node($value);
        $newNode->setReferences(null, $this->head());

        $this->changeHead($newNode);
        $this->changeTailIfNeeded($newNode);
        $this->incrementCount();

        return $newNode;
    }

    /**
     * Remove the first node (head).
     * 
     * @throws LogicException
     * @return Node The removed node.
     */
    public function removeFirst()
    {
        if ($this->count() < 1) {
            throw new LogicException('Cannot remove from an empty list.');	
        }

        $initialCount = $this->count();
        $removedNode = $this->head();
        $nextNode = null;

        if ($this->headHasNextItem()) { // The head has next.
            $nextNode = $this->head()->next();
            $nextNode->setPrev(null);
        }

        $this->setHead($nextNode);

        if ($initialCount == 1) {
            $this->setTail(null);
        }

        $this->decrementCount();

        return $removedNode;
    }

    /**
     * Add an item to the end of the list.
     * 
     * @param mixed $value
     * @return Node
     */
    public function addLast($value)
    {
        $newNode = new Node($value);

        if ($this->tail()) {
            $this->tail()->setNext($newNode);
            $this->setTail($newNode);
        } else {
            $this->setHead($newNode);
            $this->setTail($newNode);
        }

        $newNode->setReferences($this->tail(), null);

        $this->incrementCount();

        return $newNode;
    }

    /**
     * Remove the last node (tail).
     * 
     * @throws LogicException
     * @return Node
     */
    public function removeLast()
    {
        if ($this->count() < 1) {
            throw new LogicException('Cannot remove from an empty list.');	
        }

        $initialCount = $this->count();
        $removedNode = $this->tail();
        $prevNode = null;

        if ($this->tailHasPrevItem()) {
            $prevNode = $this->tail()->prev();
            $prevNode->setNext(null);
        }

        $this->setTail($prevNode);

        if ($initialCount == 1) {
            $this->setHead(null);
        }

        $this->decrementCount();

        return $removedNode;
    }

    /**
     * Remove an item from the list (by node reference or value).
     * 
     * @param Node|mixed $removable
     * @return Node
     */
    public function remove($removable)
    {
        if ($removable instanceof Node)	 {
            return $this->removeByNode($removable);
        }

        return $this->removeByValue($removable);
    }

    /**
     * Remove from the list by value.
     * 
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return Node
     */
    public function removeByValue($value)
    {
        // If the tail is the node with the provided value, remove the tail.
        if ($this->tail() && $this->tail()->value() === $value) {
            return $this->removeByNode($this->tail());
        }

        $currentNode = $this->head();

        if ($currentNode && $currentNode->value() === $value) {
            return $this->removeByNode($currentNode);
        }

        while ($currentNode) {
            if ($currentNode->value() === $value) {
                return $this->removeByNode($currentNode);
            }

            $currentNode = $currentNode->next();
        }

        throw new InvalidArgumentException("The value {$value} could not be located in the list.");
    }

    /**
     * Remove from the list by node object.
     * 
     * @param Node $node
     * @throws InvalidArgumentException
     * @return Node
     */
    public function removeByNode(Node $node)
    {
        // If the tail is the provided node to be removed, remove the tail.
        if ($this->tail() && $this->tail() == $node) {
            return $this->removeLast($this->tail());
        }

        $currentNode = $this->head();

        if ($currentNode && $currentNode == $node) {
            return $this->removeFirst();
        }

        while ($currentNode) {
            if ($currentNode == $node) {
                // remove the node
                $prevNode = $currentNode->prev();
                $nextNode = $currentNode->next();

                $prevNode->setNext($nextNode);
                $nextNode->setPrev($prevNode);

                $this->decrementCount();

                return $currentNode;
            }

            $currentNode = $currentNode->next();
        }

        throw new InvalidArgumentException('The provided node does not exist in the list.');
    }

    /**
     * Iterate over the list.
     *
     * @param Callable $callback
     * @return void
     */
    public function forEach(Callable $callback) {
        if ($this->count() < 1) {
            throw new LogicException('Cannot iterate an empty list.');
        }

        $currentNode = $this->head();
        $index = 0;

        while($currentNode) {
            call_user_func_array($callback, [$currentNode, $index]);

            $currentNode = $currentNode->next();
            $index++;
        }
    }
}
