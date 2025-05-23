<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/type/decimal.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Type;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A representation of a decimal value, such as 2.5. Clients may convert values
 * into language-native decimal formats, such as Java's [BigDecimal][] or
 * Python's [decimal.Decimal][].
 * [BigDecimal]:
 * https://docs.oracle.com/en/java/javase/11/docs/api/java.base/java/math/BigDecimal.html
 * [decimal.Decimal]: https://docs.python.org/3/library/decimal.html
 *
 * Generated from protobuf message <code>google.type.Decimal</code>
 */
class Decimal extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The decimal value, as a string.
     * The string representation consists of an optional sign, `+` (`U+002B`)
     * or `-` (`U+002D`), followed by a sequence of zero or more decimal digits
     * ("the integer"), optionally followed by a fraction, optionally followed
     * by an exponent.
     * The fraction consists of a decimal point followed by zero or more decimal
     * digits. The string must contain at least one digit in either the integer
     * or the fraction. The number formed by the sign, the integer and the
     * fraction is referred to as the significand.
     * The exponent consists of the character `e` (`U+0065`) or `E` (`U+0045`)
     * followed by one or more decimal digits.
     * Services **should** normalize decimal values before storing them by:
     *   - Removing an explicitly-provided `+` sign (`+2.5` -> `2.5`).
     *   - Replacing a zero-length integer value with `0` (`.5` -> `0.5`).
     *   - Coercing the exponent character to lower-case (`2.5E8` -> `2.5e8`).
     *   - Removing an explicitly-provided zero exponent (`2.5e0` -> `2.5`).
     * Services **may** perform additional normalization based on its own needs
     * and the internal decimal implementation selected, such as shifting the
     * decimal point and exponent value together (example: `2.5e-1` <-> `0.25`).
     * Additionally, services **may** preserve trailing zeroes in the fraction
     * to indicate increased precision, but are not required to do so.
     * Note that only the `.` character is supported to divide the integer
     * and the fraction; `,` **should not** be supported regardless of locale.
     * Additionally, thousand separators **should not** be supported. If a
     * service does support them, values **must** be normalized.
     * The ENBF grammar is:
     *     DecimalString =
     *       [Sign] Significand [Exponent];
     *     Sign = '+' | '-';
     *     Significand =
     *       Digits ['.'] [Digits] | [Digits] '.' Digits;
     *     Exponent = ('e' | 'E') [Sign] Digits;
     *     Digits = { '0' | '1' | '2' | '3' | '4' | '5' | '6' | '7' | '8' | '9' };
     * Services **should** clearly document the range of supported values, the
     * maximum supported precision (total number of digits), and, if applicable,
     * the scale (number of digits after the decimal point), as well as how it
     * behaves when receiving out-of-bounds values.
     * Services **may** choose to accept values passed as input even when the
     * value has a higher precision or scale than the service supports, and
     * **should** round the value to fit the supported scale. Alternatively, the
     * service **may** error with `400 Bad Request` (`INVALID_ARGUMENT` in gRPC)
     * if precision would be lost.
     * Services **should** error with `400 Bad Request` (`INVALID_ARGUMENT` in
     * gRPC) if the service receives a value outside of the supported range.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     */
    protected $value = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value
     *           The decimal value, as a string.
     *           The string representation consists of an optional sign, `+` (`U+002B`)
     *           or `-` (`U+002D`), followed by a sequence of zero or more decimal digits
     *           ("the integer"), optionally followed by a fraction, optionally followed
     *           by an exponent.
     *           The fraction consists of a decimal point followed by zero or more decimal
     *           digits. The string must contain at least one digit in either the integer
     *           or the fraction. The number formed by the sign, the integer and the
     *           fraction is referred to as the significand.
     *           The exponent consists of the character `e` (`U+0065`) or `E` (`U+0045`)
     *           followed by one or more decimal digits.
     *           Services **should** normalize decimal values before storing them by:
     *             - Removing an explicitly-provided `+` sign (`+2.5` -> `2.5`).
     *             - Replacing a zero-length integer value with `0` (`.5` -> `0.5`).
     *             - Coercing the exponent character to lower-case (`2.5E8` -> `2.5e8`).
     *             - Removing an explicitly-provided zero exponent (`2.5e0` -> `2.5`).
     *           Services **may** perform additional normalization based on its own needs
     *           and the internal decimal implementation selected, such as shifting the
     *           decimal point and exponent value together (example: `2.5e-1` <-> `0.25`).
     *           Additionally, services **may** preserve trailing zeroes in the fraction
     *           to indicate increased precision, but are not required to do so.
     *           Note that only the `.` character is supported to divide the integer
     *           and the fraction; `,` **should not** be supported regardless of locale.
     *           Additionally, thousand separators **should not** be supported. If a
     *           service does support them, values **must** be normalized.
     *           The ENBF grammar is:
     *               DecimalString =
     *                 [Sign] Significand [Exponent];
     *               Sign = '+' | '-';
     *               Significand =
     *                 Digits ['.'] [Digits] | [Digits] '.' Digits;
     *               Exponent = ('e' | 'E') [Sign] Digits;
     *               Digits = { '0' | '1' | '2' | '3' | '4' | '5' | '6' | '7' | '8' | '9' };
     *           Services **should** clearly document the range of supported values, the
     *           maximum supported precision (total number of digits), and, if applicable,
     *           the scale (number of digits after the decimal point), as well as how it
     *           behaves when receiving out-of-bounds values.
     *           Services **may** choose to accept values passed as input even when the
     *           value has a higher precision or scale than the service supports, and
     *           **should** round the value to fit the supported scale. Alternatively, the
     *           service **may** error with `400 Bad Request` (`INVALID_ARGUMENT` in gRPC)
     *           if precision would be lost.
     *           Services **should** error with `400 Bad Request` (`INVALID_ARGUMENT` in
     *           gRPC) if the service receives a value outside of the supported range.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Type\Decimal::initOnce();
        parent::__construct($data);
    }
    /**
     * The decimal value, as a string.
     * The string representation consists of an optional sign, `+` (`U+002B`)
     * or `-` (`U+002D`), followed by a sequence of zero or more decimal digits
     * ("the integer"), optionally followed by a fraction, optionally followed
     * by an exponent.
     * The fraction consists of a decimal point followed by zero or more decimal
     * digits. The string must contain at least one digit in either the integer
     * or the fraction. The number formed by the sign, the integer and the
     * fraction is referred to as the significand.
     * The exponent consists of the character `e` (`U+0065`) or `E` (`U+0045`)
     * followed by one or more decimal digits.
     * Services **should** normalize decimal values before storing them by:
     *   - Removing an explicitly-provided `+` sign (`+2.5` -> `2.5`).
     *   - Replacing a zero-length integer value with `0` (`.5` -> `0.5`).
     *   - Coercing the exponent character to lower-case (`2.5E8` -> `2.5e8`).
     *   - Removing an explicitly-provided zero exponent (`2.5e0` -> `2.5`).
     * Services **may** perform additional normalization based on its own needs
     * and the internal decimal implementation selected, such as shifting the
     * decimal point and exponent value together (example: `2.5e-1` <-> `0.25`).
     * Additionally, services **may** preserve trailing zeroes in the fraction
     * to indicate increased precision, but are not required to do so.
     * Note that only the `.` character is supported to divide the integer
     * and the fraction; `,` **should not** be supported regardless of locale.
     * Additionally, thousand separators **should not** be supported. If a
     * service does support them, values **must** be normalized.
     * The ENBF grammar is:
     *     DecimalString =
     *       [Sign] Significand [Exponent];
     *     Sign = '+' | '-';
     *     Significand =
     *       Digits ['.'] [Digits] | [Digits] '.' Digits;
     *     Exponent = ('e' | 'E') [Sign] Digits;
     *     Digits = { '0' | '1' | '2' | '3' | '4' | '5' | '6' | '7' | '8' | '9' };
     * Services **should** clearly document the range of supported values, the
     * maximum supported precision (total number of digits), and, if applicable,
     * the scale (number of digits after the decimal point), as well as how it
     * behaves when receiving out-of-bounds values.
     * Services **may** choose to accept values passed as input even when the
     * value has a higher precision or scale than the service supports, and
     * **should** round the value to fit the supported scale. Alternatively, the
     * service **may** error with `400 Bad Request` (`INVALID_ARGUMENT` in gRPC)
     * if precision would be lost.
     * Services **should** error with `400 Bad Request` (`INVALID_ARGUMENT` in
     * gRPC) if the service receives a value outside of the supported range.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * The decimal value, as a string.
     * The string representation consists of an optional sign, `+` (`U+002B`)
     * or `-` (`U+002D`), followed by a sequence of zero or more decimal digits
     * ("the integer"), optionally followed by a fraction, optionally followed
     * by an exponent.
     * The fraction consists of a decimal point followed by zero or more decimal
     * digits. The string must contain at least one digit in either the integer
     * or the fraction. The number formed by the sign, the integer and the
     * fraction is referred to as the significand.
     * The exponent consists of the character `e` (`U+0065`) or `E` (`U+0045`)
     * followed by one or more decimal digits.
     * Services **should** normalize decimal values before storing them by:
     *   - Removing an explicitly-provided `+` sign (`+2.5` -> `2.5`).
     *   - Replacing a zero-length integer value with `0` (`.5` -> `0.5`).
     *   - Coercing the exponent character to lower-case (`2.5E8` -> `2.5e8`).
     *   - Removing an explicitly-provided zero exponent (`2.5e0` -> `2.5`).
     * Services **may** perform additional normalization based on its own needs
     * and the internal decimal implementation selected, such as shifting the
     * decimal point and exponent value together (example: `2.5e-1` <-> `0.25`).
     * Additionally, services **may** preserve trailing zeroes in the fraction
     * to indicate increased precision, but are not required to do so.
     * Note that only the `.` character is supported to divide the integer
     * and the fraction; `,` **should not** be supported regardless of locale.
     * Additionally, thousand separators **should not** be supported. If a
     * service does support them, values **must** be normalized.
     * The ENBF grammar is:
     *     DecimalString =
     *       [Sign] Significand [Exponent];
     *     Sign = '+' | '-';
     *     Significand =
     *       Digits ['.'] [Digits] | [Digits] '.' Digits;
     *     Exponent = ('e' | 'E') [Sign] Digits;
     *     Digits = { '0' | '1' | '2' | '3' | '4' | '5' | '6' | '7' | '8' | '9' };
     * Services **should** clearly document the range of supported values, the
     * maximum supported precision (total number of digits), and, if applicable,
     * the scale (number of digits after the decimal point), as well as how it
     * behaves when receiving out-of-bounds values.
     * Services **may** choose to accept values passed as input even when the
     * value has a higher precision or scale than the service supports, and
     * **should** round the value to fit the supported scale. Alternatively, the
     * service **may** error with `400 Bad Request` (`INVALID_ARGUMENT` in gRPC)
     * if precision would be lost.
     * Services **should** error with `400 Bad Request` (`INVALID_ARGUMENT` in
     * gRPC) if the service receives a value outside of the supported range.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;
        return $this;
    }
}
