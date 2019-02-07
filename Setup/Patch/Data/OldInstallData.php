<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\VeniaCmsSampleData\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;


class OldInstallData implements DataPatchInterface,PatchVersionInterface
{


    /**
     * @var \MagentoEse\VeniaCmsSampleData\Model\Page
     */
    private $page;

    /**
     * @var \MagentoEse\VeniaCmsSampleData\Model\Block
     */
    private $block;


    /**
     * @param \MagentoEse\VeniaCmsSampleData\Model\Page $page
     * @param \MagentoEse\VeniaCmsSampleData\Model\Block $block
     */
    public function __construct(
        \MagentoEse\VeniaCmsSampleData\Model\Page $page,
        \MagentoEse\VeniaCmsSampleData\Model\Block $block

    ) {
        $this->page = $page;
        $this->block = $block;
    }

    public function apply()
    {
        $this->page->install(['MagentoEse_VeniaCmsSampleData::fixtures/pages.csv']);
        $this->block->install(['MagentoEse_VeniaCmsSampleData::fixtures/blocks.csv']);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
    public static function getVersion()
    {
        return '0.0.3';
    }
}