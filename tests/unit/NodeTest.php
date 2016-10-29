<?php

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /** @test */
    public function it_can_set_nodes_value()
    {
        $node = new Node(5);

        $this->assertEquals(5, $node->value());
    }

    /** @test */
    public function it_can_keep_reference_to_the_next_node()
    {
        $node = new Node(5);

        $nextNode = $node->setNext(new Node(6))->next();

        $this->assertInstanceOf(Node::class, $nextNode);
    }

    /** @test */
    public function it_can_keep_reference_to_the_previous_node()
    {
        $node = new Node(5);

        $prevNode = $node->setPrev(new Node(6))->prev();

        $this->assertInstanceOf(Node::class, $prevNode);
    }

    /** @test */
    public function it_can_add_prev_and_next_simultaneously()
    {
        $node = new Node(2);
        $prev = new Node(1);
        $next = new Node(3);

        $node->setReferences($prev, $next);

        $this->assertEquals(1, $node->prev()->value());
        $this->assertEquals(3, $node->next()->value());
    }
}
