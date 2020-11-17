<?php

/*
 * This file is part of PHPUnit Good Practices.
 *
 * (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PHPUnitGoodPractices\Tests;

use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;
use PHPUnitGoodPractices\PositiveOverNegativeCountTrait;

/**
 * @covers \PHPUnitGoodPractices\PositiveOverNegativeCountTrait
 */
final class PositiveOverNegativeCountTraitTest extends TestCase
{
    use PositiveOverNegativeCountTrait;

    public $fixtureAttributePositive = array(11);
    public $fixtureAttributeZero = array();

    public function expectException($exception)
    {
        if (is_callable(array('parent', 'expectException'))) {
            parent::expectException($exception);
        } else {
            $this->setExpectedException($exception);
        }
    }

    /**
     * @param array $data
     * @param int   $expected
     * @param bool  $shouldCrash
     *
     * @dataProvider provideAssertCountCases
     */
    public function testAssertCount($data, $expected, $shouldCrash)
    {
        if ($shouldCrash) {
            $this->expectException(Warning::class);
        }

        $this->assertCount($expected, $data);
    }

    public function provideAssertCountCases()
    {
        return array(
            array(array('foo', 'bar'), 2, false),
            array(array(), 0, false),
            array(array(), -2, true),
        );
    }

    /**
     * @param array $data
     * @param int   $expected
     * @param bool  $shouldCrash
     *
     * @dataProvider provideAssertNotCountCases
     */
    public function testAssertNotCount($data, $expected, $shouldCrash)
    {
        if ($shouldCrash) {
            $this->expectException(Warning::class);
        }

        $this->assertNotCount($expected, $data);
    }

    public function provideAssertNotCountCases()
    {
        return array(
            array(array('foo', 'bar'), -2, false),
            array(array(), 10, false),
            array(array(), -2, true),
        );
    }

    /**
     * @param string $key
     * @param int    $expected
     * @param bool   $shouldCrash
     *
     * @dataProvider provideAssertAttributeCountCases
     */
    public function testAssertAttributeCount($key, $expected, $shouldCrash)
    {
        if ($shouldCrash) {
            $this->expectException(Warning::class);
        }

        $this->assertAttributeCount($expected, $key, $this);
    }

    public function provideAssertAttributeCountCases()
    {
        return array(
            array('fixtureAttributePositive', count($this->fixtureAttributePositive), false),
            array('fixtureAttributeZero', count($this->fixtureAttributeZero), false),
            array('fixtureAttributeZero', -1, true),
        );
    }

    /**
     * @param string $key
     * @param int    $expected
     * @param bool   $shouldCrash
     *
     * @dataProvider provideAssertAttributeCountCases
     */
    public function testAssertAttributeNotCount($key, $expected, $shouldCrash)
    {
        if ($shouldCrash) {
            $this->expectException(Warning::class);
        }

        $this->assertAttributeNotCount($expected, $key, $this);
    }

    public function provideAssertAttributeNotCountCases()
    {
        return array(
            array('fixtureAttributePositive', 10 + count($this->fixtureAttributePositive), false),
            array('fixtureAttributeZero', 10 + count($this->fixtureAttributeZero), false),
            array('fixtureAttributeZero', -1, true),
        );
    }
}
