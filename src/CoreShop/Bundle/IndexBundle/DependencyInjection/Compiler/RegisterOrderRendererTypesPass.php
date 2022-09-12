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

namespace CoreShop\Bundle\IndexBundle\DependencyInjection\Compiler;

use CoreShop\Component\Registry\RegisterSimpleRegistryTypePass;

class RegisterOrderRendererTypesPass extends RegisterSimpleRegistryTypePass
{
    public const INDEX_ORDER_RENDERER_TAG = 'coreshop.index.order.renderer';

    public function __construct()
    {
        parent::__construct(
            'coreshop.registry.index.order.renderers',
            'coreshop.index.order.renderers',
            self::INDEX_ORDER_RENDERER_TAG,
        );
    }
}
