<?php

declare(strict_types=1);

namespace DataType\Create;


use Symfony\Component\HttpFoundation\Request;
use DataType\DataStorage\ArrayDataStorage;
use DataType\Exception;
use DataTypeForSymfony\SymfonyRequestVarMap;
use function DataType\createOrError;
use function DataType\getInputTypeListForClass;

/**
 * Creates a DataType from a Symfony request
 *
 * Returns two values, the DataType created or null and an array of ValidationProblems if there were any.
 */
trait CreateOrErrorFromRequest
{
    /**
     * @param Request $request
     * @return array{0:?object, 1:\DataType\ValidationProblem[]}
     * @throws Exception\DataTypeException
     * @throws Exception\ValidationException
     */
    public static function createOrErrorFromRequest(Request $request)
    {
        $variableMap = new SymfonyRequestVarMap($request);
        $inputTypeList = getInputTypeListForClass(self::class);
        $dataStorage = ArrayDataStorage::fromArray($variableMap->toArray());

        return createOrError(static::class, $inputTypeList, $dataStorage);
    }
}
