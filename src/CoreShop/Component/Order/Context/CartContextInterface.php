<?php
declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Component\Order\Context;

use CoreShop\Component\Order\Model\OrderInterface;
use CoreShop\Component\StorageList\Context\StorageListContextInterface;

interface CartContextInterface extends StorageListContextInterface
{
    /**
     * @throws CartNotFoundException
     */
    public function getCart(): OrderInterface;

    /**
     * @throws CartNotFoundException
     */
    public function getStorageList(): OrderInterface;
}
