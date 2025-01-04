<?php
declare(strict_types=1);

namespace Ecl\Test\TestCase\Validation;

use Cake\TestSuite\TestCase;
use Ecl\Validation\Password;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

/**
 * Password tests
 */
#[UsesClass(Password::class)]
#[CoversClass(Password::class)]
class PasswordTest extends TestCase
{
    public function testMinimalLowercase()
    {
        $success = Password::minimalLowercase('AbC;eF', 3);
        self::assertFalse($success);
        $success = Password::minimalLowercase('AbC;eF', 2);
        self::assertTrue($success);
    }

    public function testMinimalUppercase()
    {
        $success = Password::minimalUppercase('abC;eF', 3);
        self::assertFalse($success);
        $success = Password::minimalUppercase('abC;eF', 2);
        self::assertTrue($success);
    }

    public function testMinimalDigit()
    {
        $success = Password::minimalDigit('ab1;2ce', 3);
        self::assertFalse($success);
        $success = Password::minimalDigit('ab1;2ce', 2);
        self::assertTrue($success);
    }

    public function testMinimalSymbol()
    {
        $success = Password::minimalSymbol('ab!1;2ce', 3);
        self::assertFalse($success);
        $success = Password::minimalSymbol('ab!1;2ce', 2);
        self::assertTrue($success);
    }

    public function testValidateLowers()
    {
        $success = Password::validateLowers('abc', 'abd');
        self::assertFalse($success);
        $success = Password::validateLowers('abcdefghijkmnopqrstuvwxyz', []);
        self::assertTrue($success);
    }

    public function testValidateUppers()
    {
        $success = Password::validateUppers('ABC', 'ABD');
        self::assertFalse($success);
        $success = Password::validateUppers('ABCDEFGHJKLMNPQRSTUVWXYZ');
        self::assertTrue($success);
    }

    public function testValidateDigits()
    {
        $success = Password::validateDigits('123', '124');
        self::assertFalse($success);
        $success = Password::validateDigits('1234567890');
        self::assertTrue($success);
    }

    public function testValidateSymbols()
    {
        $success = Password::validateSymbols('%!:*', '!:%');
        self::assertFalse($success);
        $success = Password::validateSymbols('!*#+=:,-_?');
        self::assertTrue($success);
    }
}
