<?php

declare(strict_types=1);

namespace DataTypeForSymfony\Create;

use Symfony\Component\HttpFoundation\Request;
use DataType\DataStorage\ArrayDataStorage;
use DataTypeForSymfony\SymfonyRequestVarMap;
use function DataType\create;
use function DataType\getInputTypeListForClass;

/**
 * Creates a DataType from a Symfony request or throws a ValidationException if there is a
 * a problem validating the data.
 */
trait CreateFromRequest
{
    /**
     * @param Request $request
     * @return self
     * @throws \DataType\Exception\ValidationException
     */
    public static function createFromRequest(Request $request)
    {
        $variableMap = new SymfonyRequestVarMap($request);
        $inputTypeList = getInputTypeListForClass(self::class);
        $dataStorage = ArrayDataStorage::fromArray($variableMap->toArray());

        $object = create(static::class, $inputTypeList, $dataStorage);
        /** @var $object self */
        return $object;
    }
}
