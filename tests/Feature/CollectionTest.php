<?php

use Awj\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @var Collection $collection */
    public $collection;

    public function setUp()
    {
        $this->collection = Collection::new();
    }

    /** @test */
    public function it_must_implement_array_access()
    {
        $this->assertInstanceOf(ArrayAccess::class, $this->collection);
    }

    /** @test */
    public function it_must_implement_countable()
    {
        $this->assertInstanceOf(Countable::class, $this->collection);
    }

    /** @test */
    public function it_can_be_empty()
    {
        $this->assertEmpty($this->collection);
    }

    /** @test */
    public function can_have_items_added_to_it()
    {
        $this->collection->push('item');

        $this->assertNotEmpty($this->collection);
    }

    /** @test */
    public function it_can_have_multiple_items_added()
    {
        $this->collection
            ->push('item')
            ->push('another_item');

        $this->assertCount(2, $this->collection);
    }

    /** @test */
    public function it_can_return_the_first_item()
    {
        $this->collection
            ->push('item')
            ->push('another_item')
            ->push('yet_another_item');

        $firstItem = $this->collection->first();

        $this->assertEquals('item', $firstItem);
    }

    /** @test */
    public function it_can_return_the_last_item()
    {
        $this->collection
            ->push('item')
            ->push('another_item')
            ->push('yet_another_item');

        $firstItem = $this->collection->last();

        $this->assertEquals('yet_another_item', $firstItem);
    }

    /** @test */
    public function it_behaves_like_an_array()
    {
        $this->collection
            ->push('item')
            ->push('another_item')
            ->push('yet_another_item');

        $this->assertEquals(3, count($this->collection));

        $this->collection[] = 'even_yet_another_item';

        $this->assertEquals(4, $this->collection->count());

        $this->collection[0] = 'not_an_item';

        $this->assertEquals('not_an_item', $this->collection[0]);

        unset($this->collection[1]);

        $this->assertEquals(3, $this->collection->count());
        $this->assertFalse(isset($this->collection[1]));
    }

    /** @test */
    public function it_can_convert_an_array_to_collection()
    {
        $collection = Collection::new(['item', 'item2']);

        $this->assertCount(2, $collection);

        $this->assertEquals('item', $collection->first());

        $this->assertEquals('item2', $collection->last());
    }

    /** @test */
    public function it_can_convert_a_non_array_to_collection()
    {
        $collection = Collection::new('this_is_not_an_array');

        $this->assertCount(1, $collection);

        $item = $collection->first();

        $this->assertEquals('this_is_not_an_array', $item);
    }

    /** @test */
    public function it_can_be_reversed()
    {
        $this->collection
            ->push('item')
            ->push('another_item')
            ->push('yet_another_item');

        $this->collection = $this->collection->reverse();

        $this->assertEquals('yet_another_item', $this->collection->first());
        $this->assertEquals('item', $this->collection->last());
    }

    /** @test */
    public function it_can_return_a_random_item()
    {
        $array = ['item', 'item2', 'item3', 'item4', 'item5'];

        $this->collection = Collection::new($array);

        $item = $this->collection->random();

        $this->assertTrue(in_array($item, $array));
    }

    /** @test */
    public function it_can_return_a_specific_item()
    {
        $array = ['item', 'item2', 'item3', 'item4', 'key' => 'item5'];

        $this->collection = Collection::new($array);

        $item = $this->collection->get(3);

        $this->assertEquals('item4', $item);

        $item = $this->collection->get('key');

        $this->assertEquals('item5', $item);
    }

    /** @test */
    public function it_can_pop_an_item()
    {
        $array = ['item', 'item2', 'item3', 'item4', 'key' => 'item5'];

        $this->collection = Collection::new($array);

        $item = $this->collection->pop();

        $this->assertCount(4, $this->collection);
        $this->assertEquals('item5', $item);
    }

    /** @test */
    public function it_can_shift_an_item()
    {
        $array = ['item', 'item2', 'item3', 'item4', 'key' => 'item5'];

        $this->collection = Collection::new($array);

        $item = $this->collection->shift();

        $this->assertCount(4, $this->collection);
        $this->assertEquals('item', $item);
    }

    /** @test */
    public function it_can_iterate_though_all_elements()
    {
        $array = ['item1', 'item2', 'item3', 'item4', 'item5'];

        $this->collection = Collection::new($array);

        $this->collection->each(function ($item) use ($array) {
            $this->assertTrue(in_array($item, $array));
        });
    }

    /** @test */
    public function it_can_map_all_elements_without_keys()
    {
        $array = ['item1', 'item2', 'item3', 'item4', 'item5'];
        $result = ['item1_modified', 'item2_modified', 'item3_modified', 'item4_modified', 'item5_modified'];
        $this->collection = Collection::new($array);

        $collection = $this->collection->map(function ($item) use ($result) {
            return $item .= '_modified';
        });

        $result = Collection::new($result);

        $this->assertEquals($collection, $result);
        $this->assertInstanceOf(Collection::class, $collection);
    }

    /** @test */
    public function it_can_be_converted_to_array()
    {
        $array = ['item1', 'item2', 'item3', 'item4', 'item5'];
        $this->collection = Collection::new($array);

        $result = $this->collection->toArray();

        $this->assertEquals($result, $array);
    }

    /** @test */
    public function it_can_filter_the_collection()
    {
        $array = ['item1', 'item2', 'item3'];
        $collection = Collection::new($array);

        $result = $collection->filter(function ($item) {
            return $item == "item2";
        });

        $this->assertCount(1, $result);
        $this->assertEquals('item2', $result->first());
    }

    public function it_can_reduce_the_collection()
    {
        $array = [1, 2, 3];
        $collection = Collection::new($array);

        $result = $collection->reduce(function ($accumulator, $item) {
            $accumulator += $item;

            return $accumulator;
        });

        $this->assertEquals(6, $result->first());
    }
}
