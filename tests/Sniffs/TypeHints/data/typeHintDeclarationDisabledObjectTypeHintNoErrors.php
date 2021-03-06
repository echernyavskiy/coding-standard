<?php

namespace FooNamespace;

abstract class FooClass
{

	/**
	 * @return object|null
	 */
	abstract public function withNullableReturnTypeHint();

	/**
	 * @param null|object $a
	 */
	public function withNullableParameterTypeHint($a)
	{

	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 * @return object|null
	 */
	public function withReturnTypeHintSuppress()
	{
		return null;
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param object|null $a
	 */
	public function withParameterTypeHintSuppress($a)
	{
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.UselessDocComment
	 * @param object|null $a
	 */
	public function withNullableParameterTypeHintAndSuppressedUselessDocComment(?object $a)
	{
	}

	/**
	 * @return object[]|null
	 */
	public function returnsNullableArrayOfObjects(): ?array
	{
		return [];
	}

}
