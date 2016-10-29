<?php

use PHPUnit\Framework\TestCase;

class DoublyLinkedListTest extends TestCase
{
    /** @test */
    public function it_can_increment_count()
    {
        $dl = new DoublyLinkedList;

        $dl->addFirst(new Node(1));

        $this->assertEquals(1, $dl->count());

        $dl->addFirst(new Node(1));

        $this->assertEquals(2, $dl->count());
    }

    /** @test */
    public function it_can_decrement_count()
    {
        $dl = new DoublyLinkedList;

        $dl->addLast(1);

        $this->assertEquals(1, $dl->count());

        $dl->addFirst(2);

        $this->assertEquals(2, $dl->count());
    }
    
    /** @test */
    public function it_can_change_head()
    {
    	$dl = new DoublyLinkedList();
    	
    	$this->assertEmpty($dl->head());
    	
    	$dl->addFirst(1);
    	
    	$this->assertInstanceOf(Node::class, $dl->head());
    	$this->assertEmpty($dl->head()->prev());
    	$this->assertEmpty($dl->head()->next());
    	
    	$dl->addFirst(2);
    	
    	$this->assertInstanceOf(Node::class, $dl->head()->next());
    	$this->assertEmpty($dl->head()->prev());
    }
    
    /** @test */
    public function it_can_change_tail_if_needed()
    {
    	$dl = new DoublyLinkedList();
    	
    	$this->assertEmpty($dl->tail());
    	
    	$firstNode = $dl->addFirst(1);
    	
    	$this->assertInstanceOf(Node::class, $dl->tail());
    	$this->assertEmpty($dl->tail()->prev());
    	$this->assertEmpty($dl->tail()->next());
    	
    	$secondNode = $dl->addFirst(2);
    	
    	$this->assertEmpty(null, $secondNode->prev()); // because it's first
    	$this->assertInstanceOf(Node::class, $secondNode->next());
    }

    /** @test */
    public function it_can_add_first_item() 
    {
        $dl = new DoublyLinkedList();

        /** First addition. */

        $dl->addFirst(1);
        $headValueFirst = $dl->head()->value();

        // Assert the head's value is correct.
        $this->assertEquals(1, $headValueFirst);
        // Assert the prev/next of the head/tail is set to null.
        $this->assertEquals(null, $dl->head()->prev());
        $this->assertEquals(null, $dl->head()->next());
        $this->assertEquals(null, $dl->tail()->prev());
        $this->assertEquals(null, $dl->tail()->next());

        /** Second addition. */

        $dl->addFirst(2);
        $headValueSecond = $dl->head()->value();

        // Assert the value of the newly added node is correct.
        $this->assertEquals(2, $headValueSecond);
        // Assert the value of the new head is correct.
        $this->assertEquals($headValueSecond, $dl->head()->value());
        // Assert the value of the tail is set correct (to the old head, because we have only two nodes, won't be like this if we had more nodes).
        $this->assertEquals($headValueFirst, $dl->tail()->value());
        // Assert the prev of the tail is set to the new node (won't be valid if third element is added).
        $this->assertEquals($headValueSecond, $dl->tail()->prev()->value());
        // Assert the prev/next of the new head/tail is correct.
        $this->assertEquals(null, $dl->head()->prev());
        $this->assertInstanceOf(Node::class, $dl->head()->next());
        $this->assertInstanceOf(Node::class, $dl->tail()->prev());
        $this->assertEquals(null, $dl->tail()->next());

        /** Third addition */

        $dl->addFirst(3);
        $headValueThird = $dl->head()->value();

        $this->assertEquals(3, $headValueThird);
        $this->assertEquals(1, $dl->tail()->value());
        $this->assertEquals(2, $dl->head()->next()->value());
        // Assert the second node points to the first node (head).
        $this->assertEquals(3, $dl->head()->next()->prev()->value());
        // Assert the second node points to the last node (tail).
        $this->assertEquals(1, $dl->head()->next()->next()->value());
    }
    
    /** @test */
    public function it_can_add_last_item()
    {
    	$dl = new DoublyLinkedList();
    	
    	$dl->addLast(1);
    	
    	$this->assertInstanceOf(Node::class, $dl->head());
    	$this->assertEquals(1, $dl->head()->value());
    	$this->assertInstanceOf(Node::class, $dl->tail());
    }
    
    /** @test */
    public function it_can_remove_first_item()
    {
    	$dl = new DoublyLinkedList();
    	
    	$dl->addFirst(1);
    	$dl->addFirst(2);
    	$dl->addFirst(3);
    	$dl->addFirst(4);
    	$dl->addFirst(5);
    	
    	$dl->removeFirst();
    	
    	$this->assertEquals(4, $dl->count());
    	$this->assertEquals(4, $dl->head()->value());

    	$dl2 = new DoublyLinkedList();
    	
    	$dl2->addFirst(1);

    	$dl2->removeFirst();
    	
    	$this->assertEquals(0, $dl2->count());
    	$this->assertEmpty($dl2->head());
    	$this->assertEmpty($dl2->tail());
    }
    
    /** @test */
    public function it_can_remove_last_item()
    {
    	$dl = new DoublyLinkedList();
    	
    	$dl->addFirst(1);
    	$dl->addFirst(2);
    	$dl->addFirst(3);
    	$dl->addFirst(4);
    	$dl->addFirst(5);
    	
    	$dl->removeLast();
    	
    	$this->assertEquals(4, $dl->count());
    	$this->assertEquals(2, $dl->tail()->value());

    	$dl2 = new DoublyLinkedList();
    	
    	$dl2->addFirst(1);

    	$dl2->removeLast();
    	
    	$this->assertEquals(0, $dl2->count());
    	$this->assertEmpty($dl2->head());
    	$this->assertEmpty($dl2->tail());
    }

    /** @test */
    public function it_can_remove()
    {
    	$dl = new DoublyLinkedList();
    	
    	$firstNode = $dl->addFirst(1);
    	$secondNode = $dl->addFirst(2);
    	$thirdNode = $dl->addFirst(3);
    	
    	$dl->remove($secondNode);

        $this->assertEquals(2, $dl->count());
        $this->assertEquals(1, $dl->head()->next()->value());

        $dl->remove(3);

        $this->assertEquals(1, $dl->count());
        $this->assertEmpty($dl->head()->next());
        $this->assertEmpty($dl->head()->prev());

        $dl->remove(1);

        $this->assertEquals(0, $dl->count());
        $this->assertEmpty($dl->head());
        $this->assertEmpty($dl->tail());

        $this->expectException(InvalidArgumentException::class);
        $dl->remove(1);
    }
    
    /** @test */
    public function it_can_remove_by_node()
    {
    	$dl = new DoublyLinkedList();
    	
    	$firstNode = $dl->addFirst(1);
    	$secondNode = $dl->addFirst(2);
    	$thirdNode = $dl->addFirst(3);
    	
    	$dl->removeByNode($secondNode);
    	
    	$this->assertEquals(2, $dl->count());
        $this->assertEquals(1, $thirdNode->next()->value());
        $this->assertEquals(3, $firstNode->prev()->value());

        $dl->remove(1);
        $dl->remove(3);

        $this->expectException(InvalidArgumentException::class);
        $dl->remove(15);
    }

    /** @test */
    public function it_can_remove_by_value()
    {
    	$dl = new DoublyLinkedList();
    	
    	$firstNode = $dl->addFirst(1);
    	$secondNode = $dl->addFirst(2);
    	$thirdNode = $dl->addFirst(3);
    	
    	$dl->removeByValue(2);
    	
    	$this->assertEquals(2, $dl->count());
        $this->assertEquals(1, $thirdNode->next()->value());
        $this->assertEquals(3, $firstNode->prev()->value());
    }

    /** @test */
    public function it_can_iterate()
    {
        $dl = new DoublyLinkedList;

        $dl->addFirst('First item');
        $dl->addFirst('Second item');
        $dl->addFirst('Third item');

        $results = [];

        $dl->forEach(function ($node, $index) use (&$results) {
            $results[$index] = $node->value();
        });

        $this->assertEquals(3, count($results));

        $expected = [
            0 => 'Third item',
            1 => 'Second item',
            2 => 'First item',
        ];
        $this->assertEquals($expected, $results);
    }
}
