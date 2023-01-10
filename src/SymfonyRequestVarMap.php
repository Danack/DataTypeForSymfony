<?php

namespace DataTypeForSymfony;


use VarMap\Exception\VariableMissingException;
use Symfony\Component\HttpFoundation\Request;
use VarMap\VarMap;

class SymfonyRequestVarMap implements VarMap
{
    /** @var Request */
    private $serverRequest;

    public function __construct(Request $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }

    /**
     * @inheritdoc
     */
    public function getWithDefault(string $variableName, $defaultValue)
    {
        if ($this->serverRequest->query->has($variableName) === true) {
            return $this->serverRequest->query->get($variableName);
        }

        static $parametersAsArray = null;

        if ($parametersAsArray === null) {
            if ($content = $this->serverRequest->getContent()) {
                $parametersAsArray = json_decode($content, true);
                if (is_array($parametersAsArray) &&
                    array_key_exists($variableName, $parametersAsArray) === true) {
                    return $parametersAsArray[$variableName];
                }
            }
        }

        return $defaultValue;
    }

    /**
     * @inheritdoc
     */
    public function has(string $variableName) : bool
    {
        $queryHasIt = $this->serverRequest->query->has($variableName);
        if ($queryHasIt === true) {
            return true;
        }

        static $parametersAsArray = null;

        if ($parametersAsArray === null) {
            if ($content = $this->serverRequest->getContent()) {
                $parametersAsArray = json_decode($content, true);
                if (is_array($parametersAsArray) &&
                    array_key_exists($variableName, $parametersAsArray) === true) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function get(string $variableName)
    {
        if ($this->serverRequest->query->has($variableName) === true) {
            return $this->serverRequest->query->get($variableName);
        }

        static $parametersAsArray = null;

        if ($parametersAsArray === null) {
            if ($content = $this->serverRequest->getContent()) {
                $parametersAsArray = json_decode($content, true);
                if (is_array($parametersAsArray) &&
                    array_key_exists($variableName, $parametersAsArray) === true) {
                    return $parametersAsArray[$variableName];
                }
            }
        }

        throw VariableMissingException::create($variableName);
    }

    /**
     * @inheritdoc
     */
    public function getNames()
    {
        $params = $this->serverRequest->query->all();

        $params = array_keys($params);

        static $parametersAsArray = null;
        if ($parametersAsArray === null) {
            if ($content = $this->serverRequest->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
        }

        if (is_array($parametersAsArray) === true) {
            $params = array_merge($params, array_keys($parametersAsArray));
        }

        return $params;
    }

    public function toArray(): array
    {
        $params = $this->serverRequest->query->all();

        static $parametersAsArray = null;
        if ($parametersAsArray === null) {
            if ($content = $this->serverRequest->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
        }

        if (is_array($parametersAsArray) === true) {
            foreach ($parametersAsArray as $key => $value) {
                $params[$key] = $value;
            }
        }

        return $params;
    }
}
