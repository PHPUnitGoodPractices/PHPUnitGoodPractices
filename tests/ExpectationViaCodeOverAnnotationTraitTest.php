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

use PHPUnit\Framework\TestCase;
use PHPUnitGoodPractices\ExpectationViaCodeOverAnnotationTrait;
use PHPUnitGoodPractices\Reporter;

/**
 * @covers \PHPUnitGoodPractices\ExpectationViaCodeOverAnnotationTrait
 */
final class ExpectationViaCodeOverAnnotationTraitTest extends TestCase
{
    use ExpectationViaCodeOverAnnotationTrait;
    use HelperTrait;

    public function getName($withDataSet = true)
    {
        // partial mock for `testSetExpectedExceptionFromAnnotation` test
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
            if (
                'PHPUnitGoodPractices\Tests\ExpectationViaCodeOverAnnotationTraitTest' === $trace['class'] &&
                'testSetExpectedExceptionFromAnnotation' === $trace['function']
            ) {
                return 'fixture';
            }
        }

        return parent::getName($withDataSet);
    }

    /**
     * @expectedException \Exception
     */
    public function fixture()
    {
    }

    public function testSetExpectedExceptionFromAnnotation()
    {
        $counter = 0;
        $customReporter = function () use (&$counter) { ++$counter; };

        Reporter::setCustomReporter($customReporter);

        $this->setExpectedExceptionFromAnnotation();

        $this->assertSame(1, $counter);

        Reporter::clearCustomReporter();
    }

    public function testExpectException()
    {
        $this->markTestSkippedIfPHPUnitMethodIsMissing('expectException');

        $this->expectException('Exception');

        throw new \Exception();
    }

    public function testSetExpectedException()
    {
        $this->markTestSkippedIfPHPUnitMethodIsMissing('setExpectedException');

        $this->setExpectedException('Exception');

        throw new \Exception();
    }
}