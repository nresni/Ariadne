<?php
namespace Ariadne\Tests\Unit\Mapping;

use Ariadne\Mapping\ClassMetadata;

/**
 * Test for ClassMetadata
 *
 * @author dstendardi
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @cover ClassMetadata::__construct
     */
    public function testConstructor()
    {
        $meta = new ClassMetadata('foo');

        $this->assertEquals('foo', $meta->getClassName(), 'constructor set the class name property');
    }

    /**
     * @test
     * @cover ClassMetadata::__sleep
     */
    public function testSleep()
    {
        $meta = new ClassMetadata('foo');

        $this->assertEquals(array('className', 'fields', 'embeddedsMetadata', 'embeds'), $meta->__sleep(), 'sleep returns the corrects property list');
    }

    /**
     * @test
     * @cover ClassMetadata::addField
     */
    public function testAddField()
    {
        $meta = new ClassMetadata('foo');

        $field = $this->getMockBuilder('Ariadne\Mapping\Element\Field')->disableOriginalConstructor()->disableOriginalClone()->getMock();

        $meta->addField('foo', $field);

        $this->assertEquals(array('foo' => $field), $meta->getFields(), 'field is properly added to the associated member');
    }

    /**
     * @test
     * @cover ClassMetadata::getFieldMetadata
     */
    public function testGetFieldMetadata()
    {
        $meta = new ClassMetadata('foo');

        $field = $this->getMockBuilder('Ariadne\Mapping\Element\Field')->disableOriginalConstructor()->disableOriginalClone()->getMock();

        $meta->addField('foo', $field);

        $this->assertEquals($field, $meta->getFieldMetadata('foo'), 'getFieldMetadata returns the proper element');
    }
}