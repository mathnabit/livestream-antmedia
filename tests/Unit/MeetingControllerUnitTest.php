<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\MeetingController;
use Carbon\Carbon;
use ReflectionMethod;

class MeetingControllerUnitTest extends TestCase
{
    // Test formatDuration method
    public function test_formatDuration()
    {
        // Create a ReflectionMethod to access the private method
        $controller = new MeetingController();
        $method = new ReflectionMethod($controller, 'formatDuration');
        $method->setAccessible(true);

        // Call the method with a test duration
        $result = $method->invoke($controller, 5761000); 

        // Check the result
        $this->assertEquals('01:36:01', $result);
    }

    // Test formatStartTime method
    public function test_formatStartTime()
    {

        $controller = new MeetingController();
        $method = new ReflectionMethod($controller, 'formatStartTime');
        $method->setAccessible(true);

        // Call the method with a test timestamp
        $startTime = 1736368250000; 
        $result = $method->invoke($controller, $startTime);

        // Check the result
        $expected = Carbon::createFromTimestampMs($startTime)->toDateTimeString('minute');
        $this->assertEquals($expected, $result);
    }
}
