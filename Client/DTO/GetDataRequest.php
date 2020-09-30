<?php

/**
 * Class GetDataRequest
 */
class GetDataRequest
{
    /** @var string */
    private string $name;

    /** @var array */
    private array $array;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * @param array $array
     *
     * @return $this
     */
    public function setArray(array $array): self
    {
        $this->array = $array;

        return $this;
    }
}
