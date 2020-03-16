<?php

use App\Http\Controllers\NameController;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\MockObject\MockObject;

class NameTest extends TestCase
{
    /**
     * Test for checking JsonResponse output
     * @see NameController::show()
     */
    public function testShowReturnsJsonResponse()
    {
        $nameMock = $this->createNameControllerMock();

        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn(new stdClass());

        $data = $nameMock->show('sampleString');
        $this->assertInstanceOf(JsonResponse::class, $data);
    }

    /**
     * Returns Mock for NameController
     * @param array $originalMethods
     * @return MockObject|NameController
     */
    private function createNameControllerMock(array $originalMethods = ['searchLastNameAndGetFullNameFor']): MockObject
    {
        return $this->getMockBuilder(NameController::class)
            ->setMethods($originalMethods)
            ->getMock();
    }

    /**
     * Test for checking JsonResponse output
     * @see NameController::show()
     */
    public function testShowReturnsErrorJsonResponse()
    {
        $nameMock = $this->createNameControllerMock();

        $wrongCollectionStub = $this->createStub(\Illuminate\Database\Eloquent\Collection::class);
        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn($wrongCollectionStub);

        $this->expectException(InvalidArgumentException::class);
        $nameMock->show('sampleString');
    }

    /**
     * Test for valid terms
     * @see NameController::show()
     */
    public function testShowReturnsJsonResponseForValidTerms()
    {
        $nameMock = $this->createNameControllerMock();

        $term = 'Strokes';
        $name1 = 'Emma ' . $term;
        $name2 = 'test ' . $term;
        $returnVal = $this->mockSearchLastNameAndGetFullNameForOutput($name1, $name2);
        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn($returnVal);

        $data = $nameMock->show($term);

        $expected = new JsonResponse(['data' => [$name1, $name2]]);

        $this->assertInstanceOf(JsonResponse::class, $data);
        $this->assertEquals($expected, $data);
    }

    /**
     * Returns fake object instead of Collection
     * @param $name1
     * @param $name2
     * @return object
     */
    private function mockSearchLastNameAndGetFullNameForOutput($name1, $name2)
    {
        $name1Obj = new stdClass();
        $name1Obj->fullname = $name1;

        $name2Obj = new stdClass();
        $name2Obj->fullname = $name2;

        $a = [$name1Obj, $name2Obj];
        return (object)$a;
    }

    /**
     * Test for empty terms
     * @see NameController::show()
     */
    public function testShowReturnsJsonResponseForEmptyTerms()
    {
        $nameMock = $this->createNameControllerMock();

        $term = '';
        $name1 = 'Emma ' . $term;
        $name2 = 'test ' . $term;
        $returnVal = $this->mockSearchLastNameAndGetFullNameForOutput($name1, $name2);
        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn($returnVal);

        $data = $nameMock->show($term);

        $expected = new JsonResponse(['data' => [$name1, $name2]]);

        $this->assertInstanceOf(JsonResponse::class, $data);
        $this->assertEquals($expected, $data);
    }

    /**
     * Test for Dupes true
     * @see NameController::show()
     */
    public function testShowReturnsJsonResponseForDupesTrue()
    {
        $nameMock = $this->createNameControllerMock();

        $term = 'Strokes';
        $name1 = 'Emma ' . $term;
        $name2 = 'Emma ' . $term;   //duplicate name
        $returnVal = $this->mockSearchLastNameAndGetFullNameForOutput($name1, $name2);
        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn($returnVal);

        $data = $nameMock->show($term, true);

        $expected = new JsonResponse(['data' => [$name1]]);

        $this->assertInstanceOf(JsonResponse::class, $data);
        $this->assertEquals($expected, $data);
    }

    /**
     * Test for Dupes false
     * @see NameController::show()
     */
    public function testShowReturnsJsonResponseForDupesFalse()
    {
        $nameMock = $this->createNameControllerMock();

        $term = 'Strokes';
        $name1 = 'Emma ' . $term;
        $name2 = 'Emma ' . $term;   //duplicate name
        $returnVal = $this->mockSearchLastNameAndGetFullNameForOutput($name1, $name2);
        $nameMock->method('searchLastNameAndGetFullNameFor')
            ->willReturn($returnVal);

        $data = $nameMock->show($term, false);

        $expected = new JsonResponse(['data' => [$name1, $name2]]);

        $this->assertInstanceOf(JsonResponse::class, $data);
        $this->assertEquals($expected, $data);
    }
}
