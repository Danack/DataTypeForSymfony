<?php

namespace DataTypeTest;

//use DataType\Exception\LogicExceptionData;
//use DataType\OpenApi\OpenApiV300ParamDescription;
//use DataType\Rule;
//use DataType\ValidationResult;
use PHPUnit\Framework\TestCase;
//use DataType\ProcessedValues;
//use DataType\OpenApi\ParamDescription;
//use Danack\PHPUnitHelper\StringTemplateMatching;
//use function \Danack\PHPUnitHelper\templateStringToRegExp;

/**
 * @coversNothing
 *
 * Allows checking that no code has output characters, or left the output buffer in a bad state.
 *
 */
class BaseTestCase extends TestCase
{
    use StringTemplateMatching;

}
