<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\VeniaCmsSampleData\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
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
     * @var \MagentoEse\VeniaCmsSampleData\Model\Bluefoot
     */
    private $bluefoot;

    /**
     * @param \MagentoEse\VeniaCmsSampleData\Model\Page $page
     * @param \MagentoEse\VeniaCmsSampleData\Model\Block $block
     * @param \MagentoEse\VeniaCmsSampleData\Model\Bluefoot $bluefoot

     */
    public function __construct(
        \MagentoEse\VeniaCmsSampleData\Model\Page $page,
        \MagentoEse\VeniaCmsSampleData\Model\Block $block
        //\MagentoEse\VeniaCmsSampleData\Model\Bluefoot $bluefoot

    ) {
        //$this->category = $category;
        $this->page = $page;
        $this->block = $block;
        //$this->category = $bluefoot;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->page->install(['MagentoEse_VeniaCmsSampleData::fixtures/pages.csv']);
        $this->block->install(['MagentoEse_VeniaCmsSampleData::fixtures/blocks.csv']);
        //$this->Category->install(['MagentoEse_VeniaCmsSampleData::fixtures/bluefoot.csv']);
    }
}
