<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TransactionStatus extends Enum
{
    const WaitSellerConfirm = 1; // seller confirm -> UI (màn hình list giao dịch (có nút confirm)) -> API confirm giao dịch
    const Trading = 2;
    const Done = 3; // both seller and buyer approve -> change to here
    const Cancelled = 4;
}
