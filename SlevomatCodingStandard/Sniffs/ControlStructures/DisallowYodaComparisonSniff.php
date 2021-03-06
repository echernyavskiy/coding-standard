<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\YodaHelper;
use const T_IS_EQUAL;
use const T_IS_IDENTICAL;
use const T_IS_NOT_EQUAL;
use const T_IS_NOT_IDENTICAL;
use function count;

/**
 * Bigger value must be on the left side:
 *
 * ($variable, Foo::$class, Foo::bar(), foo())
 *  > (Foo::BAR, BAR)
 *  > (true, false, null, 1, 1.0, arrays, 'foo')
 */
class DisallowYodaComparisonSniff implements Sniff
{

	public const CODE_DISALLOWED_YODA_COMPARISON = 'DisallowedYodaComparison';

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_IS_IDENTICAL,
			T_IS_NOT_IDENTICAL,
			T_IS_EQUAL,
			T_IS_NOT_EQUAL,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $comparisonTokenPointer
	 */
	public function process(File $phpcsFile, $comparisonTokenPointer): void
	{
		$tokens = $phpcsFile->getTokens();
		$leftSideTokens = YodaHelper::getLeftSideTokens($tokens, $comparisonTokenPointer);
		$rightSideTokens = YodaHelper::getRightSideTokens($tokens, $comparisonTokenPointer);
		$leftDynamism = YodaHelper::getDynamismForTokens($tokens, $leftSideTokens);
		$rightDynamism = YodaHelper::getDynamismForTokens($tokens, $rightSideTokens);

		if ($leftDynamism === null || $rightDynamism === null) {
			return;
		}

		if ($leftDynamism >= $rightDynamism) {
			return;
		}

		$fix = $phpcsFile->addFixableError('Yoda comparisons are disallowed.', $comparisonTokenPointer, self::CODE_DISALLOWED_YODA_COMPARISON);
		if (!$fix || count($leftSideTokens) === 0 || count($rightSideTokens) === 0) {
			return;
		}

		YodaHelper::fix($phpcsFile, $leftSideTokens, $rightSideTokens);
	}

}
