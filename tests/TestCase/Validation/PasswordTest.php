<?php
declare(strict_types=1);

namespace Ecl\Test\TestCase\Validation;

use Cake\TestSuite\TestCase;
use Ecl\Validation\Password;

/**
 * Class PasswordTest
 *
 * @package Ecl\Test\TestCase\Validation
 * @coversDefaultClass \Ecl\Validation\Password
 */
class PasswordTest extends TestCase
{
    /**
     * @test
     * @uses \Ecl\Validation\Password::minimalLowercase()
     * @covers ::minimalLowercase
     */
    public function testMinimalLowercase()
    {
        $success = Password::minimalLowercase('AbC;eF', 3);
        self::assertFalse($success);
        $success = Password::minimalLowercase('AbC;eF', 2);
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::minimalUppercase()
     * @covers ::minimalUppercase
     */
    public function testMinimalUppercase()
    {
        $success = Password::minimalUppercase('abC;eF', 3);
        self::assertFalse($success);
        $success = Password::minimalUppercase('abC;eF', 2);
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::minimalDigit()
     * @covers ::minimalDigit
     */
    public function testMinimalDigit()
    {
        $success = Password::minimalDigit('ab1;2ce', 3);
        self::assertFalse($success);
        $success = Password::minimalDigit('ab1;2ce', 2);
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::minimalSymbol()
     * @covers ::minimalSymbol
     */
    public function testMinimalSymbol()
    {
        $success = Password::minimalSymbol('ab!1;2ce', 3);
        self::assertFalse($success);
        $success = Password::minimalSymbol('ab!1;2ce', 2);
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::validateLowers()
     * @covers ::validateLowers
     */
    public function testValidateLowers()
    {
        $success = Password::validateLowers('abc', 'abd');
        self::assertFalse($success);
        $success = Password::validateLowers('abcdefghijkmnopqrstuvwxyz', []);
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::validateUppers()
     * @covers ::validateUppers
     */
    public function testValidateUppers()
    {
        $success = Password::validateUppers('ABC', 'ABD');
        self::assertFalse($success);
        $success = Password::validateUppers('ABCDEFGHJKLMNPQRSTUVWXYZ');
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::validateDigits()
     * @covers ::validateDigits
     */
    public function testValidateDigits()
    {
        $success = Password::validateDigits('123', '124');
        self::assertFalse($success);
        $success = Password::validateDigits('1234567890');
        self::assertTrue($success);
    }

    /**
     * @test
     * @uses \Ecl\Validation\Password::validateSymbols()
     * @covers ::validateSymbols
     */
    public function testValidateSymbols()
    {
        $success = Password::validateSymbols('%!:*', '!:%');
        self::assertFalse($success);
        $success = Password::validateSymbols('!*#+=:,-_?');
        self::assertTrue($success);
    }
}
