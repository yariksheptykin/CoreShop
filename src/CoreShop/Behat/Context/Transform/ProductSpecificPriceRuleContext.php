<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Product\Model\ProductSpecificPriceRuleInterface;
use CoreShop\Component\Product\Repository\ProductSpecificPriceRuleRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductSpecificPriceRuleContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private ProductSpecificPriceRuleRepositoryInterface $productSpecificPriceRuleRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        ProductSpecificPriceRuleRepositoryInterface $productSpecificPriceRuleRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->productSpecificPriceRuleRepository = $productSpecificPriceRuleRepository;
    }

    /**
     * @Transform /^specific price rule "([^"]+)"$/
     */
    public function getPriceRuleByProductAndName($ruleName)
    {
        $rule = $this->productSpecificPriceRuleRepository->findOneBy(['name' => $ruleName]);

        Assert::isInstanceOf($rule, ProductSpecificPriceRuleInterface::class);

        return $rule;
    }

    /**
     * @Transform /^(specific price rule)$/
     */
    public function getLatestSpecificPriceRule()
    {
        $resource = $this->sharedStorage->getLatestResource();

        Assert::isInstanceOf($resource, ProductSpecificPriceRuleInterface::class);

        return $resource;
    }
}
